@extends('layouts.faculty_dash_layout')

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('faculty/show/research_development')}}"><b><span style="font-size:17px;">Research & Development</span></b></a></li>
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
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/edit/research_development/'.$activity['sr_no'])}}">
      @csrf

      <div class="form-group">
        <label class="col-md-3 control-label">Approval letter no:</label>
        <div class="col-md-8">
          <input name="approval_letter_no" ng-model="approval_letter_no" class="form-control" type="text"required autofocus/>

          <span style="color:red;" ng-show="myForm.approval_letter_no.$dirty && myForm.approval_letter_no.$invalid">
              <span ng-show="myForm.approval_letter_no.$error.required"><strong>Please enter approval letter no</strong>  
              </span>
          </span>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Description:</label>
        <div class="col-md-8">
          <textarea name="description" ng-model="description" class="form-control" required autofocus></textarea>

          <span style="color:red;" ng-show="myForm.description.$dirty && myForm.description.$invalid">
              <span ng-show="myForm.description.$error.required"><strong>Please enter description</strong>  
              </span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Funding Agency:</label>
        <div class="col-md-8">
          <input name="funding_agency" ng-model="funding_agency" class="form-control" type="text" required autofocus/>

          <span style="color:red;" ng-show="myForm.funding_agency.$dirty && myForm.funding_agency.$invalid">
              <span ng-show="myForm.funding_agency.$error.required"><strong>Please enter name of funding agency</strong>  
              </span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Amount:</label>
        <div class="col-md-8">
          <input name="amount" value="<?php echo (old('amount')!=''? old('amount'):$activity['amount']); ?>" ng-model="amount" class="form-control" type="number" min="1" required autofocus/>
          <span style="color:red;" ng-show="myForm.amount.$dirty && myForm.amount.$invalid">
              <span ng-show="myForm.amount.$error.required"><strong>Please enter granted amount</strong>
          </span>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">PI:</label>
        <div class="col-md-8">
          <input type="text" name="PI" ng-model="PI" class="form-control"required autofocus/>
          <span style="color:red;" ng-show="myForm.PI.$dirty && myForm.PI.$invalid">
              <span ng-show="myForm.PI.$error.required"><strong>Please enter PI</strong>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">CI:</label>
        <div class="col-md-8">
          <input name="CI" ng-model="CI" class="form-control" type="text" required autofocus/>
          <span style="color:red;" ng-show="myForm.CI.$dirty && myForm.CI.$invalid">
              <span ng-show="myForm.CI.$error.required"><strong>Please enter CI</strong>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">From Date:</label>
        <div class="col-md-8">
          <input name="from_date" value="{{old('from_date')!=''? old('from_date'):$activity['from_date']}}" ng-model="from_date" class="form-control" type="date" ng-change="check_startdate(from_date)" required autofocus/>

          <span style="color:red;" ng-show="myForm.from_date.$dirty && myForm.from_date.$invalid">
              <span ng-show="myForm.from_date.$error.required">
                <strong>Please select starting date</strong>
              </span>
          </span>

          <span style="color:red">
            <b><span ng-bind="err_startdate"></span></b>
          </span>

        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">To Date:</label>
        <div class="col-md-8">
          <input name="to_date" ng-model="to_date" value="{{old('to_date')!=''? old('to_date'):$activity['to_date']}}" class="form-control" type="date" ng-change="check_enddate(from_date,to_date)" required autofocus/>
          
          <span style="color:red;" ng-show="myForm.to_date.$dirty && myForm.to_date.$invalid">
              <span ng-show="myForm.to_date.$error.required">
                <strong>Please select ending date</strong>
              </span>
          </span>

          <span style="color:red">
            <b><span ng-bind="err_enddate"></span></b>
          </span>

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
        <label class="col-md-3 control-label">File:</label>
        <div class="col-md-8">
          <input type="file" name="proof_file" ng-model="proof_file" onchange="angular.element(this).scope().setFile(this);"  class="form-control" autofocus/>
          <span style="color:red">
            <b><span ng-bind="FileMessage"></span></b>
          </span>
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
          <input type="submit" class="btn btn-primary" ng-disabled="myForm.ISSN.$invalid || myForm.book_name.$invalid || myForm.publication_house.$invalid ||  myForm.authors.$invalid || myForm.publication_month.$invalid || myForm.publication_year.$invalid || myForm.academic_year.$invalid || myForm.academic_semester.$invalid || fileInvalid" value="Submit">
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

    $scope.description="<?php echo (old('description')!=''? old('description'):$activity['description']); ?>";
    $scope.approval_letter_no="<?php echo (old('approval_letter_no')!=''? old('approval_letter_no'):$activity['approval_letter_no']); ?>";
    $scope.funding_agency="<?php echo (old('funding_agency')!=''? old('funding_agency'):$activity['funding_agency']); ?>";
    $scope.amount="<?php echo (old('amount')!=''? old('amount'):$activity['amount']); ?>";
    $scope.PI="<?php echo (old('PI')!=''? old('PI'):$activity['PI']); ?>";
    $scope.CI="<?php echo (old('CI')!=''? old('CI'):$activity['CI']); ?>";
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