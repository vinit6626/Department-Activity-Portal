<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;
use App\Student_Attended;
use App\Student_Organized;
use App\Student_Training_Internship;
use App\Student_Published_Paper;
use App\Student_Notifications;

class StudentActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    /*-----------Attended Activities-----------*/

    public function showAttendedForm()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_attended_form',compact('student'));
    }

    public function insertAttendedActivity(Request $request)
    {
        $rules=[
        'type'=>"bail|required",
        'topic'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|required|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        
        $student=$this->givePersonalInfo();
        $attended=new Student_Attended;
        $attended->student_id=$student->student_id;
        $attended->type=$request->type;
        $attended->topic=$request->topic;
        $attended->place=$request->place;
        $attended->from_date=$request->from_date;
        $attended->to_date=$request->to_date;
        $attended->academic_year=$request->academic_year;
        $attended->academic_semester=$request->academic_semester;


        $file = $request->file('proof_file') ;
        $extension=$file->extension(); 
        $destinationPath = public_path().'\\activities\student\\';
        $create_time=time();
        $file->move($destinationPath,''.$create_time.'.'.$extension.'');
        $attended->file=''.$create_time.'.'.$extension.'';
        
        $attended->save();
        return back()->with('success_message','Activity inserted successfully');
    }

    public function showAttendedActivities()
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activities=Student_Attended::where('student_id',$student_id)
        ->orderBy('sr_no','desc')->get();

        return view('Student.student_attended_table',compact('activities','student'));
    }

    public function editAttendedActivityForm($sr_no)
    {
         $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activity=Student_Attended::where('student_id',$student_id)->where('sr_no',$sr_no)->first();

        return view('Student.student_attended_edit_form',compact('activity','student'));
    }

    public function editAttendedActivityData(Request $request,$sr_no)
    {
        $rules=[
        'type'=>"bail|required",
        'topic'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        
        $student=$this->givePersonalInfo();
        $attended=Student_Attended::find($sr_no);
        $attended->student_id=$student->student_id;
        $attended->type=$request->type;
        $attended->topic=$request->topic;
        $attended->place=$request->place;
        $attended->from_date=$request->from_date;
        $attended->to_date=$request->to_date;
        $attended->academic_year=$request->academic_year;
        $attended->academic_semester=$request->academic_semester;

        if($request->has('proof_file'))
        {

            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$attended->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return redirect('student/show/attended/activities')->with('success_message','Activity details updated successfully');
    }


    /*-----------Organized Activites-----------*/

    public function showOrganizedForm()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_organized_form',compact('student'));
    }

    public function fetch_other_students(Request $request)
    {
        $no_of_coordinators=$request['no_of_coordinators'];
        
        $student=$this->givePersonalInfo();
        $other_students=Student::select('student_id')->where('student_id','!=',$student->student_id)->orderBy('department','asc')->get();
        
        for($i=0;$i<$no_of_coordinators;$i++)
        {
            echo "<select name=\"other_coordinators[]\" class=\"form-control other_coordinators_group\"> required";
            echo "<option value=\"\">-----Select Coordinator".($i+1)."-----</option>";
            foreach ($other_students as $other_student) {
                echo "<option value='".$other_student['student_id']."' >".$other_student['student_id']."</option>";
            }
            echo "</select>";
        }
    }

    public function insertOrganizedActivity(Request $request)
    {
        $rules=[
        'type'=>"bail|required",
        'title_of_activity'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'role'=>"bail|required|max:100",
        'convener'=>"bail|required|max:100",
        'resource_Person_or_Industry'=>"bail|required|max:100",
        'total_no_of_students'=>"bail|required|min:1",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        if($request->role=='Coordinator')
        {
            if($request->no_of_coordinators<=0)
            {
                return back()->withInput()->with('error_role','No. of coordinators should be more than 0');
            }

            $other_coordinators=$request->other_coordinators;
            if(count($other_coordinators)!=count(array_unique($other_coordinators)))
            {
                return back()->withInput()->with('error_role','Coordinators should not repeat');
            }

        }


        $student=$this->givePersonalInfo();
        $organized=new Student_Organized;
        $organized->student_id=$student->student_id;
        $organized->type=$request->type;
        $organized->title_of_activity=$request->title_of_activity;
        $organized->place=$request->place;
        $organized->role=$request->role;
        $organized->convener=$request->convener;
        $organized->total_no_of_students=$request->total_no_of_students;
        $organized->resource_person_or_industry=$request->resource_Person_or_Industry;
        
        $organized->from_date=$request->from_date;
        $organized->to_date=$request->to_date;
        $organized->academic_year=$request->academic_year;
        $organized->academic_semester=$request->academic_semester;

        $all_coordinators=array($student['name']);
        
        if($request->role=='Coordinator')
        {
            $other_coordinator_names=Student::select('name')->whereIn('student_id',$request->other_coordinators)->get();

            foreach($other_coordinator_names as $other_coordinator)
            {
                array_push($all_coordinators,$other_coordinator->name);  
            }   
        }
        

        $organized->coordinators=implode(',',$all_coordinators);

        $latestGroupValue = Student_Organized::max('group_no');
        $newGroupValue=$latestGroupValue+1;

        $organized->group_no=$newGroupValue;
        
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $first_file_create_time=time();
            $file->move($destinationPath,''.$first_file_create_time.'.'.$extension.'');
            $organized->file=''.$first_file_create_time.'.'.$extension.'';
        }
        $organized->save();

        $q_activity_no=Student_Organized::select('sr_no')->where('group_no', $newGroupValue)->get();
        $activity_no=$q_activity_no[0]->sr_no;

        if($request->role=='Coordinator')
        {
            if($request->other_coordinators!='')
            {
                foreach($request->other_coordinators as $other_coordinator)
                { 
                    $notification=new Student_Notifications;
                    $notification->from_student=$student->student_id;
                    $notification->to_student=$other_coordinator;
                    $notification->organized_activity_no=$activity_no;

                    $notification->description="inserted";
                    $notification->save();

                    $other_coordinator_name=Student::select('name')->where('student_id',$other_coordinator)->get();

                    $new_coordinators=array($other_coordinator_name[0]->name);
                    foreach($all_coordinators as $coordinator)
                    {
                        if(!in_array($coordinator, $new_coordinators))
                        {
                            array_push($new_coordinators, $coordinator);
                        }
                    }
                    $organized=new Student_Organized;
                    $organized->student_id=$other_coordinator;
                    $organized->type=$request->type;
                    $organized->title_of_activity=$request->title_of_activity;
                    $organized->place=$request->place;
                    $organized->role=$request->role;
                    $organized->convener=$request->convener;
        $organized->total_no_of_students=$request->total_no_of_students;
        $organized->resource_person_or_industry=$request->resource_Person_or_Industry;
                    $organized->from_date=$request->from_date;
                    $organized->to_date=$request->to_date;
                    $organized->academic_year=$request->academic_year;
                    $organized->academic_semester=$request->academic_semester;


                    $organized->coordinators=implode(',', $new_coordinators);

                    $organized->group_no=$newGroupValue;
                    
                    if($request->has('proof_file'))
                    {
                        $organized->file=''.$first_file_create_time.'.'.$extension.'';
                    }
                    $organized->save();
                }
            }
        }
        return back()->with('success_message','Activity inserted successfully');
    }

    public function showOrganizedActivities()
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activities=Student_Organized::where('student_id',$student_id)
        ->orderBy('sr_no','desc')->get();

        return view('Student.student_organized_table',compact('activities','student'));
    }

    public function editOrganizedActivityForm($sr_no)
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activity=Student_Organized::where('student_id',$student_id)->where('sr_no',$sr_no)->first();

        return view('Student.student_organized_edit_form',compact('activity','student'));
    }

    public function editOrganizedActivityData(Request $request, $sr_no)
    {
        $rules=[
        'type'=>"bail|required",
        'title_of_activity'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'role'=>"bail|required|max:100",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        
        $student=$this->givePersonalInfo();
        $organized=Student_Organized::find($sr_no);
        $organized->student_id=$student->student_id;
        $organized->type=$request->type;
        $organized->title_of_activity=$request->title_of_activity;
        $organized->place=$request->place;
        $organized->role=$request->role;
        $organized->from_date=$request->from_date;
        $organized->to_date=$request->to_date;
        $organized->academic_year=$request->academic_year;
        $organized->academic_semester=$request->academic_semester;

        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$organized->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $organized->file=''.$create_time.'.'.$extension.'';
        }
        $organized->save();
        return redirect('student/show/organized/activities')->with('success_message','Activity details updated successfully');
    }

    /*-----------Training and Internship-----------*/

    public function show_training_intership_form()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_training_internship_form',compact('student'));
    }

    public function insertTrainingInternship(Request $request)
    {
        $rules=[
        'type'=>"bail|required",
        'topic'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|required|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        
        $student=$this->givePersonalInfo();
        $attended=new Student_Training_Internship;
        $attended->student_id=$student->student_id;
        $attended->training_or_internship=$request->type;
        $attended->title=$request->topic;
        $attended->place=$request->place;
        $attended->from_date=$request->from_date;
        $attended->to_date=$request->to_date;
        $attended->academic_year=$request->academic_year;
        $attended->academic_semester=$request->academic_semester;

        $file = $request->file('proof_file') ;
        $extension=$file->extension(); 
        $destinationPath = public_path().'\\activities\student\\';
        $create_time=time();
        $file->move($destinationPath,''.$create_time.'.'.$extension.'');
        $attended->file=''.$create_time.'.'.$extension.'';
        
        $attended->save();
        return back()->with('success_message','Activity inserted successfully');
    }

    public function show_trainings_internships()
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activities=Student_Training_Internship::where('student_id',$student_id)
        ->orderBy('sr_no','desc')->get();

        return view('Student.student_training_internship_table',compact('activities','student'));
    }

    public function editTrainingInternshipForm($sr_no)
    {
       $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activity=Student_Training_Internship::where('student_id',$student_id)->where('sr_no',$sr_no)->first();

        return view('Student.student_training_internship_edit_form',compact('activity','student'));
    }

    public function editTrainingInternshipData(Request $request, $sr_no)
    {
        $rules=[
        'type'=>"bail|required",
        'title'=>"bail|required|max:100",
        'place'=>"bail|required|max:100",
        'from_date'=>"bail|required|before_or_equal:today",
        'to_date'=>"bail|required|after_or_equal:from_date|before_or_equal:today",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required"
        ];
        $this->validate($request,$rules);
        $student=$this->givePersonalInfo();
        $attended=Student_Training_Internship::find($sr_no);
        $attended->student_id=$student->student_id;
        $attended->training_or_internship=$request->type;
        $attended->title=$request->title;
        $attended->place=$request->place;
        $attended->from_date=$request->from_date;
        $attended->to_date=$request->to_date;
        $attended->academic_year=$request->academic_year;
        $attended->academic_semester=$request->academic_semester;

        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$attended->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return redirect('student/show/trainings_internships')->with('success_message','Activity details updated successfully');
    }

    
    /*-----------Published Paper-----------*/

    public function show_published_paper_form()
    {
        $student=$this->givePersonalInfo();
        return view('Student.student_published_paper_form',compact('student'));
    }

    public function insertPublishedPaper(Request $request)
    {
        $rules=[
        'paper_title'=>"bail|required|string|max:500",
        'authors_detail'=>"bail|required|regex:/^([A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)(\s,[A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)*$/",
        'paper_type'=>"bail|required",
        'published_or_presented'=>"bail|required",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'publication_month'=>"bail|required|digits:2",
        'publication_year'=>"bail|required|digits:4",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required",
        ];
        $this->validate($request,$rules);
        
        $student=$this->givePersonalInfo();
        $paper=new Student_Published_Paper;
        $paper->student_id=$student->student_id;
        $paper->ISSN=$request->ISSN;
        $paper->ISBN=$request->ISBN;
        $paper->DOI_number=$request->DOI_number;
        $paper->paper_title=$request->paper_title;
        $paper->authors_detail=$request->authors_detail;
        $paper->conference_name=$request->conference_name;
        $paper->journal_name=$request->journal_name;
        $paper->paper_type=$request->paper_type;
        $paper->published_or_presented=$request->published_or_presented;
        $paper->volume_and_issue=$request->volume_and_issue;
        $paper->page_num=$request->page_num;
        $paper->impact_factor=$request->impact_factor;
        $paper->publication_month=$request->publication_month;
        $paper->publication_year=$request->publication_year;
        $paper->academic_year=$request->academic_year;
        $paper->academic_semester=$request->academic_semester;
        
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $paper->file=''.$create_time.'.'.$extension.'';  
        }
        
        
        $paper->save();
        return back()->with('success_message','Submitted successfully');
    }

    public function show_published_papers()
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activities=Student_Published_Paper::where('student_id',$student_id)
        ->orderBy('sr_no','desc')->get();

        return view('Student.student_published_paper_table',compact('activities','student'));
    }

    public function editPublishedPaperForm($sr_no)
    {
        $student=$this->givePersonalInfo();
        $student_id=$student['student_id'];
        $activity=Student_Published_Paper::where('student_id',$student_id)->where('sr_no',$sr_no)->first();

        return view('Student.student_published_paper_edit_form',compact('activity','student'));
    }

    public function editPublishedPaperData(Request $request, $sr_no)
    {
        $rules=[
        'paper_title'=>"bail|required|string|max:500",
        'authors_detail'=>"bail|required|regex:/^([A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)(\s,[A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)*$/",
        'paper_type'=>"bail|required",
        'published_or_presented'=>"bail|required",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'publication_month'=>"bail|required|digits:2",
        'publication_year'=>"bail|required|digits:4",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required",
        ];
        $this->validate($request,$rules);

        $student=$this->givePersonalInfo();
        $paper=Student_Published_Paper::find($sr_no);
        $paper->student_id=$student->student_id;
        $paper->ISSN=$request->ISSN;
        $paper->ISBN=$request->ISBN;
        $paper->DOI_number=$request->DOI_number;
        $paper->paper_title=$request->paper_title;
        $paper->authors_detail=$request->authors_detail;
        $paper->conference_name=$request->conference_name;
        $paper->journal_name=$request->journal_name;
        $paper->paper_type=$request->paper_type;
        $paper->published_or_presented=$request->published_or_presented;
        $paper->volume_and_issue=$request->volume_and_issue;
        $paper->page_num=$request->page_num;
        $paper->impact_factor=$request->impact_factor;
        $paper->publication_month=$request->publication_month;
        $paper->publication_year=$request->publication_year;
        $paper->academic_year=$request->academic_year;
        $paper->academic_semester=$request->academic_semester;
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\student\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$paper->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $paper->file=''.$create_time.'.'.$extension.'';  
        }
        
        $paper->save();
        return redirect('student/show/published/papers')->with('success_message','Paper details updated successfully');
    }

}
