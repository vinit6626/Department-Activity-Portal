@extends('layouts.counselor_dash_layout')
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
</div>
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    <div class="text-center">
        <img src="{{asset(($faculty['profile_image']!='')?'images/profiles/faculties/'.$faculty['profile_image'].'':'/images/profiles/user.jpg')}}" style="width:200px;height:200px;" class="avatar img-circle" alt="User Profile">
      <h4>{{$faculty['name']}} 
         @if($faculty['is_verified']==1)
         <span class="glyphicon glyphicon-ok-circle" style="color:green"></span>
         @endif
    </h4>
      
    </div>
    </div>

    <div class="col-md-9 personal-info">
        @if($faculty['is_verified']==0)
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
                    {{$faculty['name']}}
                </div>
            </div>
            </div>
            
            <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$faculty['email']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Department:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$faculty['department']}}
                </div>
            </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Is Counselor?</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    @if($faculty['is_counselor']==1)
                        Yes
                    @else
                        No
                    @endif
                </div>
            </div>
            </div>


            <div class="form-group">
            <label class="col-lg-3 control-label">Contact Number:</label>
            <div class="col-lg-8">
                <div class="myTextDisplayBox">
                    {{$faculty['contact_no']}}
                </div>
            </div>
            </div>

        </div>
        
    </div>
</div>

@endsection
