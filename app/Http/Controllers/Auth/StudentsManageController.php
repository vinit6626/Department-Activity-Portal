<?php 
namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Session;
class StudentsManageController extends Controller
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
    public function verify_student(Request $request)
    {
    	$student=Student::find($request->verify_student_id);
    	$student->is_verified=1;
    	$student->save();
    	return redirect('admin/show/students/unverified')->with('student_verified','Verified Successfully');
    }
    public function make_unverify_student(Request $request)
    {
    	$student=Student::find($request->unverify_student_id);
    	$student->is_verified=0;
    	$student->save();
    	return redirect('admin/show/students/verified')->with('student_unverified','Unverified Successfully');
    }
	public function show_unverified_students(Request $request)
	{
		$admin=$this->givePersonalInfo();
		$students=Student::select('student_id','name','admission_year','admission_type','enrollment_no')
			->where('is_verified',0)
			->where('department',$admin['department'])
			->orderBy('created_at','desc')
			->get();
		return view('auth.show_unverified_students',compact('admin','students'));
	}
	public function show_verified_students()
	{
		$admin=$this->givePersonalInfo();
		$students=Student::select('student_id','name','admission_year','admission_type','enrollment_no')
			->where('is_verified',1)
			->where('department',$admin['department'])
			->orderBy('created_at','desc')
			->get();
		return view('auth.show_verified_students',compact('admin','students'));
	}
	public function show_student_profile()
	{

	}
}
?>