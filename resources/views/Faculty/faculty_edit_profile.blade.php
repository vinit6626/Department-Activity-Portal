@extends('layouts.faculty_dash_layout')

@section('content')
<div class="row" style="vertical-align:middle;">
  <span style="font-size: 27px;">Edit Profile</span>
  <a class="btn btn-info" style="float:right;" href="{{url('faculty/dashboard')}}">View Profile</a>
  <hr style="margin-top:5px;">
</div>

<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    <div class="text-center">
      <img src="{{asset(($faculty['profile_image']!='')?'images/profiles/faculties/'.$faculty['profile_image'].'':'images/profiles/user.jpg')}}" style="width:200px;height:200px;" class="avatar img-circle" alt="User Profile">
      <h6>Upload a different photo...</h6>
      <form role="form"  method="POST" enctype="multipart/form-data" action="{{url('faculty/editprofile_data')}}">
      @csrf
      <input name="new_profile" type="file" class="form-control"/>
      @if($errors->has('new_profile'))
        <span style="color:red;"><strong>{{$errors->first('new_profile')}}</strong></span>
      @endif
    </div>
    </div>

    <!-- edit form column -->
    <div class="col-md-9 personal-info">

    <center><h3>Personal information</h3></center>
    <br/>

    <div class="form-horizontal">
     
      <div class="form-group">
        <label class="col-lg-3 control-label">Email:</label>
        <div class="col-lg-8">
          <input name="email" class="form-control" type="text" value="{{old('email', $faculty['email'])}}"/>
          @if($errors->has('email'))
          <span style="color:red;"><strong>{{$errors->first('email')}}</strong></span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Contact Number:</label>
        <div class="col-md-8">
          <input name="contact_no" class="form-control" type="text" value="{{old('contact_no',$faculty['contact_no'])}}"/>
          @if($errors->has('contact_no'))
          <span style="color:red;">
            <strong>{{$errors->first('contact_no')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <input type="submit" class="btn btn-primary" value="Save Changes">
          <span></span>
        </div>
      </div>

      @if(session()->has('success_message'))
        <div class="form-group">
          <div class="col-md-3"></div>
          <div class="col-md-8">
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{session('success_message')}}
            </div>
          </div>
        </div>
        @endif

    </div>
</form>
    </div>
</div>
@endsection

@section('customJS')
@endsection