@extends('layouts.admin_dash_layout')

@section('content')
<div class="row" style="vertical-align:middle;">
  <center><h3>Change Password</h3></center>
  <hr>
</div>

<div class="row">

    <!-- edit form column -->
  <div class="col-md-12 personal-info">

    <form role="form"  method="POST" enctype="multipart/form-data" action="{{url('admin/change_password')}}">
    @csrf

    <div class="form-horizontal">
     
      <div class="change_password">

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

        <div class="form-group">
          <label class="col-md-3 control-label">Old Password:</label>
          <div class="col-md-8">
            <input name="old_password" class="form-control" type="password" placeholder="Enter old password" value="{{old('old_password')}}" />
            @if ($errors->has('old_password'))
            <span class="invalid-feedback" style="color:red">
                <strong>{{ $errors->first('old_password')}}</strong>
            </span>
            @endif

            <span class="invalid-feedback" style="color:red">
                <strong>{{(session()->has('password_not_available'))?session('password_not_available'):''}}
                </strong>
            </span>
          
          </div>
          <!-- @if (session()->has('password_not_available'))
            {{session('password_not_available')}}
            {{session()->has('password_not_available')}}
          @endif -->          
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">New Password:</label>
          <div class="col-md-8">
            <input name="new_password" class="form-control" type="password" placeholder="Enter new password" value="{{old('new_password')}}"/>

            @if ($errors->has('new_password'))
            <span class="invalid-feedback" style="color:red">
                <strong>{{ $errors->first('new_password') }}</strong>
            </span>
            @endif
          </div>
          
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Confirm Password:</label>
          <div class="col-md-8">
            <input name="confirm_password" class="form-control" type="password" placeholder="Enter password again" value="{{old('confirm_password')}}" />
            @if ($errors->has('confirm_password'))
            <span class="invalid-feedback" style="color:red">
                <strong>{{ $errors->first('confirm_password') }}</strong>
            </span>
            @endif
          </div>
           
        </div>

      </div>


      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <input type="submit" class="btn btn-primary" value="Change Password">
          <span></span>
        </div>
      </div>

    </div>
    </form>
  </div>
</div>

      
@endsection

@section('customJS')

@endsection