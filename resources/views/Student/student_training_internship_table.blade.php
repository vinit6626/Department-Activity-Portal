@extends('layouts.student_dash_layout')

@section('customStyle')

<link rel="stylesheet" href="{{asset('css/jquery.dataTables.css')}}">
<style type="text/css">
  .dataTables_filter{
    display: none;
  }
  table.dataTable thead th {
  font-weight: !important;
  border-right: 1px solid rgb(221, 221, 221);
  }
</style>
@endsection

@section('content')

<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li class="active"><a href="#"><b><span style="font-size:17px;">Trainings and Internships</span></b></a></li>
</ul>
<br/>

@if(session()->has('success_message'))
  <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{session('success_message')}}
  </div>
@endif

<div class="table-responsive">
    <table id="example" class="table table-condensed display cell-border" style="width:100%;margin-bottom: 20px;border-top:1px solid rgb(221, 221, 221)
;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;vertical-align:middle;">Sr no</th>

                <th style="padding-left: 10px;border-left:1px solid rgb(221, 221, 221);vertical-align:middle;">Training/Internship</center></th>
                <th style="padding-left: 10px;vertical-align:middle;">Title</th>
                <th style="padding-left: 10px;vertical-align:middle;">Place</th>
                <th style="padding-left: 10px;vertical-align:middle;">From date</th>
                <th style="padding-left: 10px;vertical-align:middle;">To date</th>                
                <th style="padding-left: 10px;vertical-align:middle;">Academic year</th>
                <th style="padding-left: 10px;vertical-align:middle;">Academic semester</th>
                <th style="padding-left: 10px;vertical-align:middle;">File</th>
                <th style="padding-left: 10px;vertical-align:middle;">Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
          
            @foreach($activities as $activity)
            <tr>
                <td>{{++$i}}</td>
                <td>{{$activity['training_or_internship']}}</td>
                <td>{{$activity['title']}}</td>
                <td>{{$activity['place']}}</td>
                <td>{{$activity['from_date']}}</td>
                <td>{{$activity['to_date']}}</td>
                <td>{{$activity['academic_year']}}</td>
                <td>{{$activity['academic_semester']}}</td>
                <td>
                  @if($activity['file']=='')
                  <center>-</center>
                  @else
                  <a href="{{asset('activities/student/'.$activity['file'].'')}}" target="_blank">File</a>
                  @endif
                </td>
                <td><a href="{{url('student/edit/training_internship/'.$activity['sr_no'])}}">Edit</a>
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
      "dom": '<"top"i>rt<"bottom"flp><"clear">',
      
    });

});
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection