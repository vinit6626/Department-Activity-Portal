<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Schema;
use Session;
use File;
use App\Faculty_Attended;
use App\Faculty_Organized;
use App\Faculty_Training_Internship;
use App\Faculty_Published_Paper;
use App\Faculty_Published_Book;
use App\Faculty_r_and_d;
use App\Faculty_Other_Services;


use App\HtmlToExcel;


class FacultyPersonalReportsController extends Controller
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

	/*-----------Personal Reports-----------*/

	public function showPersonalReportsForm()
	{
		$faculty=$this->givePersonalInfo();
		return view('Faculty.faculty_personal_reports_form',compact('faculty'));
	}

	/*public function generatePersonalReport()
	{
		$faculty=$this->givePersonalInfo();
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

	/*public function generatePersonalReport()
	{

		$faculty=$this->givePersonalInfo();
		$activity="all";

		$type="all";
		echo$from_date="2017-05-12";
		//$from_date="";
		echo $to_date="2018-06-12";
		$month_and_year="";
		$academic_year="";
		$academic_semester="even";
		$month_and_year="";
		$year="";
		$from_year="";
		$to_year="";*/
	
	public function generatePersonalReport(Request $request)
	{
		$faculty=$this->givePersonalInfo();
		//$activity="Faculty_Published_Paper";
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
			//$q=$model_name::where('faculty_id','=',$faculty['faculty_id']);
			$q=$model_name::query();

			if($type!="all")
			{
				//in case of Attended or organized activities
				$q=$q->where('type','=',$type);
			}
			
			if($from_date!='' && $to_date=='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{

					$from_month=date('m',strtotime($from_date));
					$from_year=date('Y', strtotime($from_date));
					$x=clone $q;
					$p=$x->where('publication_year','>',$from_year);
					$q=$q->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month)->union($p);
					
					//dd($q);

				}
				else
				{
					$q=$q->where('from_date','>=',$from_date);
				}
			}

			if($to_date!='' && $from_date=='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{
					$to_month=date('m',strtotime($to_date));
					$to_year=date('Y', strtotime($to_date));
					$x=clone $q;
					$p=$x->where('publication_year','<',$to_year);
					$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p);

				}
				else
				{
					$q=$q->where('to_date','<=',$to_date);
				}
				
			}

			if($from_date!='' && $to_date!='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{

					$from_month=date('m',strtotime($from_date));
					$from_year=date('Y', strtotime($from_date));
					$to_month=date('m',strtotime($to_date));
					$to_year=date('Y', strtotime($to_date));

					$x=clone $q;
					$y=clone $q;
					$p=$x->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month);
					$s=$y->where('publication_year','>',$from_year)->where('publication_year','<',$to_year);
					$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p)->union($s);
					//dd($q);

				}
				else
				{
					$q=$q->where('from_date','>=',$from_date)->where('to_date','<=',$to_date);
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
			$q=$q->where('faculty_id','=',$faculty['faculty_id']);
			$q=$q->get();

			$all=$q->toArray();
			$columns=[];
			if(empty($all))
			{
				echo "<center><h4>No Activities.</h4></center>";
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
					echo "
					<div class=\"table-responsive\">
					<table id=\"example\" class=\"table table-striped table-bordered\" style=\"width:100%\">
					<thead>
					<tr>
					<th>Sr_no</th>
					";
					  foreach ($columns as $column_name) {
						if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no')
						{
							continue;
						}
						else if($column_name=='file')
						{
							echo "<th class=\"noExport\"><center>$column_name</center></th>";
						}
						else
						{
							$column_arr=explode('_',$column_name);
							$str="";
							foreach($column_arr as $column_part)
							{
								$str.=$column_part."\n";
							}
							echo "<th>$str</th>";
						}

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
						foreach ($columns as $column_name) {
							if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no')
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
									echo "<td><center>"."<a href=\"http://127.0.0.1/Activity_Portal_BVM/public/activities/faculty/$td\" target=\"_blank\">File</a></center></td>";
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

					echo "<script>$('#example').DataTable( {
				  \"paging\": false,
				  \"info\": false,
				  \"searching\":false,
				  dom: 'Bfrtip',
				  buttons: [
					{
						extend: 'excelHtml5',
						title: 'Report',
						exportOptions: {
						columns: \"thead th:not(.noExport)\"
						}
					},


					{
						extend: 'pdfHtml5',
						orientation:'landscape',
						title: 'Report',
						exportOptions: {
						columns: \"thead th:not(.noExport)\"
						},
						customize: function (doc) {
							
							doc.content.splice(0,1);

							doc.pageMargins = [20,60,20,30];
							// Set the font size fot the entire document
							doc.defaultStyle.fontSize = 7;
							// Set the fontsize for the table header
							doc.styles.tableHeader.fontSize = 7;
							
							
							var objLayout = {};
							objLayout['hLineWidth'] = function(i) { return .5; };
							objLayout['vLineWidth'] = function(i) { return .5; };
							objLayout['hLineColor'] = function(i) { return '#aaa'; };
							objLayout['vLineColor'] = function(i) { return '#aaa'; };
							objLayout['paddingLeft'] = function(i) { return 4; };
							objLayout['paddingRight'] = function(i) { return 4; };
							doc.content[0].layout = objLayout;
						}
					},


					{
						extend: 'print',
						title: 'Report',
						exportOptions: {
						columns: \"thead th:not(.noExport)\"
						}
					},


					/*{
						extend: 'colvis',
						text: window.colvisButtonTrans,
						exportOptions: {
							columns: ':visible'
						}
					},*/
				  ]
			});</script>";
			
			//end else
			}
					
		}
















		else
		{


			$all_activities=array("Faculty_Published_Paper"=>"Published Papers","Faculty_Published_Book"=>"Published Books","Faculty_Organized"=>"Activities Organized","Faculty_Attended"=>"Activities Attended","Faculty_r_and_d"=>"Research & Development","Faculty_Training_Internship"=>"Trainings & Internships","Faculty_Other_Services"=>"Services inside/outside institute");

			$alltableid=0;
			foreach ($all_activities as $activity => $title) 
			{
				$alltableid+=1;
				$model_name=app('App\\'.$activity);
			
				//basic-all records of table
				//$q=$model_name::where('faculty_id','=',$faculty['faculty_id']);
				$q=$model_name::query();

				if($type!="all")
				{
					//in case of Attended or organized activities
					$q=$q->where('type','=',$type);
				}
				
				if($from_date!='' && $to_date=='')
				{
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
					{

						$from_month=date('m',strtotime($from_date));
						$from_year=date('Y', strtotime($from_date));
						$x=clone $q;
						$p=$x->where('publication_year','>',$from_year);
						$q=$q->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month)->union($p);
						
						//dd($q);

					}
					else
					{
						$q=$q->where('from_date','>=',$from_date);
					}
				}

				if($to_date!='' && $from_date=='')
				{
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
					{
						$to_month=date('m',strtotime($to_date));
						$to_year=date('Y', strtotime($to_date));
						$x=clone $q;
						$p=$x->where('publication_year','<',$to_year);
						$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p);

					}
					else
					{
						$q=$q->where('to_date','<=',$to_date);
					}
					
				}

				if($from_date!='' && $to_date!='')
				{
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
					{

						$from_month=date('m',strtotime($from_date));
						$from_year=date('Y', strtotime($from_date));
						$to_month=date('m',strtotime($to_date));
						$to_year=date('Y', strtotime($to_date));

						$x=clone $q;
						$y=clone $q;
						$p=$x->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month);
						$s=$y->where('publication_year','>',$from_year)->where('publication_year','<',$to_year);
						$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p)->union($s);
						//dd($q);

					}
					else
					{
						$q=$q->where('from_date','>=',$from_date)->where('to_date','<=',$to_date);
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
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
					if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
				$q=$q->where('faculty_id','=',$faculty['faculty_id']);
				$q=$q->get();

				$all=$q->toArray();
				$columns=[];

				echo "<center><b><h3>$title</h3></b></center>";
				if(empty($all))
				{
					echo "<center><h4>No Activities.</h4></center>";
					echo "<p style=\"margin-bottom:50px;\"></p>";
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

						
						echo "<div  class=\"table-responsive\" style=\"margin-bottom:50px;\">          
						<table id=\"table$alltableid\" class=\"alltables table table-striped table-bordered\" style=\"width:100%\">
						<thead>
						<tr>
						<th>Sr_no</th>
						";

						  foreach ($columns as $column_name) {
							if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no')
							{
								continue;
							}
	                        else if($column_name=='file')
	                        {
	                            echo "<th class=\"noExport\"><center>$column_name</center></th>";
	                        }
	                        else
	                        {
	                            $column_arr=explode('_',$column_name);
	                            $str="";
	                            foreach($column_arr as $column_part)
	                            {
	                                $str.=$column_part."\n";
	                            }
	                            echo "<th>$str</th>";
	                        }
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
							foreach ($columns as $column_name) {
								if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no')
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
										echo "<td><center>"."<a href=\"http://127.0.0.1/Activity_Portal_BVM/public/activities/faculty/$td\" target=\"_blank\">File</a></center></td>";
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

			//end all activities loop
			}

			echo "<script>$('table.alltables').DataTable( {
	                          \"paging\": false,
	                          \"info\": false,
	                          \"searching\":false,
	                          dom: 'Bfrtip',
	                          buttons: [
	                            {
	                                extend: 'excelHtml5',
	                                title: 'Report',
	                                exportOptions: {
	                                columns: \"thead th:not(.noExport)\"
	                                }
	                            },


	                            {
	                                extend: 'pdfHtml5',
	                                orientation:'landscape',
	                                title: 'Report',
	                                exportOptions: {
	                                columns: \"thead th:not(.noExport)\"
	                                },
	                                customize: function (doc) {
	                                    
	                                    doc.content.splice(0,1);

	                                    doc.pageMargins = [20,60,20,30];
	                                    // Set the font size fot the entire document
	                                    doc.defaultStyle.fontSize = 7;
	                                    // Set the fontsize for the table header
	                                    doc.styles.tableHeader.fontSize = 7;
	                                    
	                                    
	                                    var objLayout = {};
	                                    objLayout['hLineWidth'] = function(i) { return .5; };
	                                    objLayout['vLineWidth'] = function(i) { return .5; };
	                                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
	                                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
	                                    objLayout['paddingLeft'] = function(i) { return 4; };
	                                    objLayout['paddingRight'] = function(i) { return 4; };
	                                    doc.content[0].layout = objLayout;
	                                }
	                            },


	                            {
	                                extend: 'print',
	                                title: 'Report',
	                                exportOptions: {
	                                columns: \"thead th:not(.noExport)\"
	                                }
	                            },


	                            /*{
	                                extend: 'colvis',
	                                text: window.colvisButtonTrans,
	                                exportOptions: {
	                                    columns: ':visible'
	                                }
	                            },*/
	                          ]
	                    });</script>";

	        
		//end $activity="all"
		}


	}


	function downloadAllInExcel(Request $request)
	{
		
		$faculty=$this->givePersonalInfo();
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


		$all_activities=array("Faculty_Published_Paper"=>"Published Papers","Faculty_Published_Book"=>"Published Books","Faculty_Organized"=>"Activities Organized","Faculty_Attended"=>"Activities Attended","Faculty_r_and_d"=>"Research & Development","Faculty_Training_Internship"=>"Trainings & Internships","Faculty_Other_Services"=>"Services inside/outside institute");

		$all_sheets=array();

		$id=0;
		foreach ($all_activities as $activity => $title)
		{
			$id+=1;
			$all_sheets[$id]="";


			$model_name=app('App\\'.$activity);
		
			//basic-all records of table
			//$q=$model_name::where('faculty_id','=',$faculty['faculty_id']);
			$q=$model_name::query();

			if($type!="all")
			{
				//in case of Attended or organized activities
				$q=$q->where('type','=',$type);
			}
			
			if($from_date!='' && $to_date=='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{

					$from_month=date('m',strtotime($from_date));
					$from_year=date('Y', strtotime($from_date));
					$x=clone $q;
					$p=$x->where('publication_year','>',$from_year);
					$q=$q->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month)->union($p);
					
					//dd($q);

				}
				else
				{
					$q=$q->where('from_date','>=',$from_date);
				}
			}

			if($to_date!='' && $from_date=='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{
					$to_month=date('m',strtotime($to_date));
					$to_year=date('Y', strtotime($to_date));
					$x=clone $q;
					$p=$x->where('publication_year','<',$to_year);
					$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p);

				}
				else
				{
					$q=$q->where('to_date','<=',$to_date);
				}
				
			}

			if($from_date!='' && $to_date!='')
			{
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{

					$from_month=date('m',strtotime($from_date));
					$from_year=date('Y', strtotime($from_date));
					$to_month=date('m',strtotime($to_date));
					$to_year=date('Y', strtotime($to_date));

					$x=clone $q;
					$y=clone $q;
					$p=$x->where('publication_year','=',$from_year)->where('publication_month','>=',$from_month);
					$s=$y->where('publication_year','>',$from_year)->where('publication_year','<',$to_year);
					$q=$q->where('publication_year','=',$to_year)->where('publication_month','<=',$to_month)->union($p)->union($s);
					//dd($q);

				}
				else
				{
					$q=$q->where('from_date','>=',$from_date)->where('to_date','<=',$to_date);
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{
					$q=$q->where('publication_month','=',$month)
						->where('publication_year','=',$year);
				}
				else
				{
					$q=$q->where(function($q) use($month,$year){
							$q->
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
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
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{
					$q=$q->whereYEAR('publication_year','>=',$from_year);
				}
				else
				{
					$q=$q->whereYEAR('from_date','>=',$from_year);
				}            
			}

			if($to_year!="")
			{   
				if($activity=='Faculty_Published_Paper' || $activity=='Faculty_Published_Book')
				{
					$q=$q->whereYEAR('publication_year','<=',$to_year);
				}
				else
				{
					$q=$q->whereYEAR('from_date','<=',$to_year);
				}            
			}


			//It will fetch results
			$q=$q->where('faculty_id','=',$faculty['faculty_id']);
			$q=$q->get();

			$all=$q->toArray();
			$columns=[];

			//echo "<center><b><h3>$title</h3></b></center>";
			if(empty($all))
			{
				$p=app('App\\'.$activity);
				$a=$p->where('sr_no',1)->get();
				$q=$a->toArray();
				$c=array();
				foreach ($q[0] as $k => $v) {
					$c[]=$k;
				}
				$all_sheets[$id].="        
					<table id=\"table$id\" class=\"alltables table table-striped table-bordered\" style=\"width:100%\">
					<thead>
					<tr>
					<th>Sr_no</th>
					";

					  foreach ($c as $column_name) {
						if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no' || $column_name=='file')
						{
							continue;
						}
                        else
                        {
                            $column_arr=explode('_',$column_name);
                            $str="";
                            foreach($column_arr as $column_part)
                            {
                                $str.=$column_part."\n";
                            }
                            $all_sheets[$id].="<th>$str</th>";
                        }
					  }
					$all_sheets[$id].="
					</tr>
					</thead>
					<tbody></tbody></table>";
			}
			else
			{
					/*$total_results=count($q);
					echo "<b><h4>Total: $total_results</h4></b>";*/
					foreach ($all[0] as $k => $v) {
						$columns[]=$k;
					}
					//print_r($columns);
					//echo $q[0][$columns[5]];

					
					$all_sheets[$id].="        
					<table id=\"table$id\" class=\"alltables table table-striped table-bordered\" style=\"width:100%\">
					<thead>
					<tr>
					<th>Sr_no</th>
					";

					  foreach ($columns as $column_name) {
						if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no' || $column_name=='file')
						{
							continue;
						}
                        else
                        {
                            $column_arr=explode('_',$column_name);
                            $str="";
                            foreach($column_arr as $column_part)
                            {
                                $str.=$column_part."\n";
                            }
                            $all_sheets[$id].="<th>$str</th>";
                        }
					  }
					$all_sheets[$id].="
					</tr>
					</thead>
					<tbody>";
					
					$i=1;
					foreach ($q as $key => $value) {
						$all_sheets[$id].="<tr>";
						$all_sheets[$id].="<td><center>$i</center></td>";
						$i++;
						foreach ($columns as $column_name) {
							if($column_name=='sr_no' || $column_name=='faculty_id' || $column_name=='group_no' || $column_name=='file')
							{
								continue;
							}
							
							$td=($q[$key][$column_name]=='')?'-':$q[$key][$column_name];
							
							if($column_name=='page_num')
							{
								$column_arr=explode('-',$q[$key][$column_name]);
	                            $td=(string)$column_arr[0]."-\n ".(string)$column_arr[1];
							}


							$all_sheets[$id].="<td><center>".$td."</center></td>";
						}
						$all_sheets[$id].="</tr>";
					}

					$all_sheets[$id].="
					</tbody>
					</table>
					";
			//end else
			}

		}

		$css="table, th, td {
			border:1px solid gray;
		}";

		$xls = new HtmlToExcel();
		$xls->setCss($css);
		$xls->addSheet("Published Papers", $all_sheets[1]);
		$xls->addSheet("Published Books", $all_sheets[2]);
		$xls->addSheet("Activities Organized", $all_sheets[3]);
		$xls->addSheet("Activities Attended", $all_sheets[4]);
		$xls->addSheet("Research & Development", $all_sheets[5]);
		$xls->addSheet("Trainings & Internships", $all_sheets[6]);
		$xls->addSheet("Other Services", $all_sheets[7]);


		$xls->headers();
		echo $xls->buildFile();

	}

}


