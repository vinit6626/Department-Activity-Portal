<?php

namespace App\Http\Controllers;
use App\Faculty;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use File;
use App\Faculty_Attended;
use App\Faculty_Organized;
use App\Faculty_Training_Internship;
use App\Faculty_Published_Paper;
use App\Faculty_Published_Book;
use App\Faculty_r_and_d;
use App\Faculty_Other_Services;
use App\Faculty_Notifications;

class FacultyActivitiesController extends Controller
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

    /*-----------Attended Activities-----------*/

    public function showAttendedForm()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_attended_form',compact('faculty'));
    }

    public function insertAttendedActivity(Request $request)
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
        
        $faculty=$this->givePersonalInfo();
        $attended=new Faculty_Attended;
        $attended->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return back()->with('success_message','Activity inserted successfully');
    }

    public function showAttendedActivities()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Attended::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_attended_table',compact('activities','faculty'));
    }

    public function editAttendedActivityForm($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Attended::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_attended_edit_form',compact('activity','faculty'));
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
        
        $faculty=$this->givePersonalInfo();
        $attended=Faculty_Attended::find($sr_no);
        $attended->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$attended->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return redirect('faculty/show/attended/activities')->with('success_message','Activity details updated successfully');
    }

    /*-----------Organized Activites-----------*/

    public function showOrganizedForm()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_organized_form',compact('faculty'));
    }

    public function fetch_other_faculties(Request $request)
    {
        $no_of_coordinators=$request['no_of_coordinators'];
        
        $faculty=$this->givePersonalInfo();
        $other_faculties=Faculty::select('faculty_id','name')->where('faculty_id','!=',$faculty->faculty_id)->get();
        
        for($i=0;$i<$no_of_coordinators;$i++)
        {
            echo "<select name=\"other_coordinators[]\" class=\"form-control other_coordinators_group\"> required";
            echo "<option value=\"\">-----Select Coordinator".($i+1)."-----</option>";
            foreach ($other_faculties as $other_faculty) {
                echo "<option value='".$other_faculty['faculty_id']."' >".$other_faculty['name']."</option>";
            }
            echo "</select>";
        }
        /*for($i=0;$i<$no_of_coordinators;$i++)
        {
            echo "<select name=\"other_coordinators[]\" class=\"form-control other_coordinators_group\"> required";
            $j=0;
            foreach ($other_faculties as $other_faculty) {
                echo "<option value='".$other_faculty['faculty_id']."'";
                echo ($j==$i)?"selected":'';
                echo ">".$other_faculty['name']."</option>";
                $j++;
            }
            echo "</select>";
        }*/
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


        $faculty=$this->givePersonalInfo();
        $organized=new Faculty_Organized;
        $organized->faculty_id=$faculty->faculty_id;
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

        $all_coordinators=array($faculty['name']);
        
        if($request->role=='Coordinator')
        {
            $other_coordinator_names=Faculty::select('name')->whereIn('faculty_id',$request->other_coordinators)->get();

            foreach($other_coordinator_names as $other_coordinator)
            {
                array_push($all_coordinators,$other_coordinator->name);  
            }   
        }
        

        $organized->coordinators=implode(',',$all_coordinators);

        $latestGroupValue = Faculty_Organized::max('group_no');
        $newGroupValue=$latestGroupValue+1;

        $organized->group_no=$newGroupValue;
        
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $first_file_create_time=time();
            $file->move($destinationPath,''.$first_file_create_time.'.'.$extension.'');
            $organized->file=''.$first_file_create_time.'.'.$extension.'';
        }
        $organized->save();

        $q_activity_no=Faculty_Organized::select('sr_no')->where('group_no', $newGroupValue)->get();
        $activity_no=$q_activity_no[0]->sr_no;

        if($request->role=='Coordinator')
        {
            if($request->other_coordinators!='')
            {
                foreach($request->other_coordinators as $other_coordinator)
                { 
                    $notification=new Faculty_Notifications;
                    $notification->from_faculty=$faculty->faculty_id;
                    $notification->to_faculty=$other_coordinator;
                    $notification->organized_activity_no=$activity_no;

                    $notification->description="inserted";
                    $notification->save();

                    $other_coordinator_name=Faculty::select('name')->where('faculty_id',$other_coordinator)->get();

                    $new_coordinators=array($other_coordinator_name[0]->name);
                    foreach($all_coordinators as $coordinator)
                    {
                        if(!in_array($coordinator, $new_coordinators))
                        {
                            array_push($new_coordinators, $coordinator);
                        }
                    }
                    $organized=new Faculty_Organized;
                    $organized->faculty_id=$other_coordinator;
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
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Organized::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_organized_table',compact('activities','faculty'));
    }

    public function editOrganizedActivityForm($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Organized::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_organized_edit_form',compact('activity','faculty'));
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
        
        $faculty=$this->givePersonalInfo();
        $organized=Faculty_Organized::find($sr_no);
        $organized->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$organized->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $organized->file=''.$create_time.'.'.$extension.'';
        }
        $organized->save();
        return redirect('faculty/show/organized/activities')->with('success_message','Activity details updated successfully');
 }

    /*-----------Training and Internship-----------*/

    public function show_training_intership_form()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_training_internship_form',compact('faculty'));
    }

    public function insertTrainingInternship(Request $request)
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
        
        $faculty=$this->givePersonalInfo();
        $attended=new Faculty_Training_Internship;
        $attended->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return back()->with('success_message','Activity inserted successfully');
    }

    public function show_trainings_internships()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Training_Internship::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_training_internship_table',compact('activities','faculty'));
    }

    public function editTrainingInternshipForm($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Training_Internship::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_training_internship_edit_form',compact('activity','faculty'));
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
        $faculty=$this->givePersonalInfo();
        $attended=Faculty_Training_Internship::find($sr_no);
        $attended->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$attended->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $attended->file=''.$create_time.'.'.$extension.'';
        }

        $attended->save();
        return redirect('faculty/show/trainings_internships')->with('success_message','Activity details updated successfully');
    }

    /*-----------Published Paper-----------*/

    public function show_published_paper_form()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_published_paper_form',compact('faculty'));
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

        $faculty=$this->givePersonalInfo();
        $paper=new Faculty_Published_Paper;
        $paper->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $paper->file=''.$create_time.'.'.$extension.'';  
        }
        
        $paper->save();
        return back()->with('success_message','Submitted successfully');
    }

    public function show_published_papers()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Published_Paper::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_published_paper_table',compact('activities','faculty'));
    }

    public function editPublishedPaperForm($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Published_Paper::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_published_paper_edit_form',compact('activity','faculty'));
    }

    public function editPublishedPaperData(Request $request, $sr_no)
    {
        $rules=[
        'paper_title'=>"bail|required|string|max:500",
        'authors_detail'=>"bail|required|regex:/^([A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)(\s,[A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)*$/",
        'paper_type'=>"bail|required",
        'paper_type'=>"bail|required",
        'published_or_presented'=>"bail|required",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'publication_month'=>"bail|required|digits:2",
        'publication_year'=>"bail|required|digits:4",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required",
        ];
        $this->validate($request,$rules);

        $faculty=$this->givePersonalInfo();
        $paper=Faculty_Published_Paper::find($sr_no);
        $paper->faculty_id=$faculty->faculty_id;
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
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$paper->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $paper->file=''.$create_time.'.'.$extension.'';  
        }
        
        $paper->save();
        return redirect('faculty/show/published/papers')->with('success_message','Paper details updated successfully');
    }


    /*-----------Published Books-----------*/

    public function show_published_book_form()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_published_book_form',compact('faculty'));
    }

    public function insertPublishedBook(Request $request)
    {
        $rules=[
        /*'ISBN'=>"bail|required|unique:book_pub_faculties",*/
        'book_name'=>"bail|required",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'publication_month'=>"bail|required|digits:2",
        'publication_year'=>"bail|required|digits:4",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required",

        ];
        $this->validate($request,$rules);

        $faculty=$this->givePersonalInfo();
        $book=new Faculty_Published_Book;
        $book->faculty_id=$faculty->faculty_id;
        $book->ISBN=$request->ISBN;
        $book->book_name=$request->book_name;
        $book->publication_house=$request->publication_house;
        $book->authors=$request->authors;
        $book->publication_month=$request->publication_month;
        $book->publication_year=$request->publication_year;
        $book->academic_year=$request->academic_year;
        $book->academic_semester=$request->academic_semester;
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $book->file=''.$create_time.'.'.$extension.'';
        }
        $book->save();
        return back()->with('success_message','Submitted successfully');
    }

    public function show_published_books()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Published_Book::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_published_book_table',compact('activities','faculty'));
    }

    public function editPublishedBookForm($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Published_Book::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_published_book_edit_form',compact('activity','faculty'));
    }


    public function editPublishedBookData(Request $request, $sr_no)
    {
        $rules=[
        'book_name'=>"bail|required",
        'proof_file'=>"bail|mimes:jpg,JPG,jpeg,JPEG,png,PNG,pdf,PDF,doc,DOC,docx,DOCX",
        'publication_month'=>"bail|required|digits:2",
        'publication_year'=>"bail|required|digits:4",
        'academic_year'=>"bail|required|regex:/^[0-9]{4}[-][0-9]{4}$/",
        'academic_semester'=>"bail|required",

        ];
        $this->validate($request,$rules);

        $faculty=$this->givePersonalInfo();
        $book=Faculty_Published_Book::find($sr_no);
        $book->faculty_id=$faculty->faculty_id;
        $book->ISBN=$request->ISBN;
        $book->book_name=$request->book_name;
        $book->publication_house=$request->publication_house;
        $book->authors=$request->authors;
        $book->publication_month=$request->publication_month;
        $book->publication_year=$request->publication_year;
        $book->academic_year=$request->academic_year;
        $book->academic_semester=$request->academic_semester;
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$book->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $book->file=''.$create_time.'.'.$extension.'';
        }
        $book->save();
        return redirect('faculty/show/published/books')->with('success_message','Book details updated successfully');
    }

    /*-----------Research & Development-----------*/

    public function show_r_and_d_form()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_r_and_d_form',compact('faculty'));
    }

    public function insertResearchDevelopment(Request $request)
    {
        $faculty=$this->givePersonalInfo();
        $r_d=new Faculty_r_and_d;
        $r_d->faculty_id=$faculty->faculty_id;
        $r_d->description=$request->description;
        $r_d->approval_letter_no=$request->approval_letter_no;
        $r_d->funding_agency=$request->funding_agency;
        $r_d->amount=$request->amount;
        $r_d->PI=$request->PI;
        $r_d->CI=$request->CI;
        $r_d->from_date=$request->from_date;
        $r_d->to_date=$request->to_date;
        $r_d->academic_year=$request->academic_year;
        $r_d->academic_semester=$request->academic_semester;
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file');
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$book->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $r_d->file=''.$create_time.'.'.$extension.'';
        }
        $r_d->save();
        return back()->with('success_message','Submitted successfully');
    }

    public function show_r_and_d()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_r_and_d::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_r_and_d_table',compact('activities','faculty'));
    }

    public function edit_R_and_D_Form($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_r_and_d::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_r_and_d_edit_form',compact('activity','faculty'));
    }


    public function edit_R_and_D_Data(Request $request, $sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $r_d=Faculty_r_and_d::find($sr_no);
        $r_d->faculty_id=$faculty->faculty_id;
        $r_d->description=$request->description;
        $r_d->approval_letter_no=$request->approval_letter_no;
        $r_d->funding_agency=$request->funding_agency;
        $r_d->amount=$request->amount;
        $r_d->PI=$request->PI;
        $r_d->CI=$request->CI;
        $r_d->from_date=$request->from_date;
        $r_d->to_date=$request->to_date;
        $r_d->academic_year=$request->academic_year;
        $r_d->academic_semester=$request->academic_semester;
        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file');
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            File::delete(''.$destinationPath."".$book->file.'');
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $r_d->file=''.$create_time.'.'.$extension.'';
        }
        $r_d->save();
        return redirect('faculty/show/research_development')->with('success_message','Activity details updated successfully');
    }

    /*-----------Other Services-----------*/

    public function show_other_services_form()
    {
        $faculty=$this->givePersonalInfo();
        return view('Faculty.faculty_other_services_form',compact('faculty'));
    }

    public function insertOtherService(Request $request)
    {

        $faculty=$this->givePersonalInfo();
        $service=new Faculty_Other_Services;
        $service->faculty_id=$faculty->faculty_id;
        $service->title_of_contribution=$request->title_of_contribution;
        $service->place=$request->place;
        $service->from_date=$request->from_date;
        $service->to_date=$request->to_date;
        $service->academic_year=$request->academic_year;
        $service->academic_semester=$request->academic_semester;

        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $service->file=''.$create_time.'.'.$extension.'';
        }
        $service->save();
        return back()->with('success_message','Activity inserted successfully');
    }

    public function show_other_services()
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activities=Faculty_Other_Services::where('faculty_id',$faculty_id)
        ->orderBy('sr_no','desc')->get();

        return view('Faculty.faculty_other_services_table',compact('activities','faculty'));
    }

    public function edit_other_service_Form($sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $faculty_id=$faculty['faculty_id'];
        $activity=Faculty_Other_Services::where('faculty_id',$faculty_id)->where('sr_no',$sr_no)->first();

        return view('Faculty.faculty_other_services_edit_form',compact('activity','faculty'));
    }


    public function edit_other_services_Data(Request $request, $sr_no)
    {
        $faculty=$this->givePersonalInfo();
        $service=Faculty_Other_Services::find($sr_no);
        $service->faculty_id=$faculty->faculty_id;
        $service->title_of_contribution=$request->title_of_contribution;
        $service->place=$request->place;
        $service->from_date=$request->from_date;
        $service->to_date=$request->to_date;
        $service->academic_year=$request->academic_year;
        $service->academic_semester=$request->academic_semester;

        if($request->has('proof_file'))
        {
            $file = $request->file('proof_file') ;
            $extension=$file->extension(); 
            $destinationPath = public_path().'\\activities\faculty\\';
            $create_time=time();
            $file->move($destinationPath,''.$create_time.'.'.$extension.'');
            $service->file=''.$create_time.'.'.$extension.'';
        }
        $service->save();
        return redirect('faculty/show/other_services')->with('success_message','Activity details updated successfully');
    }

}
