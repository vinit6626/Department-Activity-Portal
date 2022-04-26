@extends('layouts.counselor_dash_layout')

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
    <li class="active"><a href="#"><b><span style="font-size:17px;">Students Under My Counselling</span></b></a></li>
    <!-- <li><a href="{{url('admin/')}}"><span style="font-size:17px;">Manage Counselors</span></a></li> -->
</ul>

<div class="table-responsive">
    <table id="example" class="display" class="table table-condensed" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;">Student ID</th>
                <th style="padding-left: 10px;">Enrollment no</th>
                <th style="padding-left: 10px;">Name</th>
                <th style="padding-left: 10px;">Email</th>
                <th style="padding-left: 10px;">Contact no</th>                
                <th style="padding-left: 10px;">Admission Year</th>
                <th style="padding-left: 10px;">Admission Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{$student['student_id']}}</td>
                <td>{{$student['enrollment_no']}}</td>
                <td>{{$student['name']}}</td>
                <td>{{$student['email']}}</td>
                <td>{{$student['contact_no']}}</td>
                <td>{{$student['admission_year']}}</td>
                <td>
                @if($student['admission_type']=='D2D')
                Diploma to Degree
                @elseif($student['admission_type']=='REGULAR')
                HSC to Degree
                @endif
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
      //"ordering": false,
      "bInfo":false,
      "dom": '<"top"i>rt<"bottom"flp><"clear">'
    });
} );
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection