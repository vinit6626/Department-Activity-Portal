<?php

namespace App\Http\Controllers\FacultyAuth;

use App\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/faculty/dashboard';

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    

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
        //this is where initial post data will come and unique faculty id will be appended here.
        $uniqueFacultyID=$this->getUniqueFacultyID();
        $request->request->add(['faculty_id'=>$uniqueFacultyID]);
        
        $this->register($request);

        //we needed to write this externally because $redirectTo not working here. It is returning to current function.
        return redirect('faculty/dashboard');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('guest');
    }*/

    protected function guard()
    {
        return auth()->guard('faculty');
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
            'email' => 'required|string|email|max:40|unique:faculties|unique:students,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'contact_no' => 'required|unique:faculties|unique:students,contact_no|unique:users,contact_no|digits:10',
            'faculty_id' => 'required|unique:faculties',
            'department'=> 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Faculty
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

        return Faculty::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'faculty_id'=> $data['faculty_id'],
            'department'=>$data['department'],
            'contact_no'=>$data['contact_no'],
        ]);
    }

    public function showRegistrationForm()
    {
        return view('Faculty.register');
    }


}
