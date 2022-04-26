<?php

namespace App\Http\Controllers;
use App\Faculty;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;
use App\Faculty_Notifications;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:faculty');
        //custom Redirect route is defined in App/Exception/Handler.php render() function.
    }

    public function givePersonalInfo()
    {
        if(Auth::user())
        {
            $facultyInfo=Auth::user();
            return $facultyInfo;            
        }

    }    
    
    public function index()
    {
        $faculty=$this->givePersonalInfo();

        $notifications=Faculty_Notifications::selectRaw('faculty_organized_activities.*,faculty_notifications.*,faculties.name')->where('to_faculty',$faculty->faculty_id)
        ->join('faculty_organized_activities','faculty_organized_activities.sr_no','faculty_notifications.organized_activity_no')
        ->join('faculties','faculties.faculty_id','faculty_notifications.from_faculty')
        ->orderBy('faculty_notifications.created_at','desc')
        ->get();

        return view('Faculty.faculty_dash',compact('faculty','notifications'));    
    }

    public function delete_notification(Request $request)
    {
        $notification_id=$request['notification_id'];
        $notification=Faculty_Notifications::find($notification_id);
        $notification->delete();
    }

    public function showprofile()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_profile',compact('faculty'));            
    }

    public function editprofile()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_edit_profile',compact('faculty'));
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
        $current_faculty_id=Auth::user()->faculty_id;
        $rules=[
            'email' => "bail|required|string|email|max:40|unique:faculties,email,$current_faculty_id,faculty_id",
            //this is used when updating profile, we want to ignore unique validation if entered email of logged user is same as previous.
            //first parameter table name, second is field name, third is the user for which we want to ignore unique validaton, write forth if primary key of table is different than 'id'.
            //use double quote("") for rule otherwise $current_faculty_id will be considered as string not variable.
            'contact_no' => "bail|required|digits:10|unique:faculties,contact_no,$current_faculty_id,faculty_id",
            'new_profile'=>'bail|mimes:jpeg,jpg,png',

        ];
        $this->validate($request,$rules,$customMessages);
        
        $faculty = Faculty::find(Auth::user()->faculty_id);
        // or $faculty=Auth::user();
        $faculty->email=$request->email;
        $faculty->contact_no=$request->contact_no;
        
        if($request->has('new_profile'))
        {
            $file = $request->file('new_profile') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\images\profiles\faculties\\';
            File::delete(''.$destinationPath."".$faculty->profile_image.'');
            $file->move($destinationPath,''.$faculty->faculty_id.'.'.$extension.'');
            $faculty->profile_image=''.$faculty->faculty_id.'.'.$extension.'';
        }
        $faculty->save();
        Session::flash('success_message', 'Profile updated successfully');
        return redirect('faculty/profile/edit');

    }


    public function change_password_showform()
    {
        $faculty=$this->givePersonalInfo();
        return view('faculty.change_password_form',compact('faculty'));
    }
    public function change_password(Request $request)
    {
       $this->validate($request, [
        'old_password'     => 'required',
        'new_password'     => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
        ]);

        $faculty=$this->givePersonalInfo();
        $data = $request->all();
        if(!Hash::check($data['old_password'], $faculty['password'])){
            return back()->with('password_not_available','The specified password does not match the database password')->withInput();
        }
        else{
            Auth::user()->password=Hash::make($request['new_password']);
            Auth::user()->save();
            return redirect()->back()->with('success_message','Password has successfully changed'); 
        }        
    }

    
}
