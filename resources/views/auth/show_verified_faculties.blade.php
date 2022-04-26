@extends('layouts.admin_dash_layout')

@section('customStyle')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style type="text/css">
  .dataTables_filter{
    display: none;
  }
</style>
@endsection

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('admin/show/faculties/unverified')}}"><span style="font-size:17px;">Unverified Accounts</span></b></a></li>
    <li class="active"><a href="#"><span style="font-size:17px;">Verified Accounts</span></a></li>
</ul>

@if(session()->has('faculty_unverified'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{session('faculty_unverified')}}
</div>
@endif

<div class="table-responsive">
    <table id="example" class="display" class="table table-condensed" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;">Name</th>
                <th style="padding-left: 10px;">Email</th>
                <th style="padding-left: 10px;">Contact Number</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($faculties as $faculty)
            <tr>
                <td style="align:center;">{{$faculty['name']}}</td>
                <td style="align:center;">{{$faculty['email']}}</td>
                <td style="align:center;">{{$faculty['contact_no']}}</td>

                <td>
                
                <form action="{{url('admin/faculty_make_unverified')}}" method="POST">
                @csrf
                <input type="hidden" name="unverify_faculty_id" value="{{$faculty['faculty_id']}}">

                <input type="submit" class="btn btn-info" value="Unverify">
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

} );
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endsection