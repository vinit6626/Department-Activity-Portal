@extends('layouts.student_dash_layout')

@section('content')
<div class="row" style="vertical-align:middle;">
  <center><h3>New Organized Activity</h3></center>
  <hr style="margin-top:5px;">
</div>

<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>
    
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

    <div class="form-horizontal">
      <form name="myForm" id="myForm" method="POST" enctype="multipart/form-data" action="{{url('student/organized/activitydata')}}">
      {{csrf_field()}}
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
        <div class="col-md-8 select_role">
          <select name="role" id="role" ng-model="role" class="form-control" required>
            <option value="">----Select----</option>
            <option value="Coordinator">Coordinator</option>
            <option value="Presenter">Presenter</option>
            <option value="Event Manager">Event Manager</option>
            <option value="Other">Other</option>

          </select>
          <!-- <input name="role" ng-model="role" class="form-control" type="text" required autofocus/>
 -->
          <span style="color:red;" ng-show="myForm.role.$dirty && myForm.role.$invalid">
              <span ng-show="myForm.role.$error.required"><strong>Please select role</strong>
              </span>
          </span>

  
          @if($errors->has('role'))
          <span style="color:red;">
            <strong>{{$errors->first('role')}}</strong>
          </span>
          @endif

          @if(session()->has('error_role'))
            <span style="color:red;" id="error_role">
            <strong>{{session('error_role')}}</strong>
            </span>
          @endif

        </div>
        <br/>
        
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
          <input name="total_no_of_students" ng-model="total_no_of_students" class="form-control" type="number" min="1" required autofocus/>
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
          <input name="from_date" value="{{old('from_date')}}" ng-model="from_date" class="form-control" type="date" ng-change="check_startdate(from_date)" required autofocus/>

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
          <input name="to_date" ng-model="to_date" value="{{old('to_date')}}" class="form-control" type="date" ng-change="check_enddate(from_date,to_date)" required autofocus/>
          
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
          <input type="file" name="proof_file" ng-model="proof_file" onchange="angular.element(this).scope().setFile(this);" class="form-control" required autofocus/>

          <span style="color:red;" ng-show="myForm.proof_file.$dirty && myForm.proof_file.$invalid">
              <span ng-show="myForm.proof_file.$error.required">
                <strong>Please upload certificate file</strong>
              </span>
          </span>

          <span style="color:red">
            <b><span ng-bind="FileMessage"></span></b>
          </span>

          @if($errors->has('proof_file'))
          <span style="color:red;">
            <strong>{{$errors->first('proof_file')}}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <button type="button" id="submitform" class="btn btn-primary" ng-disabled="myForm.type.$invalid || myForm.title_of_activity.$invalid || myForm.place.$invalid || myForm.role.$invalid || myForm.convener.$invalid || myForm.resource_Person_or_Industry.$invalid || myForm.total_no_of_students.$invalid|| myForm.from_date.$invalid || myForm.to_date.$invalid || check_startdate(from_date) || check_enddate(from_date, to_date) || myForm.academic_year.$invalid || myForm.academic_semester.$invalid || fileInvalid">Submit</button>
          <span></span>
        </div>
      </div>

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


$('#submitform').click(function(){
  $('#role').attr('disabled',false); 
  $('#no_of_coordinators').attr('disabled',false);  
  $("#myForm").submit();
});

$('#role').change(function(){
  $('#other_role').remove();
  $('#error_role').html('');
  var role=$('#role').val();
  if(role=='Other')
  {
    $('.select_role').append('<input name="role" id="other_role" ng-model="role" class="form-control" type="text" placeholder="Please mention role " required autofocus/>');
    $('#role').prop('disabled','disabled'); 
  }

  if(role=='Coordinator')
  {
    $('.select_role').append('<input name="no_of_coordinators" id="no_of_coordinators" ng-model="no_of_coordinators" class="form-control" type="number" placeholder="How many other coordinators?" min="1" required autofocus/><button type="button" class="btn btn-sm btn-warning" id="submit_no_of_coordinators" >Fetch Students</button><span style="color:red;" id="error_no_of_coordinators"></span>');
    $('#role').prop('disabled','disabled'); 
  }
});

$(document).on('click','#submit_no_of_coordinators',function(){

  var no_of_coordinators=$('#no_of_coordinators').val();
  if(no_of_coordinators<=0)
  {
    document.getElementById('error_no_of_coordinators').innerHTML="<b>No. of coordinators should be more than 0</b>";
    return false;
  }
  else{
    document.getElementById('error_no_of_coordinators').innerHTML="";
  }

  $('#no_of_coordinators').prop('disabled','disabled')
  $('#submit_no_of_coordinators').hide();
  var token=$('input[name="_token"]').val();
      
  $.ajax({
    type:'POST',
    data:{no_of_coordinators:no_of_coordinators,_token:token},
    url:"{{url('student/organized/fetch/other_students')}}",
    success:function($data)
    {
      $('.select_role').append($data);
      $('.select_role').append('<span style="color:red;" id="error_coordinators"></span>');
    }
  });

});


$(document).on('change','.other_coordinators_group',function(){
  var coordinators_nodelist = document.getElementsByName('other_coordinators[]');
  var allselected=true;
  for(var i=0;i<coordinators_nodelist.length;++i)
  {
    if(coordinators_nodelist[i].value=='')
    {
      allselected=false; 
    }
  }

  if(allselected==false)
  {
    document.getElementById('error_coordinators').innerHTML='<b>Please select all Coordinators</b>';
    return false;
  }
  else
  {
    document.getElementById('error_coordinators').innerHTML='';
  }
  
  var coordinators_arr=[];
  var coordinator_repeat=false;
  for(var i=0;i<coordinators_nodelist.length;++i)
  {
    if(jQuery.inArray(coordinators_nodelist[i].value,coordinators_arr)!=-1)
    {
      coordinator_repeat=true;
    }
    coordinators_arr.push(coordinators_nodelist[i].value);
  }

  if(coordinator_repeat==true)
  {
    document.getElementById('error_coordinators').innerHTML='<b>Coordinators should not repeat</b>';
    return false;
  }
  else
  {
    document.getElementById('error_coordinators').innerHTML='';
  }

});


app.controller('myCtrl', function($scope) {

    $scope.type="<?php echo old('type'); ?>";
    $scope.title_of_activity="<?php echo old('title_of_activity'); ?>";
    $scope.place="<?php echo old('place'); ?>";
    $scope.convener="<?php echo old('convener'); ?>";
    $scope.resource_Person_or_Industry="<?php echo old('resource_Person_or_Industry'); ?>";
    $scope.total_no_of_students="<?php echo old('total_no_of_students'); ?>";

    $scope.from_date="<?php echo old('from_date'); ?>";
    $scope.to_date="<?php echo old('to_date'); ?>";
    $scope.academic_year="<?php echo old('academic_year');?>";
    $scope.academic_semester="<?php echo old('academic_semester');?>";

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

    $scope.fileInvalid=true;
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