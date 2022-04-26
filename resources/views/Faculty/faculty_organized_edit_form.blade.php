@extends('layouts.faculty_dash_layout')

@section('content')
<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li><a href="{{url('faculty/show/organized/activities')}}"><b><span style="font-size:17px;">Activities Organized</span></b></a></li>
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
      <form name="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/edit/organized/activity/'.$activity['sr_no'])}}">
      @csrf
      <div class="form-group">
          <label class="col-md-3 control-label">Activity Type:</label>

          <div class="col-md-8">
              <select id="type" ng-model="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"  required autofocus>
                  <option value=""><center>----Select----</center></option>
                  <option value="Seminar">Seminar</option>
                  <option value="Workshop">Workshop</option>
                  <option value="Expert Talk">Expert Talk</option>
                  <option value="STTP">STTP</option>
                  <option value="Conference">Conference</option>
                  <option value="Industrial Visit">Industrial Visit</option>
              </select>
              
              <span style="color:red;" ng-show="myForm.type.$dirty && myForm.type.$invalid">
              <span ng-show="myForm.type.$error.required"><strong>Please select type</strong>  
              </span>
              
              </span>

              @if($errors->has('type'))
                <span style="color:red;">
                  <strong>{{$errors->first('type')}}</strong>
                </span>
              @endif
              
          </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Title of activity:</label>
        <div class="col-md-8">
          <input name="title_of_activity" ng-model="title_of_activity" class="form-control" type="text"required autofocus/>

          <span style="color:red;" ng-show="myForm.title_of_activity.$dirty && myForm.title_of_activity.$invalid">
              <span ng-show="myForm.title_of_activity.$error.required"><strong>Please enter title of activity</strong>  
              </span>
          </span>
          @if($errors->has('title_of_activity'))
          <span style="color:red;">
            <strong>{{$errors->first('title_of_activity')}}</strong>
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
        <label class="col-md-3 control-label">Convener:</label>
        <div class="col-md-8">
          <input name="convener" ng-model="convener" class="form-control" type="text"required autofocus/>
          <span style="color:red;" ng-show="myForm.convener.$dirty && myForm.convener.$invalid">
              <span ng-show="myForm.convener.$error.required"><strong>Please enter convener</strong>
          </span>
          @if($errors->has('convener'))
          <span style="color:red;">
            <strong>{{$errors->first('convener')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Role:</label>
        <div class="col-md-8">

          @if(isset($activity['role']))
            @if(isset($activity['role'])=='coordinator')
            <div class="row">
            <div class="col-md-11">
            <select name="role" id="role" ng-model="role" class="form-control" disabled="disabled" required>
            <option value="">----Select----</option>
            <option value="Coordinator" selected>Coordinator</option>
            <option value="Presenter">Presenter</option>
            <option value="Event Manager">Event Manager</option>
            <option value="Other">Other</option>
            </select>
            </div>
            
            <div class="col-md-1">
              <button type="buttton" id="change" class="btn btn-sm btn-warning">Change</button>                
            </div>
            
            </div>

            <div class="coordinators">
              <?php $coordinators=explode(',',$activity['coordinators']);?>
              <b>Coordinators</b>
              @foreach($coordinators as $coordinator)
                <div>

                  <select class="form-control" disabled="disabled">
                    <option>{{$coordinator}}</option>
                  </select>
                </div>
              @endforeach

            </div>

            @endif
          @endif


          <span style="color:red;" ng-show="myForm.role.$dirty && myForm.role.$invalid">
              <span ng-show="myForm.role.$error.required"><strong>Please select role</strong>  
              </span>
          </span>
          @if($errors->has('role'))
          <span style="color:red;">
            <strong>{{$errors->first('role')}}</strong>
          </span>
          @endif
        </div>
      </div>


            <div class="form-group">
        <label class="col-md-3 control-label">Resource Person/Industry:</label>
        <div class="col-md-8">
          <input name="resource_Person_or_Industry" ng-model="resource_Person_or_Industry" class="form-control" type="text"required autofocus/>
          <span style="color:red;" ng-show="myForm.resource_Person_or_Industry.$dirty && myForm.resource_Person_or_Industry.$invalid">
              <span ng-show="myForm.resource_Person_or_Industry.$error.required"><strong>Please enter resource_Person_or_Industry</strong>
          </span>
          @if($errors->has('resource_Person_or_Industry'))
          <span style="color:red;">
            <strong>{{$errors->first('resource_Person_or_Industry')}}</strong>
          </span>
          @endif
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Total no. of students:</label>
        <div class="col-md-8">
          <input name="total_no_of_students" ng-model="total_no_of_students" class="form-control" type="number" value="<?php echo (old('total_no_of_students')!=''? old('total_no_of_students'):$activity['total_no_of_students']); ?>" min="1" required autofocus/>
          <span style="color:red;" ng-show="myForm.total_no_of_students.$dirty && myForm.total_no_of_students.$invalid">
              <span ng-show="myForm.total_no_of_students.$error.required"><strong>Please enter total_no_of_students</strong>
          </span>
          @if($errors->has('total_no_of_students'))
          <span style="color:red;">
            <strong>{{$errors->first('total_no_of_students')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">From Date:</label>
        <div class="col-md-8">
          <input name="from_date" value="{{old('from_date')!=''? old('from_date'):$activity['from_date']}}" ng-model="from_date" class="form-control" ng-model="from_date" class="form-control" type="date" ng-change="check_startdate(from_date)" required autofocus/>

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
          <input type="submit" class="btn btn-primary" ng-disabled="myForm.type.$invalid || myForm.title_of_activity.$invalid || myForm.place.$invalid || myForm.role.$invalid || myForm.convener.$invalid || myForm.resource_Person_or_Industry.$invalid || myForm.total_no_of_students.$invalid || myForm.from_date.$invalid || myForm.to_date.$invalid || check_startdate(from_date) || check_enddate(from_date, to_date) || myForm.academic_year.$invalid || myForm.academic_semester.$invalid || fileInvalid" value="Submit">
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

    $scope.type="<?php echo (old('type')!=''? old('type'):$activity['type']); ?>";
    $scope.title_of_activity="<?php echo (old('title_of_activity')!=''? old('title_of_activity'):$activity['title_of_activity']); ?>";
    $scope.convener="<?php echo (old('convener')!=''? old('convener'):$activity['convener']); ?>";
    $scope.resource_Person_or_Industry="<?php echo (old('resource_Person_or_Industry')!=''? old('resource_Person_or_Industry'):$activity['resource_person_or_industry']); ?>";

    $scope.total_no_of_students="<?php echo (old('total_no_of_students')!=''? old('total_no_of_students'):$activity['total_no_of_students']); ?>";


    $scope.role="<?php echo (old('role')!=''? old('role'):$activity['role']); ?>";
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