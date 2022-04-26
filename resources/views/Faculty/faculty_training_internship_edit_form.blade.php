@extends('layouts.faculty_dash_layout')

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('faculty/show/trainings_internships')}}"><b><span style="font-size:17px;">Trainings and Internships</span></b></a></li>
    <li class="active"><a href="#"><b><span style="font-size:17px;">Edit Activity Details</span></b></a></li>
</ul>


<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>

    <div class="form-horizontal">
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/edit/training_internship/'.$activity['sr_no'])}}">
      @csrf
      <div class="form-group">
          <label class="col-md-3 control-label">Type:</label>

          <div class="col-md-8">
              <div class="" style="padding-top:7px;">
              <input type="radio" name="type" ng-model="type" value="Training" ng-required="!type">Training
              &nbsp; &nbsp; &nbsp;
              <input type="radio" name="type" ng-model="type" value="Internship" ng-required="!type">Internship
              </div>
             
              <!-- 
              <span style="color:red;" ng-show="!type">
              <span ng-show="myForm.type.$error.required"><strong>Please select type</strong>  
              </span>
              </span> -->

              @if($errors->has('type'))
                <span style="color:red;">
                  <strong>{{$errors->first('type')}}</strong>
                </span>
              @endif
              
          </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Title:</label>
        <div class="col-md-8">
          <input name="title" ng-model="title" class="form-control" type="text"required autofocus/>

          <span style="color:red;" ng-show="myForm.title.$dirty && myForm.title.$invalid">
              <span ng-show="myForm.title.$error.required"><strong>Please enter title</strong>  
              </span>
          </span>
          @if($errors->has('title'))
          <span style="color:red;">
            <strong>{{$errors->first('title')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Place:</label>
        <div class="col-md-8">
          <input name="place" ng-model="place" class="form-control" type="text"required autofocus/>
          <span style="color:red;" ng-show="myForm.place.$dirty && myForm.place.$invalid">
              <span ng-show="myForm.place.$error.required"><strong>Please enter place</strong>
          </span>
          @if($errors->has('place'))
          <span style="color:red;">
            <strong>{{$errors->first('place')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">From Date:</label>
        <div class="col-md-8">
          <input name="from_date"value="{{old('from_date')!=''? old('from_date'):$activity['from_date']}}" ng-model="from_date" class="form-control" type="date" ng-change="check_startdate(from_date)" required autofocus/>

          <span style="color:red;" ng-show="myForm.from_date.$dirty && myForm.from_date.$invalid">
              <span ng-show="myForm.from_date.$error.required">
                <strong>Please select starting date of activity</strong>
              </span>
          </span>

          <span style="color:red">
            <b><span ng-bind="err_startdate"></span></b>
          </span>

          @if($errors->has('from_date'))
          <span style="color:red;">
            <strong>{{$errors->first('from_date')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">To Date:</label>
        <div class="col-md-8">
          <input name="to_date" ng-model="to_date" value="{{old('to_date')!=''? old('to_date'):$activity['to_date']}}" class="form-control" type="date" ng-change="check_enddate(from_date,to_date)" required autofocus/>
          
          <span style="color:red;" ng-show="myForm.to_date.$dirty && myForm.to_date.$invalid">
              <span ng-show="myForm.to_date.$error.required">
                <strong>Please select ending date of activity</strong>
              </span>
          </span>

          <span style="color:red">
            <b><span ng-bind="err_enddate"></span></b>
          </span>

          @if($errors->has('to_date'))
          <span style="color:red;">
            <strong>{{$errors->first('to_date')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Academic Year:</label>
        <div class="col-md-8">
          <input name="academic_year" ng-model="academic_year" class="form-control" type="text" placeholder="Academic year(e.g. 2014-2015)" ng-pattern="/^[0-9]{4}[-][0-9]{4}$/" required autofocus/>
          <span style="color:red;" ng-show="myForm.academic_year.$dirty && myForm.academic_year.$invalid">
              <span ng-show="myForm.academic_year.$error.required"><strong>Please enter academic year </strong>
              </span>
              <span ng-show="myForm.academic_year.$error.pattern"><strong>Please enter academic year in proper format(e.g. 2014-2015)</strong>
              </span>
          </span>
          @if($errors->has('academic_year'))
                <span style="color:red;">
                  <strong>{{$errors->first('academic_year')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Academic semester:</label>
        <div class="col-md-8">
            <div class="" style="padding-top:7px;">
            <input type="radio" name="academic_semester" ng-model="academic_semester" value="odd" ng-required="!academic_semester">Odd
            &nbsp; &nbsp; &nbsp;
            <input type="radio" name="academic_semester" ng-model="academic_semester" value="even" ng-required="!academic_semester">Even
            </div>
            <span style="color:red;" ng-show="myForm.academic_semester.$dirty && myForm.academic_semester.$invalid">
              <span ng-show="myForm.academic_semester.$error.required"><strong>Please select academic semester </strong>
              </span>
            </span>
            @if($errors->has('academic_semester'))
                <span style="color:red;">
                  <strong>{{$errors->first('academic_semester')}}</strong>
                </span>
            @endif              
        </div>          
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Certificate File:</label>
        <div class="col-md-8">
          <input type="file" name="proof_file" ng-model="proof_file" onchange="angular.element(this).scope().setFile(this);"  class="form-control" autofocus/>
          <span style="color:red">
            <b><span ng-bind="FileMessage"></span></b>
          </span>
          @if($errors->has('proof_file'))
          <span style="color:red;">
            <strong>{{$errors->first('proof_file')}}</strong>
          </span>
          @endif
        </div>
        <div class="col-md-1">
          @if($activity['file']!='')
          <a class="btn btn-warning" href="{{asset('activities/faculty/'.$activity['file'].'')}}" target="_blank">Old File</a>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <input type="submit" class="btn btn-primary" ng-disabled="!type || myForm.title.$invalid || myForm.place.$invalid || myForm.from_date.$invalid || myForm.to_date.$invalid || check_startdate(from_date) || check_enddate(from_date, to_date) || myForm.academic_year.$invalid || myForm.academic_semester.$invalid || fileInvalid" value="Submit">
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

    $scope.type="<?php echo (old('training_or_internship')!=''? old('training_or_internship'):$activity['training_or_internship']); ?>";
    $scope.title="<?php echo (old('title')!=''? old('title'):$activity['title']); ?>";
    $scope.place="<?php echo (old('place')!=''? old('place'):$activity['place']); ?>";
    $scope.from_date="<?php echo (old('from_date')!=''? old('from_date'):$activity['from_date']); ?>";
    $scope.to_date="<?php echo (old('to_date')!=''? old('to_date'):$activity['to_date']); ?>";
    $scope.academic_year="<?php echo (old('academic_year')!=''? old('academic_year'):$activity['academic_year']); ?>";
    $scope.academic_semester="<?php echo (old('academic_semester')!=''? old('academic_semester'):$activity['academic_semester']); ?>";
    
    $scope.check_startdate=function(from_date){
      $scope.err_startdate = '';
      $scope.curDate = new Date();
      if(new Date(from_date) > $scope.curDate){
       $scope.err_startdate = 'Starting date should not be after today.';
       return true;
      }
    };

    $scope.check_enddate = function(from_date,to_date) {
      $scope.err_enddate = '';
      if(new Date(from_date) > new Date(to_date)){
        $scope.err_enddate = 'Ending date should be greater than starting date';
        return true;
      }
      $scope.curDate = new Date();
      if(new Date(to_date) > $scope.curDate){
       $scope.err_enddate = 'Ending date should not be after today.';
       return true;
      }

    };

    $scope.fileInvalid=false;
    $scope.setFile = function(element) {
      $scope.$apply(function($scope) {
          $scope.theFile = element.files[0];
          $scope.FileMessage = '';
          var filename = $scope.theFile.name;
          var index = filename.lastIndexOf(".");
          var strsubstring = filename.substring(index, filename.length);
          if (strsubstring == '.pdf' || strsubstring == '.doc' || strsubstring == '.docx' || strsubstring == '.png' || strsubstring == '.PNG' || strsubstring == '.jpeg' || strsubstring == '.JPEG' || strsubstring == '.jpg' || strsubstring == '.JPG' || strsubstring == '.PDF' || strsubstring == '.DOC' || strsubstring == '.DOCX')
          {
              $scope.fileInvalid=false;
              /*$scope.myForm.$setValidity('errFile', true);*/
          }
          else 
          {
              $scope.theFile = '';
              $scope.FileMessage = 'File type should be pdf, doc or image(.jpeg/.jpg/.png)';
              /*$scope.myForm.$setValidity('errFile', false);*/
              $scope.fileInvalid=true;
          }
      });
    };

});
  
</script>

@endsection