<?php

namespace App\Http\Controllers;
use App\Faculty;
use App\Student;
use App\User;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;

class ForgetPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function faculty_forget_password_showform()
    {
        return view('Faculty.faculty_forget_password');
    }

    public function faculty_forget_password_data(Request $request)
    {
        $faculty_email=$request['email'];
        if(Faculty::where('email','=',$faculty_email)->exists())
        {
             
            $pool='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $new_password=substr(str_shuffle(str_repeat($pool,7)),0,7);
            $to=$faculty_email;
            $subject='Forget Password';
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
            <p>Your new password is set for Department Activity Portal, BVM Engineering College.</p>
            <p>Here are your login id and new password.</p>
            <table>
            <tr>
            <th>ID</th>
            <th>Password</th>
            </tr>
            <tr>
            <td>".$faculty_email."</td>
            <td>".$new_password."</td>
            </tr>
            </table>
            <p>You can change your password after login using above credentials.</p>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";

            //More headers
            $headers .= "From:".$faculty_email."\r\n";

            
            if(mail($to, $subject, $message, $headers))
            {
                $faculty=Faculty::where('email',$faculty_email)->first();
                $faculty->password=Hash::make($new_password);
                $faculty->save();
                return redirect()->back()->with('success_message','Password has been sent to your email id.');
            }
            else
            {
                return redirect()->back()->with('failure_message','Oops!! We are not able to send you email at current moment. Please Try after sometime.');
            }
        }
        else
        {
             return redirect()->back()->with('failure_message','Entered email does not match our records.');
        }
    }

    public function student_forget_password_showform()
    {
        return view('student.student_forget_password');
    }

    public function student_forget_password_data(Request $request)
    {
        $student_email=$request['email'];
        if(Student::where('email','=',$student_email)->exists())
        {
             
            $pool='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $new_password=substr(str_shuffle(str_repeat($pool,7)),0,7);
            $to=$student_email;
            $subject='Forget Password';
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
            <p>Your new password is set for Department Activity Portal, BVM Engineering College.</p>
            <p>Here are your login id and new password.</p>
            <table>
            <tr>
            <th>ID</th>
            <th>Password</th>
            </tr>
            <tr>
            <td>".$student_email."</td>
            <td>".$new_password."</td>
            </tr>
            </table>
            <p>You can change your password after login using above credentials.</p>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";

            //More headers
            $headers .= "From:".$student_email."\r\n";

            
            if(mail($to, $subject, $message, $headers))
            {
                $student=Student::where('email',$student_email)->first();
                $student->password=Hash::make($new_password);
                $student->save();
                return redirect()->back()->with('success_message','Password has been sent to your email id.');
            }
            else
            {
                return redirect()->back()->with('failure_message','Oops!! We are not able to send you email at current moment. Please Try after sometime.');
            }
        }
        else
        {
             return redirect()->back()->with('failure_message','Entered email does not match our records.');
        }
    }

    public function admin_forget_password_showform()
    {
        return view('auth.admin_forget_password');
    }

    public function admin_forget_password_data(Request $request)
    {
        $admin_email=$request['email'];
        if(User::where('email','=',$admin_email)->exists())
        {
             
            $pool='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $new_password=substr(str_shuffle(str_repeat($pool,7)),0,7);
            $to=$admin_email;
            $subject='Forget Password';
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
            <p>Your new password is set for Department Activity Portal, BVM Engineering College.</p>
            <p>Here are your login id and new password.</p>
            <table>
            <tr>
            <th>ID</th>
            <th>Password</th>
            </tr>
            <tr>
            <td>".$admin_email."</td>
            <td>".$new_password."</td>
            </tr>
            </table>
            <p>You can change your password after login using above credentials.</p>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";

            //More headers
            $headers .= "From:".$admin_email."\r\n";

            
            if(mail($to, $subject, $message, $headers))
            {
                $admin=User::where('email',$admin_email)->first();
                $admin->password=Hash::make($new_password);
                $admin->save();
                return redirect()->back()->with('success_message','Password has been sent to your email id.');
            }
            else
            {
                return redirect()->back()->with('failure_message','Oops!! We are not able to send you email at current moment. Please Try after sometime.');
            }
        }
        else
        {
             return redirect()->back()->with('failure_message','Entered email does not match our records.');
        }
    }        
    
}
