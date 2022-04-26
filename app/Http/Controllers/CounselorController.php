<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;
use App\Faculty;
use App\Student;
use App\Counselor;
use App\Student_Results;
class CounselorController extends Controller
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
        return view('Faculty.counselor_dash',compact('faculty'));    
    }

    public function showallstudents()
    {
        $faculty=$this->givePersonalInfo();

        $students=Counselor::selectRaw('students.*,counselor_students.student_id')->join('students','students.student_id','=','counselor_students.student_id')
            ->where('counselor_students.faculty_id',Auth::user()->faculty_id)
            ->where('status',1)
            ->get();

        return view('Faculty.counselor_show_students',compact('faculty','students')); 
    }

    public function show_add_result_form()
    {
        $faculty=$this->givePersonalInfo();
        $students=Counselor::select('student_id')
            ->where('counselor_students.faculty_id',Auth::user()->faculty_id)
            ->where('status',1)
            ->get();
        return view('Faculty.counselor_add_result',compact('faculty','students')); 
    }
    public function add_result(Request $request)
    {
        $student_id=$request->student_id;
        $semester=$request->semester;
        $spi=$request->spi;
        $cpi=$request->cpi;

        $table_spi_column="spi_".$semester."";
        $table_cpi_column="cpi_".$semester."";


        if(Student_Results::where('student_id','=',$student_id)->exists())
        {
            $student_row=Student_Results::select('sr_no')->where('student_id','=',$student_id)->first();
            $update_row=Student_Results::find($student_row['sr_no']);
            $update_row->$table_spi_column=number_format((float)$spi, 2, '.', '');
            $update_row->$table_cpi_column=number_format((float)$cpi, 2, '.', '');
            $update_row->save();
        }
        else
        {
            $result=new Student_Results;
            $result->student_id=$student_id;
            $result->$table_spi_column=number_format((float)$spi, 2, '.', '');;
            $result->$table_cpi_column=number_format((float)$cpi, 2, '.', '');;
            $result->save();
        }

        return back()->with('success_message','Result Added Successfully');

    }

    public function manage_results()
    {
        $faculty=$this->givePersonalInfo();

        $students=Counselor::selectRaw('counselor_students.student_id')->where('counselor_students.faculty_id',Auth::user()->faculty_id)
            ->where('status',1)
            ->get();

        //pluck() is used to get values as an array from one singl columnn from eloquent collection object.
        $student_ids_array=$students->pluck('student_id');

        //whereIn is used to get rows from values inside array.
        $results=Student_Results::whereIn('student_id',$student_ids_array)
            ->orderBy('student_id','asc')
            ->get();
        return view('Faculty.counselor_manage_results',compact('faculty','results'));
    }
    public function edit_results_form()
    {
        $faculty=$this->givePersonalInfo();

        //Those student ids under current logged couselor
        $students=Counselor::selectRaw('counselor_students.student_id')->where('counselor_students.faculty_id',Auth::user()->faculty_id)
            ->get();

        //pluck() is used to get values as an array from one singl columnn from eloquent collection object.
        $student_ids_array=$students->pluck('student_id');

        //Those students whose results are added in table
        $results_student_ids=Student_Results::select('student_id')->whereIn('student_id',$student_ids_array)
            ->orderBy('student_id','asc')
            ->get();
        return view('Faculty.counselor_edit_results_form',compact('faculty','results_student_ids'));

    }
    public function fetch_result(Request $request)
    {
        $student_id=$request->student_id;
        $semester=$request->semester;
        $table_spi_column="spi_".$semester."";
        $table_cpi_column="cpi_".$semester."";

        $result=Student_Results::select($table_spi_column,$table_cpi_column)
        ->where('student_id',$student_id)
        ->first();

        if($result[$table_spi_column]=='' || $result[$table_cpi_column]=='')
        {
            echo "<script>alert('Result not added'); $('#fetch_result').show();
          $('#student_id').prop('disabled',false);
          $('#semester').prop('disabled',false);</script>";
            //return redirect()->back()->withErrors(['no_results'=>'Result of '.$student_id.' for '.$semester.' is not added']);
        }

        else
        {
        echo " <div class=\"form-group\">
            <label class=\"col-md-3 control-label\">SPI:</label>
            <div class=\"col-md-8\">
                <input name=\"spi\" value=\"$result[$table_spi_column]\" ng-model=\"spi\" class=\"form-control\" type=\"number\" min=\"0\" max=\"10\" step=\"any\" required autofocus/>
            </div>
        </div>

        <div class=\"form-group\">
            <label class=\"col-md-3 control-label\">CPI:</label>
            <div class=\"col-md-8\">
                <input name=\"cpi\" value=\"$result[$table_cpi_column]\" ng-model=\"cpi\" class=\"form-control\" type=\"number\" min=\"0\" max=\"10\" step=\"any\" required autofocus/>
            </div>
        </div>

        <div class=\"form-group\">
            <label class=\"col-md-3 control-label\"></label>
            <div class=\"col-md-8\">
            <button type=\"button\" id=\"submit_form\" class=\"btn btn-primary\">Submit</button>
            <span></span>
            </div>
        </div>

        ";
        }

    }
    public function edit_result(Request $request)
    {
        echo $student_id=$request->student_id;
        echo $semester=$request->semester;
        echo $spi=$request->spi;
        echo $cpi=$request->cpi;
        $table_spi_column="spi_".$semester."";
        $table_cpi_column="cpi_".$semester."";
        
        $student_row=Student_Results::select('sr_no')->where('student_id','=',$student_id)->first();

        $update_row=Student_Results::find($student_row['sr_no']);
        $update_row->$table_spi_column=number_format((float)$spi, 2, '.', '');
        $update_row->$table_cpi_column=number_format((float)$cpi, 2, '.', '');
        $update_row->save();
        return back()->with('success_message','Result updated successfully');
    }


   
}
