@extends('layouts.student_dash_layout')
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
  <a class="btn btn-info" style="float: right;" href="{{url('student/profile/edit')}}">Edit Profile</a> 
  <hr style="margin-top:5px;">
</div>
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    <div class="text-center">
        <img src="{{asset(($student['profile_image']!='')?'images/profiles/students/'.$student['profile_image'].'':'/images/profiles/user.jpg')}}" style="width:200px;height:200px;" class="avatar img-circle" alt="User Profile">
        <h4>{{$student['name']}} 
            @if($student['is_verified']==1)
            <span class="glyphicon glyphicon-ok-circle" style="color:green"></span>
            @endif
        </h4>
      
    </div>
    </div>

    <div class="col-md-9 personal-info">
        @if($student['is_verified']==0)
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          Your Account is not verified by Admin.
        </div>
        @endif
        <center><h3>Personal Information</h3></center>
        <br/>
        
        <div class="form-horizontal">
            <div class="form-group">
            <label class="col-lg-3 control-label">Name:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['name']}}
                </div>
            </div>
            </div>
            
            <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['email']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">ID Number:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['student_id']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Enrollment Number:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['enrollment_no']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Department:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['department']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Contact Number:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['contact_no']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Admission Year:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$student['admission_year']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Admission Type:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    @if($student['admission_type']=='REGULAR')
                    HSC to Degree
                    @else
                    Diploma to Degree
                    @endif
                </div>
            </div>
            </div>

        </div>
        
    </div>
</div>


@endsection
