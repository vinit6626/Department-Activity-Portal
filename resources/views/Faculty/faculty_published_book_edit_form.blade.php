@extends('layouts.faculty_dash_layout')

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('faculty/show/published/books')}}"><b><span style="font-size:17px;">Published Books</span></b></a></li>
    <li class="active"><a href="#"><b><span style="font-size:17px;">Edit Book Details</span></b></a></li>
</ul>

<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>

    <div class="form-horizontal">
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/edit/published_book/'.$activity['sr_no'])}}">
      @csrf

      <div class="form-group">
        <label class="col-md-3 control-label">ISBN:</label>
        <div class="col-md-8">
          <input name="ISBN" ng-model="ISBN" class="form-control" type="text"required autofocus/>

          <span style="color:red;" ng-show="myForm.ISBN.$dirty && myForm.ISBN.$invalid">
              <span ng-show="myForm.ISBN.$error.required"><strong>Please enter ISBN</strong>  
              </span>
          </span>
          @if($errors->has('ISBN'))
                <span style="color:red;">
                  <strong>{{$errors->first('ISBN')}}</strong>
                </span>
          @endif
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Book Name:</label>
        <div class="col-md-8">
          <input name="book_name" ng-model="book_name" class="form-control" type="text" required autofocus/>

          <span style="color:red;" ng-show="myForm.book_name.$dirty && myForm.book_name.$invalid">
              <span ng-show="myForm.book_name.$error.required"><strong>Please enter book name</strong>  
              </span>
          </span>
          @if($errors->has('book_name'))
                <span style="color:red;">
                  <strong>{{$errors->first('book_name')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Publication House:</label>
        <div class="col-md-8">
          <input name="publication_house" ng-model="publication_house" class="form-control" type="text" required autofocus/>

          <span style="color:red;" ng-show="myForm.publication_house.$dirty && myForm.publication_house.$invalid">
              <span ng-show="myForm.publication_house.$error.required"><strong>Please enter name of publication house</strong>  
              </span>
          </span>
          @if($errors->has('publication_house'))
                <span style="color:red;">
                  <strong>{{$errors->first('publication_house')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Authors:</label>
        <div class="col-md-8">
          <input name="authors" ng-model="authors" class="form-control" type="text" placeholder="Names separated by commas followed by one space" 
          ng-pattern="/^([A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)(\s,[A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)*$/" required autofocus/>
          <span style="color:red;" ng-show="myForm.authors.$dirty && myForm.authors.$invalid">
              <span ng-show="myForm.authors.$error.required"><strong>Please enter paper type </strong>
              </span>
              <span ng-show="myForm.authors.$error.pattern"><strong>Please enter authors name in proper format(e.g Kanu G. Patel, Micheline Kamber, Jian Pei)</strong>
              </span>
          </span>
          @if($errors->has('authors'))
                <span style="color:red;">
                  <strong>{{$errors->first('authors')}}</strong>
                </span>
          @endif
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Publication Month:</label>
        <div class="col-md-8">
          <input name="publication_month" ng-model="publication_month" class="form-control" type="number" value="<?php echo (old('publication_month')!=''? old('publication_month'):$activity['publication_month']); ?>" min="1" max="12" placeholder="Month in 2 digits(e.g. 01, 12, etc)" ng-minlength="2" ng-maxlength="2" required autofocus/>
          <span style="color:red;" ng-show="myForm.publication_month.$dirty && myForm.publication_month.$invalid">
              <span ng-show="myForm.publication_month.$error.required"><strong>Please enter publication month </strong>
              </span>
              <span ng-show="myForm.publication_month.$error.minlength || myForm.publication_month.$error.maxlength"><strong>Please enter month in 2 digits(e.g. 01, 10, 12)</strong>
              </span>
          </span>
          @if($errors->has('publication_month'))
                <span style="color:red;">
                  <strong>{{$errors->first('publication_month')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Publication Year:</label>
        <div class="col-md-8">
          <input name="publication_year" ng-model="publication_year" class="form-control" type="number" placeholder="Year in 4 digits(e.g. 2020)" value="<?php echo (old('publication_year')!=''? old('publication_year'):$activity['publication_year']); ?>" ng-minlength="4" ng-maxlength="4" required autofocus/>
          <span style="color:red;" ng-show="myForm.publication_year.$dirty && myForm.publication_year.$invalid">
              <span ng-show="myForm.publication_year.$error.required"><strong>Please enter publication year </strong>
              </span>
              <span ng-show="myForm.publication_year.$error.minlength || myForm.publication_year.$error.maxlength"><strong>Please enter year in 4 digits(e.g. 2015)</strong>
              </span>
          </span>
          @if($errors->has('publication_year'))
                <span style="color:red;">
                  <strong>{{$errors->first('publication_year')}}</strong>
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
        <label class="col-md-3 control-label">File:</label>
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
          <input type="submit" class="btn btn-primary" ng-disabled="myForm.ISSN.$invalid || myForm.book_name.$invalid || myForm.publication_house.$invalid ||  myForm.authors.$invalid || myForm.publication_month.$required ||
          myForm.publication_month.$error.min || myForm.publication_month.$error.max ||
          myForm.publication_month.$error.minlength || myForm.publication_month.$error.maxlength ||
          myForm.publication_year.$required || myForm.publication_year.$error.minlength || myForm.publication_year.$error.maxlength || myForm.academic_year.$invalid || myForm.academic_semester.$invalid || fileInvalid" value="Submit">
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

    $scope.ISBN="<?php echo (old('ISBN')!=''? old('ISBN'):$activity['ISBN']); ?>";
    $scope.book_name="<?php echo (old('book_name')!=''? old('book_name'):$activity['book_name']); ?>";
    $scope.authors="<?php echo (old('authors')!=''? old('authors'):$activity['authors']); ?>";
    $scope.publication_house="<?php echo (old('publication_house')!=''? old('publication_house'):$activity['publication_house']); ?>";
    $scope.publication_month="<?php echo (old('publication_month')!=''? old('publication_month'):$activity['publication_month']); ?>";
    $scope.publication_year="<?php echo (old('publication_year')!=''? old('publication_year'):$activity['publication_year']); ?>";
    $scope.academic_year="<?php echo (old('academic_year')!=''? old('academic_year'):$activity['academic_year']); ?>";
    $scope.academic_semester="<?php echo (old('academic_semester')!=''? old('academic_semester'):$activity['academic_semester']); ?>";
    
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