<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Faculty;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    //this $redirectTo is not working here. we have externally redirected in redirect_register() method 
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest');
    }*/

    function getUniqueAdminID()
    {
        $rand=mt_rand(1000000,9999999);
        if(User::where('admin_id','=',$rand)->exists())
        {
            $this->getUniqueAdminID();
        }
        return $rand;    
    }

    function getUniqueFacultyID()
    {
        $rand=mt_rand(1000000,9999999);
        if(Faculty::where('faculty_id','=',$rand)->exists())
        {
            $this->getUniqueFacultyID();
        }
        return $rand;    
    }

    public function redirect_register(Request $request)
    {
        //this is where initial post data will come and unique admin id will be appended here.
        $uniqueAdminID=$this->getUniqueAdminID();
        $request->request->add(['admin_id'=>$uniqueAdminID]);
        
        $this->register($request);

        //we needed to write this externally because $redirectTo not working here. It is returning to current function.
        return redirect('admin/dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50|regex:/^[a-zA-Z]+\s[a-zA-Z]+\s[a-zA-Z]+$/',
            'email' => 'required|string|email|max:40|unique:users|unique:students,email|unique:faculties,email',
            'password' => 'required|string|min:6|confirmed',
            'contact_no' => 'required|unique:users|unique:students,contact_no|unique:faculties,contact_no|digits:10',
            'admin_id' => 'required|unique:users',
            'department'=> 'required|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
    	$to=$data['email'];
        $subject='Registration Successful';
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
        <title></title>
        <style>
            table {
                border-collapse: collapse;
                }

            th, td {
                text-align: center;
                padding: 8px;
            }

            th{
                border:1px solid #f2f2f2;
            }
            td{
                border:1px solid #f2f2f2;
            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
                background-color: #4CAF50;
                color: white;
            }
        </style>
        </head>

        <body>
        <p>You have successfully registered to Department Activity Portal, BVM Engineering College.</p>
        <p>Here are your login id and password.</p>
        <table>
        <tr>
        <th>ID</th>
        <th>Password</th>
        </tr>
        <tr>
        <td>".$data['email']."</td>
        <td>".$data['password']."</td>
        </tr>
        </table>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";

        // More headers
        $headers .= "From:".$data['email']."\r\n";


        $test=mail($to, $subject, $message, $headers);

		$uniq_facultyid=$this->getUniqueFacultyID();
    	Faculty::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'faculty_id'=> $uniq_facultyid,
            'department'=>$data['department'],
            'contact_no'=>$data['contact_no'],
        ]);

        $admin= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'admin_id'=> $data['admin_id'],
            'department'=>$data['department'],
            'contact_no'=>$data['contact_no'],
        ]);

        return $admin;

    }
}
