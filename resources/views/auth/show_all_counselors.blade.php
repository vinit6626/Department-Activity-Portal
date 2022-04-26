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
    <li class="active"><a href="#"><b><span style="font-size:17px;">View Details</span></b></a></li>
    <li><a href="{{url('admin/counselors/manage')}}"><span style="font-size:17px;">Manage Counselors</span></a></li>
</ul>

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
<div class="col-md-3">
<b>Faculty:</b><br/>
<select id="list_of_counselors" class="form-control" style="margin-bottom:5px;">
    <!-- {{date('Y')-4+$changeyear+3}} -->
    <option value="">All</option>
    @foreach($list_of_counselors as $counselor_name)
    <option value="{{$counselor_name->name}}">{{$counselor_name->name}}</option>
    @endforeach
</select>
</div>
<div class="col-md-7"></div>
<div class="col-md-2">
<b>Year of Student:</b><br/>
<select id="year_of_students" class="form-control" style="margin-bottom:5px;">
    <!-- {{date('Y')-4+$changeyear+3}} -->
    <option value="">All</option>
    <option value="{{date('Y')+4+$changeyear}}">First Year Students</option>
    <option value="{{date('Y')+3+$changeyear}}">Second Year Students</option>
    <option value="{{date('Y')+2+$changeyear}}">Third Year Students</option>
    <option value="{{date('Y')+1+$changeyear}}">Fourth Year Students</option>
</select>
</div>

</div>

<div class="table-responsive">
    <table id="example" class="display" class="table table-condensed" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;">Faculty Name</th>
                <th style="padding-left: 10px;">Student ID</th>
                <th style="padding-left: 10px;">Student Admission Year</th>
                <th style="padding-left: 10px;">Student Admission Type</th>
                <th style="display: none;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($counselors as $counselor)
            <tr>
                <td>{{$counselor['name']}}</td>
                <td>{{$counselor['student_id']}}</td>
                <td>{{$counselor['admission_year']}}</td>
                <td>
                @if($counselor['admission_type']=='D2D')
                Diploma to Degree
                @elseif($counselor['admission_type']=='REGULAR')
                HSC to Degree
                @endif
                </td>

                <td class="graduation_year" style="display: none;">
                @if($counselor['admission_type']=='REGULAR')
                    {{$counselor['admission_year']+4+$changeyear}}
                @else
                    {{$counselor['admission_year']+3+$changeyear}}
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
      "ordering": false,
      "bInfo":false,
      "dom": '<"top"i>rt<"bottom"flp><"clear">'
    });
    $('#list_of_counselors').on('change',function(){
        table.column(0).search( $(this).val()).draw();
    });
    $('#year_of_students').on('change',function(){
      table.column(4).search( $(this).val()).draw();
    });
} );
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection