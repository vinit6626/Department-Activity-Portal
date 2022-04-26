<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
        //custom Redirect route is defined in App/Exception/Handler.php render() function.
    }    
    public function givePersonalInfo()
    {
        if(Auth::user())
        {
            $studentInfo=Auth::user();
            return $studentInfo;            
        }

    }    
    public function index()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_dash',compact('student'));    
    }

    public function showprofile()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_profile',compact('student'));   
    }


    public function editprofile()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_edit_profile',compact('student'));
    }
    public function updateprofile(Request $request)
    {
        $customMessages = [
        'email.required' => 'Please enter email address',
        'email.email' =>'Please enter proper email',
        'contact_no.required' => 'Please enter contact number',
        'contact.numeric' => 'Contact number should be in digits.',
        'contact.digits' => 'Contact number should be in 10 digits.',
        'profile_image.mimes' => 'Result image should be in jpeg, jpg or png format',

        ];
        $current_student_id=Auth::user()->student_id;
        $rules=[
            'email' => "bail|required|string|email|max:40|unique:students,email,$current_student_id,student_id",
            //this is used when updating profile, we want to ignore unique validation if entered email of logged user is same as previous.
            //first parameter table name, second is field name, third is the user for which we want to ignore unique validaton, write forth if primary key of table is different than 'id'.
            //use double quote("") for rule otherwise $current_student_id will be considered as string not variable.
            'contact_no' => "bail|required|digits:10|unique:students,contact_no,$current_student_id,student_id",
            'new_profile'=>'bail|mimes:jpeg,jpg,png',

        ];
        $this->validate($request,$rules,$customMessages);
        
        $student = Student::find(Auth::user()->student_id);
        // or $student=Auth::user();
        $student->email=$request->email;
        $student->contact_no=$request->contact_no;
        
        if($request->has('new_profile'))
        {
            $file = $request->file('new_profile') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\images\profiles\students\\';
            File::delete(''.$destinationPath."".$student->profile_image.'');
            $file->move($destinationPath,''.$student->student_id.'.'.$extension.'');
            $student->profile_image=''.$student->student_id.'.'.$extension.'';
        }
        $student->save();
        Session::flash('success_message', 'Profile updated successfully');
        return redirect('student/profile/edit');

    }


    public function change_password_showform()
    {
        $student=$this->givePersonalInfo();
        return view('student.change_password_form',compact('student'));
    }
    public function change_password(Request $request)
    {
       $this->validate($request, [
        'old_password'     => 'required',
        'new_password'     => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
        ]);

        $student=$this->givePersonalInfo();
        $data = $request->all();
        if(!Hash::check($data['old_password'], $student['password'])){
            return back()->with('password_not_available','The specified password does not match the database password')->withInput();
        }
        else{
            Auth::user()->password=Hash::make($request['new_password']);
            Auth::user()->save();
            return redirect()->back()->with('success_message','Password has successfully changed'); 
        }        
    }
}
