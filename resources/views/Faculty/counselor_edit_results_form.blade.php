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
    <li><a href="{{url('faculty/counselor/manage/results')}}"><span style="font-size:17px;">Students Results</span></a></li>
    <li class="active"><a href="#"><b><span style="font-size:17px;">Edit Result</span></b></a></li>
    
</ul>

<div class="row" ng-app="myApp" ng-controller="myCtrl">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <!-- edit form column -->
    <div class="col-md-7 personal-info">
    <br/>

    <div class="form-horizontal">
      <form name="myForm" id="myForm" method="POST" enctype="multipart/form-data" action="{{url('faculty/counselor/edit/result')}}">
      
      <input type="hidden" id="token" name="_token" value="{{Session('_token')}}">

        <div class="form-group">
            <label class="col-md-3 control-label">Select Student:</label>
            <div class="col-md-8">
              <select name="student_id" ng-model="student_id" class="form-control"required autofocus id="student_id">
                @foreach($results_student_ids as $student_id)
                <option value="{{$student_id['student_id']}}">{{$student_id['student_id']}}</option>
                @endforeach
              </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Semester:</label>
            <div class="col-md-8">
              <select name="semester" id="semester" ng-model="semester" class="form-control" required autofocus>
                <option value="sem1">Semester 1</option>
                <option value="sem2">Semester 2</option>
                <option value="sem3">Semester 3</option>
                <option value="sem4">Semester 4</option>
                <option value="sem5">Semester 5</option>
                <option value="sem6">Semester 6</option>
                <option value="sem7">Semester 7</option>
                <option value="sem8">Semester 8</option>
              </select>

            </div>
        </div>
        
        <div id="dynamic_results">
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
            <button type="button" class="btn btn-primary" id="fetch_result">Fetch Result</button>
            <span></span>
            </div>
        </div>


        @if(session()->has('success_message'))
        <div class="form-group">
          <div class="col-md-3"></div>
          <div class="col-md-8">
            <div class="alert alert-success alert-dismissible\">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
              </a>
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

$(document).ready(function(){        
      $('#fetch_result').click(function(){
          student_id = $('#student_id').val();
          semester = $('#semester').val();
          token = $('#token').val();
          $('#fetch_result').hide();
          $('#student_id').prop('disabled','disabled');
          $('#semester').prop('disabled','disabled');
          $.ajax({
              type:'POST',
              data:{student_id:student_id,semester:semester,_token:token},
              url:"{{url('faculty/counselor/fetch/results')}}",
              success:function($data)
              {
                  $('#dynamic_results').html($data);
              }
          }); 
      });

var app = angular.module('myApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

app.controller('myCtrl', function($scope) {


});

});
  
</script>
<script type="text/javascript">
//do not write directly $(#submit_form).click(function(){}); bcz '#submit_form' is loaded as ajax response. So we need to bind event afterwards. 
$('body').on('click','#submit_form',function(){
          $('#student_id').prop('disabled',false);
          $('#semester').prop('disabled',false);
          $('#myForm').submit();
      });
</script>
@endsection