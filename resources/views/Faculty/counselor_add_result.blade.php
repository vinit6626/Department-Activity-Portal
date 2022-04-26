@extends('layouts.counselor_dash_layout')

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
    <li class="active"><a href="#"><b><span style="font-size:17px;">Add Result</span></b></a></li>
    <!-- <li><a href="{{url('admin/')}}"><span style="font-size:17px;">Manage Counselors</span></a></li> -->
</ul>

<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>

    <div class="form-horizontal">
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/counselor/add/result')}}">
      @csrf

        <div class="form-group">
            <label class="col-md-3 control-label">Select Student:</label>
            <div class="col-md-8">
              <select name="student_id" ng-model="student_id" class="form-control"required autofocus>
                <option value="">------Select------</option>
                @foreach($students as $student)
                <option value="{{$student['student_id']}}">{{$student['student_id']}}</option>
                @endforeach
              </select>

              <span style="color:red;" ng-show="myForm.student_id.$dirty && myForm.student_id.$invalid">
                  <span ng-show="myForm.student_id.$error.required"><strong>Please select student</strong>
                  </span>
              </span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Semester:</label>
            <div class="col-md-8">
              <select name="semester" ng-model="semester" class="form-control" required autofocus>
                <option value="">------Select------</option>
                <option value="sem1">Semester 1</option>
                <option value="sem2">Semester 2</option>
                <option value="sem3">Semester 3</option>
                <option value="sem4">Semester 4</option>
                <option value="sem5">Semester 5</option>
                <option value="sem6">Semester 6</option>
                <option value="sem7">Semester 7</option>
                <option value="sem8">Semester 8</option>
              </select>
              <span style="color:red;" ng-show="myForm.semester.$dirty && myForm.semester.$invalid">
                  <span ng-show="myForm.semester.$error.required"><strong>Please select semester</strong>
              </span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">SPI:</label>
            <div class="col-md-8">
                <input name="spi" ng-model="spi" class="form-control" type="number" min="0" max="10" step="any" required autofocus/>
                <span style="color:red;" ng-show="myForm.spi.$dirty && myForm.spi.$invalid">
                  <span ng-show="myForm.spi.$invalid"><strong>Please enter spi (between 0 to 10)</strong>
                  </span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">CPI:</label>
            <div class="col-md-8">
                <input name="cpi" ng-model="cpi" class="form-control" type="number" min="0" max="10" step="any" required autofocus/>
                <span style="color:red;" ng-show="myForm.cpi.$dirty && myForm.cpi.$invalid">
                  <span ng-show="myForm.spi.$invalid"><strong>Please enter cpi (between 0 to 10)</strong>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
            <input type="submit" class="btn btn-primary" ng-disabled="myForm.student_id.$invalid || myForm.semester.$invalid || myForm.spi.$invalid || myForm.cpi.$invalid" value="Submit">
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
<script type="text/javascript">

var app = angular.module('myApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

app.controller('myCtrl', function($scope) {

    $scope.student_id="<?php echo old('student_id'); ?>";
    $scope.semester="<?php echo old('semester'); ?>";
    $scope.spi="<?php echo old('spi'); ?>";
    $scope.cpi="<?php echo old('cpi'); ?>";

});
  
</script>

@endsection