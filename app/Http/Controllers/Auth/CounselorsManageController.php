<?php 
namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use App\Faculty;
use App\Student;
use Illuminate\Http\Request;
use Session;
use App\Counselor;

class CounselorsManageController extends Controller
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
    public function showAllCounselors()
    {
        $admin=$this->givePersonalInfo();
        $counselors=Counselor::selectRaw('counselor_students.student_id,faculties.name,students.admission_year,students.admission_type')
        ->join('students','students.student_id','=','counselor_students.student_id')
        ->join('faculties','faculties.faculty_id','=','counselor_students.faculty_id')
        ->orderBy('counselor_students.sr_no','asc')
        ->where('counselor_students.status',1)
        ->get();

        $list_of_counselors=Faculty::select('name')->where('is_counselor',1)->get();
        return view('auth.show_all_counselors',compact('admin','counselors','list_of_counselors'));
    }
    public function manageCounselors()
    {
        $admin=$this->givePersonalInfo();
        $counselors=Faculty::select('faculty_id','name','email','contact_no')->where('is_counselor',1)->where('department',$admin['department'])->orderBy('name','asc')->get();
        return view('auth.manage_counselors',compact('admin','counselors'));
    }
    public function removeCounselor(Request $request)
    {
        $faculty_id=$request->faculty_id;
        
        $faculty_obj=Faculty::find($faculty_id);
        $faculty_obj->is_counselor=0;
        $faculty_obj->save();

        Counselor::where('faculty_id',$faculty_id)->delete();

        return redirect('admin/counselors/manage')->with('success_message','Counselor removed successfully'); 

    }
    public function create_counselor_form()
    {
    	$admin=$this->givePersonalInfo();
    	$non_counselors=Faculty::select('faculty_id','name')->where('is_counselor',0)
    		->where('is_verified',1)->where('department',$admin['department'])->orderBy('name','asc')->get();
    	return view('auth.create_counselor_form',compact('admin','non_counselors'));
    }


    public function create_counselor(Request $request)
    {
    	$faculty_id=$request->faculty_id;

    	$student_ids=$request->student;
       
        
        $faculty=Faculty::find($request->faculty_id);

        $faculty->is_counselor=1;
        $faculty->save();
        
        foreach ($student_ids as  $student_id){
            $Counselor_obj=new Counselor;
            $Counselor_obj->faculty_id=$faculty_id;
            $Counselor_obj->student_id=$student_id; 
            $Counselor_obj->status=1;
            $Counselor_obj->save(); 
        }

    	return redirect('admin/add/counselor')->with('success_message','Counselor assigned Successfully');

    }
    public function get_students(Request $request)
    {
        $changeYear=0;
        $currentYear=date('Y');
        $currentMonth=date('m');
        if($currentMonth>=7)
        {
            $changeYear=1;
        }
        $year_of_student=$request->student_year;

        
        $adYearRegular=$currentYear-$year_of_student+$changeYear;
        $adYearD2D=$currentYear-$year_of_student+1+$changeYear;

        $students=Student::select('student_id')->where([['admission_year','=',$adYearRegular],['admission_type','=','REGULAR'],['department','=',Auth::user()->department]])->orWhere([['admission_year','=',$adYearD2D],['admission_type','=','D2D'],['department','=',Auth::user()->department]])->get();
        
        $students_id_array=array();
        foreach($students as $student)
        {
            if(Counselor::where([['student_id',$student->student_id],['status',1]])->exists())
            {
                continue;
            }  
            else{
                array_push($students_id_array,$student['student_id']);                
            }          
        } 
        return $students_id_array;
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