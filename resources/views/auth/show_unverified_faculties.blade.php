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
    <li><a href="{{url('admin/show/faculties/verified')}}"><span style="font-size:17px;">Verified Accounts</span></a></li>
</ul>

@if(session()->has('faculty_verified'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{session('faculty_verified')}}
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
                
                <form action="{{url('admin/faculty_verified')}}" method="POST">
                @csrf
                <input type="hidden" name="verify_faculty_id" value="{{$faculty['faculty_id']}}">

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

} );
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endsection