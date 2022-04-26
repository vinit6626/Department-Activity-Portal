<?php

namespace App\Http\Controllers\StudentAuth;

use App\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/student/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest');
    }*/
     protected function guard()
    {
        return auth()->guard('student');
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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z]+\s[a-zA-Z]+\s[a-zA-Z]+$/',
            'email' => 'required|string|email|max:255|required|unique:students|unique:faculties,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'student_id' => 'required|unique:students|regex:/^[0-9]{2}[A-Z]{2}[0-9]{3}$/',
            'enrollment_no' => 'nullable|unique:students|digits:12',
            'contact_no'=> 'required|unique:students|unique:faculties,contact_no|unique:users,contact_no|digits:10',
            'admission_year'=> 'required|digits:4',
            'department'=> 'required',
            'admission_type'=> 'required',
        ]);
    }

    /**
    HERE WE ARE OVERRIDING METHOD BCZ DEFAULT HAVE ONLY 3 COLUMNS ONLY
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Student
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

        return Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'student_id' => $data['student_id'],
            'enrollment_no' => $data['enrollment_no'],
            'contact_no' => $data['contact_no'],
            'admission_year' => $data['admission_year'],
            'department' => $data['department'],
            'admission_type' => $data['admission_type'],
        ]);
    }

    

    public function showRegistrationForm()
    {
        return view('Student.register');
    }
}
