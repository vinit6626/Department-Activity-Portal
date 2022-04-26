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
    <li><a href="{{url('admin/show/all/counselors')}}"><b><span style="font-size:17px;">View Details</span></b></a></li>
    <li class="active"><a href="#"><b><span style="font-size:17px;">Manage Counselors</span></b></a></li>
</ul>

@if(session()->has('success_message'))
<div class="row">
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{session('success_message')}}
</div>
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
<div class="col-md-3">
<b>Faculty:</b><br/>
<select id="list_of_counselors" class="form-control" style="margin-bottom:5px;">
    <!-- {{date('Y')-4+$changeyear+3}} -->
    <option value="">All</option>
    @foreach($counselors as $counselor_name)
    <option value="{{$counselor_name->name}}">{{$counselor_name->name}}</option>
    @endforeach
</select>
</div>
<div class="col-md-7"></div>
<div class="col-md-2"></div>

</div>

<div class="table-responsive">
    <table id="example" class="display" class="table table-condensed" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;">Faculty Name</th>
                <th style="padding-left: 10px;">Faculty Email</th>
                <th style="padding-left: 10px;">Faculty Contact</th>
                <th style="padding-left: 10px;">Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach($counselors as $counselor)
            <tr>
                <td>{{$counselor['name']}}</td>
                <td>{{$counselor['email']}}</td>
                <td>{{$counselor['contact_no']}}</td>
                
                <td>
                <form action="{{url('admin/counselors/remove_counselor')}}" method="POST">
                @csrf
                <input type="hidden" name="faculty_id" value="{{$counselor['faculty_id']}}">

                <input type="submit" class="btn btn-info" value="Remove">
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
    $('#list_of_counselors').on('change',function(){
        table.column(0).search( $(this).val()).draw();
    });
} );
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection