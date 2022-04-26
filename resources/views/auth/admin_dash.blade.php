@extends('layouts.admin_dash_layout')
@section('customStyle')
    <style type="text/css">
        .myTextDisplayBox{
            padding:7px;word-wrap: break-word;height:100%;border:1px solid rgb(204, 204, 204);
            border-radius:4px;
            box-sizing:border-box;
        }
    </style>
@endsection
@section('content')

<div class="row" style="vertical-align:middle;">
  <span style="font-size: 27px;">Profile</span>
  <a class="btn btn-info" style="float: right;" href="{{url('admin/profile/edit')}}">Edit Profile</a> 
  <hr style="margin-top:5px;">
</div>
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    <div class="text-center">
        <img src="{{asset(($admin['profile_image']!='')?'images/profiles/admins/'.$admin['profile_image'].'':'/images/profiles/user.jpg')}}" style="width:200px;height:200px;" class="avatar img-circle" alt="User Profile">
        <h4>{{$admin['name']}} 
         <span class="glyphicon glyphicon-ok-circle" style="color:green"></span>
        </h4>
    </div>
    </div>

    <div class="col-md-9 personal-info">
        
        <center><h3>Personal Information</h3></center>
        <br/>
        
        <div class="form-horizontal">
            <div class="form-group">
            <label class="col-lg-3 control-label">Name:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$admin['name']}}
                </div>
            </div>
            </div>
            
            <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$admin['email']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Department:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$admin['department']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Contact Number:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$admin['contact_no']}}
                </div>
            </div>
            </div>

        </div>
        
    </div>
</div>


@endsection
