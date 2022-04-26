<?php 
namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use App\Faculty;
use Illuminate\Http\Request;
use Session;

class FacultiesManageController extends Controller
{
	public function _construct()
	{
		$this->middleware('auth');
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
    public function verify_faculty(Request $request)
    {
    	$faculty=Faculty::find($request->verify_faculty_id);
    	$faculty->is_verified=1;
    	$faculty->save();
    	return redirect('admin/show/faculties/unverified')->with('faculty_verified','Verified Successfully');
    }
    public function make_unverify_faculty(Request $request)
    {
    	$faculty=Faculty::find($request->unverify_faculty_id);
    	$faculty->is_verified=0;
    	$faculty->save();
    	return redirect('admin/show/faculties/verified')->with('faculty_unverified','Unverified Successfully');
    }
	public function show_unverified_faculties(Request $request)
	{
		$admin=$this->givePersonalInfo();
		$faculties=Faculty::select('faculty_id','name','email','contact_no')
			->where('is_verified',0)
			->where('department',$admin['department'])
			->orderBy('created_at','desc')
			->get();
		return view('auth.show_unverified_faculties',compact('admin','faculties'));
	}
	public function show_verified_faculties()
	{
		$admin=$this->givePersonalInfo();
		$faculties=Faculty::select('faculty_id','name','email','contact_no')
			->where('is_verified',1)
			->where('department',$admin['department'])
			->orderBy('created_at','desc')
			->get();
		return view('auth.show_verified_faculties',compact('admin','faculties'));
	}
	public function show_faculty_profile()
	{

	}
}
?>