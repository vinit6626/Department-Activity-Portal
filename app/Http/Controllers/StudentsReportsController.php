<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Schema;
use Session;
use File;
use App\Student_Attended;
use App\Student_Organized;
use App\Student_Training_Internship;
use App\Student_Published_Paper;

class StudentsReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
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

    /*-----------Personal Reports-----------*/

    public function generateFacultiesReportsForm()
    {
        $admin=$this->givePersonalInfo();
        $list_of_students=Student::select('student_id','name')->where('department',$admin['department'])->get();

        return view('auth.students_reports_form',compact('admin','list_of_students'));
    }

    /*public function generateFacultiesReports()
    {
        $student=$this->givePersonalInfo();
        $activity="Faculty_Attended";
        $type="all";
        $from_date="2011-02-01";
        $to_date="2020-02-01";
        $academic_year="";
        $academic_semester="";
        $month_and_year="2018-09";
        $year="2017";
        $from_year="";
        $to_year="";*/

    /*public function generateFacultiesReports()
    {
        $admin=$this->givePersonalInfo();
        $student_id="all";
        $activity="Faculty_Attended";
        $type="all";
        $from_date="";
        $to_date="";
        $month_and_year="";
        $academic_year="";
        $academic_semester="";
        $month_and_year="";
        $year="";
        $from_year="";
        $to_year="";*/
    
    public function generateFacultiesReports(Request $request)
    {
        $admin=$this->givePersonalInfo();
        $student_id=$request->student_id;
        $activity=$request['activity'];
        $type=$request['type'];
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];
        $academic_year=$request['academic_year'];
        $academic_semester=$request['academic_semester'];
        $month_and_year=$request['month_and_year'];
        $year=$request['year'];
        $from_year=$request['from_year'];
        $to_year=$request['to_year'];


        if($activity!='all')
        {
            //except activity="all"

            $model_name=app('App\\'.$activity);
            
            //basic-all records of table
            //$q=$model_name::where('student_id','=',$student['student_id']);
            $q=$model_name::query();

            if($type!="all")
            {
                //in case of Attended or organized activities
                $q=$q->where('type','=',$type);
            }
            
            if($from_date!='')
            {
                if($activity=='Student_Published_Paper')
                {

                }
                else
                {
                    $q=$q->where('from_date','>=',$from_date);
                }
            }

            if($to_date!='')
            {
                if($activity=='Student_Published_Paper')
                {
                }
                else
                {
                    $q=$q->where('to_date','<=',$to_date);
                }
                
            }

            if($academic_year!="")
            {
                $q=$q->where('academic_year','=',$academic_year);
            }

            if($academic_semester!="")
            {               
                $q=$q->where('academic_semester','=',$academic_semester);
            }

            if($month_and_year!="")
            {   
                $month=date('m',strtotime($month_and_year));
                $year=date('Y', strtotime($month_and_year));
                if($activity=='Student_Published_Paper')
                {
                    $q=$q->where('publication_month','=',$month)
                        ->where('publication_year','=',$year);
                }
                else
                {
                    $q=$q->where(function($q) use($month,$year){
                            $q->
                                /*where(function ($q) use($month,$year){
                                $q->whereMonth('from_date','=',$month)
                                ->whereYEAR('from_date','=',$year);
                                })

                                ->or
                                */
                                Where(function ($q) use($month,$year){
                                $q->whereMonth('to_date','=',$month)
                                ->whereYEAR('to_date','=',$year);
                                })
                            ;      
                        });
                }            
            }

            if($year!="")
            {   
                if($activity=='Student_Published_Paper')
                {
                    $q=$q->whereYEAR('publication_year','=',$year);
                }
                else
                {
                    $q=$q->whereYEAR('from_date','=',$year);
                }            
            }

            if($from_year!="")
            {   
                if($activity=='Student_Published_Paper')
                {
                    $q=$q->whereYEAR('publication_year','>=',$from_year);
                }
                else
                {
                    /*$q=$q->where(function($q) use($from_year){
                                $q=$q->whereYEAR('from_date','>=',$from_year)
                                    ->whereYEAR('to_date','>=',$from_year);
                            });*/
                    $q=$q->whereYEAR('from_date','>=',$from_year);
                }            
            }

            if($to_year!="")
            {   
                if($activity=='Student_Published_Paper')
                {
                    $q=$q->whereYEAR('publication_year','<=',$to_year);
                }
                else
                {
                    /*$q=$q->where(function($q) use($to_year){
                                $q=$q->whereYEAR('from_date','<=',$to_year)
                                    ->whereYEAR('to_date','<=',$to_year);
                            });*/
                    $q=$q->whereYEAR('from_date','<=',$to_year);
                }            
            }



            //It will fetch results
            if($student_id=="all")
            {
                $q=$q->orderBy('student_id');
            }
            else
            {

                $q=$q->where('student_id','=',$student_id);
            }

            $q=$q->get();
            $all=$q->toArray();
            $columns=[];
            if(empty($all))
            {
                echo "<center><h2>No records matched.</h2></center>";
            }
            else
            {
                    $total_results=count($q);
                    echo "<b><h4>Total: $total_results</h4></b>";
                    foreach ($all[0] as $k => $v) {
                        $columns[]=$k;
                    }
                    //print_r($columns);
                    //echo $q[0][$columns[5]];
                    echo "<div class=\"table-responsive\">          
                    <table class=\"table table-bordered\">
                    <thead>
                    <tr>
                    <th>Sr_no</th>
                    <th>Student_id</th>
                    ";
                    if($student_id!="all")
                    {
                        
                    }
                      foreach ($columns as $column_name) {
                        if($column_name=='sr_no' || $column_name=='student_id')
                        {
                            continue;
                        }
                        echo "<th><center>$column_name</center></th>";
                      }
                    echo "
                    </tr>
                    </thead>
                    <tbody>";
                    
                    $i=1;
                    foreach ($q as $key => $value) {
                        echo "<tr>";
                        echo "<td><center>$i</center></td>";
                        $i++;

                        if($student_id!="all")
                        {
                            /*$student_name=Student::select('name')->where('student_id',$student_id)->first();
                            echo "<td>$student_name->name</td>";*/
                            echo "<td>$student_id</td>";
                        }
                        if($student_id=="all")
                        {
                            $student=Student::select('student_id','name')->where('student_id',$q[$key]['student_id'])->first();
                            echo "<td>$student->student_id</td>";
                            //echo "<td>$q[$key]->student_id</td>";
                        }

                        foreach ($columns as $column_name) {
                            if($column_name=='sr_no' || $column_name=='student_id')
                            {
                                continue;
                            }
                            $td=($q[$key][$column_name]=='')?'-':$q[$key][$column_name];
                            if($column_name=='file')
                            {
                                if($td=='-')
                                {
                                    echo "<td><center>-</center></td>";
                                }
                                else
                                {
                                    echo "<td><center>"."<a href=\"http://127.0.0.1/Activity_Portal_BVM/public/activities/student/$td\" target=\"_blank\">File</a></center></td>";
                                }
                            }
                            else
                            {
                                echo "<td><center>".$td."</center></td>";
                            }
                            
                        }
                        echo "</tr>";
                    }

                    echo "
                    </tbody>
                    </table>
                    </div>";
            
            //end else
            }
                    
        }
        else
        {
            echo "All";
        }



    }


}
