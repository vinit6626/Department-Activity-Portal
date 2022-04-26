@extends('layouts.faculty_dash_layout')

@section('customStyle')

<link rel="stylesheet" type="text/css" href="{{asset('css\buttons.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css\dataTables.bootstrap.min.css')}}">
<style>
  .modal-header, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }
  @media screen and (min-width: 768px) {
    .custom-class {
        width: 1100px; /* either % (e.g. 60%) or px (400px) */
    }
  }
</style>
@endsection

@section('content')
<div class="row" style="vertical-align:middle;">
  <center><h3>Generate Personal Reports</h3></center>
  <hr style="margin-top:5px;">
</div>

<div ng-app="myApp" ng-controller="myCtrl">

    <!-- edit form column -->
    <div class="personal-info">

    <div class="form-horizontal">
      <form name="myForm" id="myForm" method="post" action="{{url('faculty/personal/all/reports/downloadAllExcel')}}">
      
      <input type="hidden" id="token" name="_token" value="{{Session('_token')}}">

      <div class="row row1">      
        
        <div class="activity">
          <div class="form-group col-md-3" style="margin-left: 5px;">
            <label class=" control-label">Select Activity:</label>
            <select id="activity" ng-model="activity" name="activity" class="form-control{{ $errors->has('activity') ? ' is-invalid' : '' }}" required autofocus>
              <option value="all" selected>All</option>
              <option value="Faculty_Attended">Activities Attended</option>
              <option value="Faculty_Organized">Activities Organized</option>
              <option value="Faculty_Training_Internship">Training/Internship</option>
              <option value="Faculty_Published_Paper">Published Papers</option>
              <option value="Faculty_Published_Book">Published Books</option>
              <option value="Faculty_r_and_d">Research and Development</option>
              <option value="Faculty_Other_Services">Service inside/outside institute
              </option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-3 type" style="margin-left: 5px;">
          <label class=" control-label">Select type:</label>
            <select id="type" ng-model="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" autofocus>
              <option value="all" selected><center>All</center></option>
              <option value="Seminar">Seminar</option>
              <option value="Workshop">Workshop</option>
              <option value="Expert Talk">Expert Talk</option>
              <option value="STTP">STTP</option>
              <option value="Conference">Conference</option>
              <option value="Industrial Visit">Industrial Visit</option>
            </select>
        </div>

        <div class="from_to_date">
            <div class="form-group col-md-3" style="margin-left: 5px;">
              <label class="control-label">From Date:</label>
                <input name="from_date" id="from_date" value="{{old('from_date')}}" ng-model="from_date" class="form-control" ng-change="check_enddate(from_date,to_date)" type="date" ng-disabled="month_and_year || (from_year || to_year) || academic_year" autofocus/>
            </div>

            <div class="form-group col-md-3" style="margin-left: 5px;">
              <label class=" control-label">To Date:</label>
                <input name="to_date" ng-model="to_date" id="to_date" value="{{old('to_date')}}" class="form-control" type="date" ng-change="check_enddate(from_date,to_date)" ng-disabled="month_and_year || (from_year || to_year) || academic_year" autofocus/>

                <span style="color:red">
                  <b><span ng-bind="err_enddate"></span></b>
                </span>
            </div>

        </div>
      
      </div>
      <!-- end class="row" -->

      <div class="row row2">
        <div class="form-group col-md-3" style="margin-left: 5px;">
          <label class="control-label">Academic Year:</label>

            <input name="academic_year" id="academic_year" ng-model="academic_year" class="form-control" type="text" placeholder="Academic year(e.g. 2014-2015)" ng-pattern="/^[0-9]{4}[-][0-9]{4}$/" ng-disabled="month_and_year || (from_date && to_date) || (from_year || to_year)" autofocus/>
            <span style="color:red;" ng-show="myForm.academic_year.$dirty && myForm.academic_year.$invalid">
                <span ng-show="myForm.academic_year.$error.required"><strong>Please enter academic year </strong>
                </span>
                <span ng-show="myForm.academic_year.$error.pattern"><strong>Please enter academic year in proper format(e.g. 2014-2015)</strong>
                </span>
            </span>
        </div>

        <div class="form-group col-md-3" style="margin-left: 5px;">
          <label class="control-label">Academic Semester:</label>
              <div class="" style="padding-top:7px;">
              <input type="radio" name="academic_semester" ng-model="academic_semester" ng-disabled="month_and_year" value="odd">Odd
              &nbsp; &nbsp; &nbsp;
              <input type="radio" name="academic_semester" ng-model="academic_semester" ng-disabled="month_and_year" value="even">Even
              </div>
        </div>

        <div class="form-group col-md-3" style="margin-left: 5px;">
        <label class="control-label">Month & Year:</label>
          <input name="month_and_year" id="month_and_year" data-ng-model="month_and_year" class="form-control" type="month" ng-disabled="(from_date && to_date) || (from_year || to_year) || academic_year" value="<?php echo old('month_and_year'); ?>" autofocus/>

          </span>
        </div>

        <div class="form-group col-md-3" style="margin-left: 5px;">
          <label class="control-label">Year:</label>
          <input name="year" data-ng-model="year" id="year" class="form-control" type="number" placeholder="Year in 4 digits(e.g. 2020)" value="<?php echo old('year'); ?>" ng-minlength="4" ng-maxlength="4" ng-disabled="month_and_year || (from_date && to_date) || (from_year || to_year) || academic_year" autofocus/>
          <span style="color:red;" ng-show="myForm.year.$dirty && myForm.year.$invalid">
              <span ng-show="myForm.year.$error.minlength || myForm.year.$error.maxlength"><strong>Please enter year in 4 digits(e.g. 2015)</strong>
              </span>
          </span>
        </div>

      </div>
      <!-- end class="row" -->
      
      <div class="row">
        <div class="from_to_year">
            <div class="form-group col-md-3" style="margin-left: 5px;">
              <label class="control-label">From Year:</label>
                <input name="from_year" id="from_year" value="{{old('from_year')}}" ng-model="from_year" class="form-control" placeholder="Year in 4 digits(e.g. 2020)" ng-change="check_endyear(from_year,to_year)" ng-minlength="4" ng-maxlength="4" type="number" ng-disabled="month_and_year || (from_date && to_date) || academic_year" autofocus/>
                <span style="color:red;" ng-show="myForm.from_year.$dirty && myForm.from_year.$invalid">
                  <span ng-show="myForm.from_year.$error.minlength || myForm.from_year.$error.maxlength"><strong>Please enter year in 4 digits(e.g. 2015)</strong>
                  </span>
                </span>
          </span>
            </div>

            <div class="form-group col-md-3" style="margin-left: 5px;">
              <label class=" control-label">To Year:</label>
                <input name="to_year" id="to_year" ng-model="to_year" value="{{old('to_year')}}" class="form-control" placeholder="Year in 4 digits(e.g. 2020)" ng-minlength="4" ng-maxlength="4" type="number" ng-change="check_endyear(from_year,to_year)" ng-disabled="month_and_year || (from_date && to_date) || academic_year" autofocus/>
                <span style="color:red;" ng-show="myForm.to_year.$dirty && myForm.to_year.$invalid">
                  <span ng-show="myForm.to_year.$error.minlength || myForm.to_year.$error.maxlength"><strong>Please enter year in 4 digits(e.g. 2015)</strong>
                  </span>
                </span>
                <span style="color:red">
                  <b><span ng-bind="err_endyear"></span></b>
                </span>
            </div>

        </div>
      </div>
      <!-- end class="row" -->
      <br/>
      <div class="form-group col-md-3">
        <label class=" control-label"></label>
        
          <button type="button" id="generate" class="btn btn-primary" ng-disabled=" myForm.activity.$invalid || myForm.type.$invalid || myForm.from_date.$invalid || myForm.to_date.$invalid || check_enddate(from_date, to_date) || myForm.from_year.$invalid || myForm.to_year.$invalid || check_endyear(from_year, to_year) || myForm.academic_year.$invalid || myForm.academic_semester.$invalid " >Generate
          </button>

      </div>

      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog custom-class">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="padding:5px 50px;">
              <button type="button" class="close" data-dismiss="modal" style="margin-top:10px;">&times;</button>
              <h3><span class="glyphicon glyphicon-lock"></span> Report</h3>
            </div>
            <div class="modal-body" id="result" style="padding:20px 50px;">
              
            </div>
            <div class="modal-footer">
              <span id="AllExcel" style="margin-right: 5px;"></span>

              <button type="submit" class="btn btn-danger btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

            </div>
          </div>
          
        </div>
      </div>
      <!-- End Modal --> 

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

<script type="text/javascript" src="{{asset('js\jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\dataTables.bootstrap.min.js')}}
"></script>
<script type="text/javascript" src="{{asset('js\dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\buttons.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('js\buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js\buttons.colVis.min.js')}}"></script>






<script type="text/javascript">
$(document).ready(function(){
  $('.type').hide();

  $("#generate").click(function(){
      //$("#myForm").submit();

      //Here problem is that jQuery fetches entered data of input box even if input box is disabled. So we have externally checked that if it is disabled then we make variable value null, otherwise enetered value.

      var isActivityDisabled = $('#activity').prop('disabled');
      if(isActivityDisabled==true){activity='';}
      else{activity = $('#activity').val();}

      var isTypeDisabled = $('#type').prop('disabled');
      if(isTypeDisabled==true){type='';}
      else{type = $('#type').val();}

      var isFromDateDisabled = $('#from_date').prop('disabled');
      if(isFromDateDisabled==true){from_date='';}
      else{from_date = $('#from_date').val();}

      var isToDateDisabled = $('#to_date').prop('disabled');
      if(isToDateDisabled==true){to_date='';}
      else{to_date = $('#to_date').val();}

      var isAcademicYearDisabled = $('#academic_year').prop('disabled');
      if(isAcademicYearDisabled==true){academic_year='';}
      else{academic_year = $('#academic_year').val();}

      var isAcademicSemDisabled = $('#academic_semester').prop('disabled');
      if(isAcademicSemDisabled==true){academic_semester='';}
      else{academic_semester =($("input:radio[name=academic_semester]").filter(":checked").val())||'';}

      var isMonthYearDisabled = $('#month_and_year').prop('disabled');
      if(isMonthYearDisabled==true){month_and_year='';}
      else{month_and_year = $('#month_and_year').val();}

      var isYearDisabled = $('#year').prop('disabled');
      if(isYearDisabled==true){year='';}
      else{year = $('#year').val();}

      var isFromYearDisabled = $('#from_year').prop('disabled');
      if(isFromYearDisabled==true){from_year='';}
      else{from_year = $('#from_year').val();}

      var isToYearDisabled = $('#to_year').prop('disabled');
      if(isToYearDisabled==true){to_year='';}
      else{to_year = $('#to_year').val();}

      //alert(to_year);
      
      
      token = $('#token').val();
      
      $.ajax({
        type:'POST',
        data:{activity:activity,type:type,from_date:from_date,to_date:to_date,academic_year:academic_year,academic_semester:academic_semester,month_and_year:month_and_year,year:year,from_year:from_year,to_year:to_year,_token:token},
        url:"{{url('faculty/generate/personal/reports')}}",
        success:function($data)
        {
            $('#result').html($data);
            if(activity=="all")
            {
              $('#AllExcel').html("<input class=\"btn btn-primary\" type=\"submit\" id=\"downloadAllExcel\" value=\"Export all to Excel\">");
            }
            else
            {
              $('#downloadAllExcel').remove();
            }
            $("#myModal").modal();
        }
      });
  });



  $('#activity').change(function(){
    var activity=$(this).val();
    /*
    if(activity=='published_papers' || activity=='published_books')
    {
        $('.from_to_date').remove();
    }
    else
    {
        $('.from_to_date').remove();
        $('.row1').append('<div class="from_to_date"><div class="form-group col-md-3" style="margin-left: 5px;"><label class="control-label">From Date:</label><input name="from_date" value="{{old('from_date')}}" ng-model="from_date" class="form-control" type="date" autofocus/></div><div class="form-group col-md-3" style="margin-left: 5px;">              <label class=" control-label">To Date:</label>                <input name="to_date" ng-model="to_date" value="{{old('to_date')}}" class="form-control" type="date" ng-change="check_enddate(from_date,to_date)" autofocus/><span style="color:red">                  <b><span ng-bind="err_enddate"></span></b>                </span>            </div></div>');
    }
    */
    if(activity=='Faculty_Attended' || activity=='Faculty_Organized')
    {
      $('.type').show();
      /*$('.activity').append('<div class="form-group col-md-3 type" style="margin-left:5px;"><label class=" control-label">Select type:</label>  <select id="type" ng-model="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" autofocus><option value="" selected><center>All</center></option><option value="Seminar">Seminar</option><option value="Workshop">Workshop</option><option value="Expert Talk">Expert Talk</option><option value="STTP">STTP</option><option value="Conference">Conference</option><option value="Industrial Visit">Industrial Visit</option></select></div>');*/
    }
    else
    {
      $('#type').val('all');
      $('.type').hide();
    }

  });

  



});





var app = angular.module('myApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

app.controller('myCtrl', function($scope) {

    <?php if(old('activity')=='') { ?>
    $scope.activity="all";
    <?php } else { ?>
    $scope.activity="<?php echo old('activity'); ?>";
    <?php } ?>
    
    <?php if(old('type')=='') { ?>
    $scope.type="all";
    <?php } else { ?>
    $scope.type="<?php echo old('activity'); ?>";
    <?php } ?>

    $scope.from_date="<?php echo old('from_date'); ?>";
    $scope.to_date="<?php echo old('to_date'); ?>";
    $scope.academic_year="<?php echo old('academic_year');?>";
    $scope.academic_semester="";

    $scope.check_enddate = function(from_date,to_date) {
      $scope.err_enddate = '';
      if(to_date==null)
      {
        return false;
      }
      else if(new Date(from_date) > new Date(to_date)){
        $scope.err_enddate = 'Ending date should be greater than starting date';
        return true;
      }
    };

    $scope.check_endyear = function(from_year,to_year) {
      $scope.err_endyear = '';
      if(to_year==null)
      {
        return false;
      }
      else if(new Date(from_year) > new Date(to_year)){
        $scope.err_endyear = '"To year" should be greater than "From Year"';
        return true;
      }
    };


});
  
</script>



@endsection

