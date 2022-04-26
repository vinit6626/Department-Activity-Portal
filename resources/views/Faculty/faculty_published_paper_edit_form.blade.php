@extends('layouts.faculty_dash_layout')

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('faculty/show/published/papers')}}"><b><span style="font-size:17px;">Published Papers</span></b></a></li>
    <li class="active"><a href="#"><b><span style="font-size:17px;">Edit Paper Details</span></b></a></li>
</ul>

<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>

    <div class="form-horizontal">
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/edit/published_paper/'.$activity['sr_no'])}}">
      @csrf


      <div class="form-group">
        <label class="col-md-3 control-label">Paper title:</label>
        <div class="col-md-8">
          <input name="paper_title" ng-model="paper_title" class="form-control" type="text" required autofocus/>

          <span style="color:red;" ng-show="myForm.paper_title.$dirty && myForm.paper_title.$invalid">
              <span ng-show="myForm.paper_title.$error.required"><strong>Please enter paper title</strong>  
              </span>
          </span>
          @if($errors->has('paper_title'))
                <span style="color:red;">
                  <strong>{{$errors->first('paper_title')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Authors Detail:</label>
        <div class="col-md-8">
          <input name="authors_detail" ng-model="authors_detail" class="form-control" type="text" placeholder="Names separated by commas followed by one space" 
          ng-pattern="/^([A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)(\s,[A-Za-z]+(.)?(\s[A-Za-z]+(.)?)*)*$/" required autofocus/>

          <span style="color:red;" ng-show="myForm.authors_detail.$dirty && myForm.authors_detail.$invalid">
              <span ng-show="myForm.authors_detail.$error.required"><strong>Please enter Authors Detail</strong>
              </span>
              <span ng-show="myForm.authors_detail.$error.pattern"><strong>Please enter authors name in proper format(e.g Ankur N. Patel, Micheline Kamber, Jian Pei)</strong>
              </span>
          </span>
          @if($errors->has('authors_detail'))
                <span style="color:red;">
                  <strong>{{$errors->first('authors_detail')}}</strong>
                </span>
          @endif
        </div>
      </div>     


      <div class="form-group">
        <label class="col-md-3 control-label">Paper Type:</label>
        <div class="col-md-8">
            <div class="" style="padding-top:7px;">
            <input type="radio" name="paper_type" ng-model="paper_type" value="National" ng-required="!paper_type">National
            &nbsp; &nbsp; &nbsp;
            <input type="radio" name="paper_type" ng-model="paper_type" value="International" ng-required="!paper_type">International
            </div>
            <span style="color:red;" ng-show="myForm.paper_type.$dirty && myForm.paper_type.$invalid">
              <span ng-show="myForm.paper_type.$error.required"><strong>Please select paper type </strong>
              </span>
          </span>
          @if($errors->has('paper_type'))
                <span style="color:red;">
                  <strong>{{$errors->first('paper_type')}}</strong>
                </span>
          @endif              
        </div>          
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">ISSN:</label>
        <div class="col-md-8">
          <input name="ISSN" ng-model="ISSN" class="form-control" type="text" autofocus/>

          @if($errors->has('ISSN'))
                <span style="color:red;">
                  <strong>{{$errors->first('ISSN')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">ISBN:</label>
        <div class="col-md-8">
          <input name="ISBN" ng-model="ISBN" class="form-control" type="text" autofocus/>

          @if($errors->has('ISBN'))
                <span style="color:red;">
                  <strong>{{$errors->first('ISBN')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">DOI Number:</label>
        <div class="col-md-8">
          <input name="DOI_number" ng-model="DOI_number" class="form-control" type="text" autofocus/>

          @if($errors->has('DOI_number'))
                <span style="color:red;">
                  <strong>{{$errors->first('DOI_number')}}</strong>
                </span>
          @endif
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-md-3 control-label">Conference Name:</label>
        <div class="col-md-8">
          <input name="conference_name" ng-model="conference_name" class="form-control" type="text" autofocus/>

          @if($errors->has('conference_name'))
                <span style="color:red;">
                  <strong>{{$errors->first('conference_name')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Journal Name:</label>
        <div class="col-md-8">
          <input name="journal_name" ng-model="journal_name" class="form-control" type="text" autofocus/>

          @if($errors->has('journal_name'))
                <span style="color:red;">
                  <strong>{{$errors->first('journal_name')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
          <label class="col-md-3 control-label">Published/Presented:</label>

          <div class="col-md-8">

              <div class="" style="padding-top:7px;">
              <input type="radio" name="published_or_presented" ng-model="published_or_presented" value="Published" ng-required="!published_or_presented">Published
              &nbsp; &nbsp; &nbsp;
              <input type="radio" name="published_or_presented" ng-model="published_or_presented" value="Presented" ng-required="!published_or_presented">Presented
              &nbsp; &nbsp; &nbsp;
              <input type="radio" name="published_or_presented" ng-model="published_or_presented" value="Published and Presented" ng-required="!published_or_presented">Published and Presented
              </div>              
          </div>
          @if($errors->has('published_or_presented'))
                <span style="color:red;">
                  <strong>{{$errors->first('published_or_presented')}}</strong>
                </span>
          @endif
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Volume and Issue:</label>
        <div class="col-md-8">
          <input name="volume_and_issue" ng-model="volume_and_issue" class="form-control" type="text" autofocus/>
          @if($errors->has('volume_and_issue'))
                <span style="color:red;">
                  <strong>{{$errors->first('volume_and_issue')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Page number:</label>
        <div class="col-md-8">
          <input name="page_num" ng-model="page_num" class="form-control" type="text" autofocus/>
          @if($errors->has('page_num'))
                <span style="color:red;">
                  <strong>{{$errors->first('page_num')}}</strong>
                </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Impact factor:</label>
        <div class="col-md-8">
          <input name="impact_factor" ng-model="impact_factor" class="form-control" type="text" autofocus/>
          @if($errors->has('impact_factor'))
                <span style="color:red;">
                  <strong>{{$errors->first('impact_factor')}}</strong>
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
          <input type="submit" class="btn btn-primary" ng-disabled=" myForm.paper_title.$invalid || myForm.authors_detail.$invalid ||myForm.paper_type.$invalid || 
          myForm.published_or_presented.$invalid ||
          myForm.publication_month.$required ||
          myForm.publication_month.$error.min || myForm.publication_month.$error.max ||
          myForm.publication_month.$error.minlength || myForm.publication_month.$error.maxlength ||
          myForm.publication_year.$required || myForm.publication_year.$error.minlength || myForm.publication_year.$error.maxlength || myForm.academic_year.$invalid || !published_or_presented || fileInvalid" value="Submit">
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
    
    $scope.ISSN="<?php echo (old('ISSN')!=''? old('ISSN'):$activity['ISSN']); ?>";
    $scope.ISBN="<?php echo (old('ISBN')!=''? old('ISBN'):$activity['ISBN']); ?>";
    $scope.DOI_number="<?php echo (old('DOI_number')!=''? old('DOI_number'):$activity['DOI_number']); ?>";
    $scope.paper_title="<?php echo (old('paper_title')!=''? old('paper_title'):$activity['paper_title']); ?>";
    
    $scope.authors_detail="<?php echo (old('authors_detail')!=''? old('authors_detail'):$activity['authors_detail']); ?>";

    $scope.title_of_contribution="<?php echo (old('title_of_contribution')!=''? old('title_of_contribution'):$activity['title_of_contribution']); ?>";
    $scope.conference_name="<?php echo (old('conference_name')!=''? old('conference_name'):$activity['conference_name']); ?>";
    $scope.journal_name="<?php echo (old('journal_name')!=''? old('journal_name'):$activity['journal_name']); ?>";
    $scope.paper_type="<?php echo (old('paper_type')!=''? old('paper_type'):$activity['paper_type']); ?>";
    $scope.published_or_presented="<?php echo (old('published_or_presented')!=''? old('published_or_presented'):$activity['published_or_presented']); ?>";
    $scope.volume_and_issue="<?php echo (old('volume_and_issue')!=''? old('volume_and_issue'):$activity['volume_and_issue']); ?>";
    $scope.page_num="<?php echo (old('page_num')!=''? old('page_num'):$activity['page_num']); ?>";
    $scope.impact_factor="<?php echo (old('impact_factor')!=''? old('impact_factor'):$activity['impact_factor']); ?>";
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