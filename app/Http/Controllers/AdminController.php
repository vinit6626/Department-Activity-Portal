<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:web');
        //custom Redirect route is defined in App/Exception/Handler.php render() function.
    } 

    public function givePersonalInfo()
    {
        if(Auth::user())
        {
            $adminInfo=Auth::user();
            return $adminInfo;            
        }

    }     
    public function index()
    {
        $admin=$this->givePersonalInfo();
        return view('Auth.admin_dash',compact('admin'));    
    }

    public function editprofile()
    {
        $admin=$this->givePersonalInfo();
        return view('Auth.admin_edit_profile',compact('admin'));
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
        $current_admin_id=Auth::user()->admin_id;
        $rules=[
            'email' => "bail|required|string|email|max:40|unique:users,email,$current_admin_id,admin_id",
            //this is used when updating profile, we want to ignore unique validation if entered email of logged user is same as previous.
            //first parameter table name, second is field name, third is the user for which we want to ignore unique validaton, write forth if primary key of table is different than 'id'.
            //use double quote("") for rule otherwise $current_admin_id will be considered as string not variable.
            'contact_no' => "bail|required|digits:10|unique:users,contact_no,$current_admin_id,admin_id",
            'new_profile'=>'bail|mimes:jpeg,jpg,png',

        ];
        $this->validate($request,$rules,$customMessages);
        
        $admin = User::find(Auth::user()->admin_id);
        // or $admin=Auth::user();
        $admin->email=$request->email;
        $admin->contact_no=$request->contact_no;
        
        if($request->has('new_profile'))
        {
            $file = $request->file('new_profile') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\images\profiles\admins\\';
            File::delete(''.$destinationPath."".$admin->profile_image.'');
            $file->move($destinationPath,''.$admin->admin_id.'.'.$extension.'');
            $admin->profile_image=''.$admin->admin_id.'.'.$extension.'';
        }
        $admin->save();
        Session::flash('success_message', 'Profile updated successfully');
        return redirect('admin/profile/edit');

    }


    public function change_password_showform()
    {
        $admin=$this->givePersonalInfo();
        return view('auth.change_password_form',compact('admin'));
    }
    public function change_password(Request $request)
    {
       $this->validate($request, [
        'old_password'     => 'required',
        'new_password'     => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
        ]);

        $admin=$this->givePersonalInfo();
        $data = $request->all();
        if(!Hash::check($data['old_password'], $admin['password'])){
            return back()->with('password_not_available','The specified password does not match the database password')->withInput();
        }
        else{
            Auth::user()->password=Hash::make($request['new_password']);
            Auth::user()->save();
            return redirect()->back()->with('success_message','Password has successfully changed'); 
        }        
    }
}
