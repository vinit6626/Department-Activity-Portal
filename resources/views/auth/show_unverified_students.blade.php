@extends('layouts.admin_dash_layout')

@section('customStyle')

<link rel="stylesheet" href="{{asset('css/jquery.dataTables.css')}}">
<style type="text/css">
  .dataTables_filter{
    display: none;
  }
</style>
@endsection

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li class="active"><a href="#"><b><span style="font-size:17px;">Unverified Accounts</span></b></a></li>
    <li><a href="{{url('admin/show/students/verified')}}"><span style="font-size:17px;">Verified Accounts</span></a></li>
</ul>

@if(session()->has('student_verified'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{session('student_verified')}}
</div>
@endif

<div class="row">
    <?php 
        //It is for checking if year has changed.
        $currentMonth=date('m'); 
        if($currentMonth>=7)
        {
            $changeyear=0;    
        }
        else{
            $changeyear=1;
        }
    ?>
<select id="custom_age" class="form-control" style="max-width:187px;float:right;margin-bottom:5px;margin-right:13px;">
    <!-- {{date('Y')-4+$changeyear+3}} -->
    <option value="">All</option>
    <option value="{{date('Y')+4+$changeyear}}">First Year Students</option>
    <option value="{{date('Y')+3+$changeyear}}">Second Year Students</option>
    <option value="{{date('Y')+2+$changeyear}}">Third Year Students</option>
    <option value="{{date('Y')+1+$changeyear}}">Fourth Year Students</option>
</select>
</div>

<div class="table-responsive">
    <table id="example" class="display" class="table table-condensed" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th>ID No</th>
                <th style="padding-left: 10px;">Enrollment No</th>
                <th style="padding-left: 10px;">Name</th>
                <th style="padding-left: 10px;">Admission Year</th>
                <th style="padding-left: 10px;">Admission Type</th>
                <th style="display: none;"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td style="horizontal-align:center;">{{$student['student_id']}}</td>
                <td style="align:center;">{{$student['enrollment_no']}}</td>
                <td>{{$student['name']}}</td>
                
                <td>
                {{$student['admission_year']}}
                </td>

                <td>
                @if($student['admission_type']=='D2D')
                Diploma to Degree
                @elseif($student['admission_type']=='REGULAR')
                HSC to Degree
                @endif
                </td>

                <td class="graduation_year" style="display: none;">
                @if($student['admission_type']=='REGULAR')
                    {{$student['admission_year']+4+$changeyear}}
                @else
                    {{$student['admission_year']+3+$changeyear}}
                @endif
                </td>

                <td>
                
                <form action="{{url('admin/student_verified')}}" method="POST">
                @csrf
                <input type="hidden" name="verify_student_id" value="{{$student['student_id']}}">

                <input type="submit" class="btn btn-info" value="Verify">
                </form>
                </td>

            </tr>
            @endforeach            
        </tbody>
    </table>
</div>
@endsection


@section('customJS')
<script type="text/javascript">
$(document).ready(function() {

    var table = $('#example').DataTable({
      "ordering": false,
      "bInfo":false,
      "dom": '<"top"i>rt<"bottom"flp><"clear">'
    });

    $('#custom_age').on('change',function(){
      table.column(5).search( $(this).val()).draw();
    });
    /*$("#example tfoot th").each( function ( i ) 
    {
        var select = $('<select><option value="">All</option></select>')
            .appendTo( $(this).empty() )
            .on( 'change', function () {
                table.column( i )
                    .search( $(this).val() )
                    .draw();
            } );
 
    });*/
} );
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection