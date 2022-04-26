@extends('layouts.admin_dash_layout')

@section('customStyle')
<style type="text/css">
          .form-group input[type="checkbox"] {
              display: none;
          }

          .form-group input[type="checkbox"] + .btn-group > label span {
              width: 20px;
          }

          .form-group input[type="checkbox"] + .btn-group > label span:first-child {
              display: none;
          }
          .form-group input[type="checkbox"] + .btn-group > label span:last-child {
              display: inline-block;   
          }

          .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
              display: inline-block;
          }
          .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
              disp
</style>

@endsection
@section('content')
<div class="row" style="vertical-align:middle;">
  <center><h3>Add New Counselor</h3></center>
  <hr style="margin-top:5px;">
</div>

@if(session()->has('success_message'))
<div class="row">
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{session('success_message')}}
</div>
</div>
@endif

<form action="{{url('/admin/create/counselor')}}" id="myForm" method="POST">
    
<!--     <input type="hidden" name="_token" value="{{Session('_token')}}" > -->
    {{csrf_field()}}
<div class="row">
    <div class="col-md-2"></div>
    
    <div class="col-md-8">
    <br/>
    <div class="form-horizontal">
     
      <div class="form-group">
        <label class="col-lg-3 control-label">Select Faculty:</label>
        <div class="col-lg-8">
          <select name="faculty_id" id="faculty_id" class="form-control">
            <option value="">-----Select-----</option>
            @foreach($non_counselors as $faculty)
            <option value="{{$faculty['faculty_id']}}">{{$faculty['name']}}</option>
            @endforeach
          </select>
          <strong>
          <span style="color:red;" id="error_faculty_id">
              @if($errors->has('faculty_id'))
              {{$errors->first('faculty_id')}}
              @endif
          </span>
          </strong>
        </div>
      </div>
       
      <div class="form-group">
        <label class="col-md-3 control-label">Students:</label>
        <div class="col-md-8">
          <select class="form-control" name="year_of_students" id="year_of_students">
            <option value="">-----Select-----</option>
            <option value="1">First Year Students</option>
            <option value="2">Second Year Students</option>
            <option value="3">Third Year Students</option>
            <option value="4">Fourth Year Students</option>
          </select>
          <strong>
          <span style="color:red;" id="error_year">
              @if($errors->has('year_of_students'))
              {{$errors->first('year_of_students')}}
              @endif
          </span>
          </strong>
        </div>
      </div>

      
      <div class="form-group" id="add_students">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8">
          <button type="button" class="btn btn-primary" id="add_students">Add Students</button>
          <span></span>
        </div>
      </div>


      <!-- all_students div starts-->
      <div id="all_students">
      
      </div>
      <!-- all_students div ends-->
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-8">
          <strong><span id="all_students_errors" style="color:red;"></span></strong>
        </div>
      </div>
      

      <div class="form-group" id="submit_div" style="margin-top:10px;">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-8" style="text-align:center;">
          <button type="button" class="btn btn-primary" id="submit">Submit</button>
          <span></span>
        </div>
      </div>

      <input type="submit" name="finalsubmit" id="finalsubmit">

    </div>
    </div>
</div>
</form>

@endsection

@section('customJS')
<script type="text/javascript">
  
$(document).ready(function() {

  $('#all_students').hide();
  $('#submit_div').hide();
  $('#finalsubmit').hide();
  //var students_available=1;
  function validate2fields()
  {
    var faculty_id=$('#faculty_id').val();
    var year_of_students=$('#year_of_students').val();
    if(faculty_id=='' || year_of_students=='')
    {
      if(faculty_id=='')
      {
        $('#error_faculty_id').html('Please select faculty');
        $('#all_students_errors').html('');

      }
      else{
        $('#error_faculty_id').html('');
      }
    
      if(year_of_students=='')
      {
        $('#error_year').html('Please select year of students');
        $('#all_students_errors').html('');

      }
      else
      {
         $('#error_year').html('');
      }

      return false;
    }
    else{
      $('#error_faculty_id').html('');
      $('#error_year').html('');    
      return true;
    }
  }
  
  $('#add_students').on('click',function(){
  
    var first2fields=validate2fields();
    if(first2fields==false)
    {
      return;
    }
    else
    {
      
      var year_of_students=$('#year_of_students').val();
      var token=$('input[name="_token"]').val();
      $.ajax({
        type:'POST',
        url:"{{url('admin/create/counselor/getstudents')}}",
        data:{student_year:year_of_students,_token:token},
        success:function(data){
          
          if(data=='')
          {
            //students_available=0;
            $('#all_students_errors').html('All registered students are assigned with counselors');
            $('#all_students').hide();  
            $('#add_students').show();
            $('#submit_div').hide();
          }
          else
          {
            //students_available=1;
            $('#all_students_errors').html('');
            jQuery.each(data, function(index, value) {
            $('#all_students').append('<div class="form-group"><div class="col-md-3"></div><div class="col-md-3"><input type="checkbox" value="'+value+'" name="student[]" id="'+value+'" autocomplete="off" /><div class="btn-group"><label for="'+value+'" class="btn btn-primary" style="width:45px;"><span class="glyphicon glyphicon-ok"></span><span></span></label><label for="'+value+'" style="background-color:white;" class="btn btn-default active" style="width:90px;">'+value+'</label></div></div></div>');
            });


            //disabled values are not passsed in form submission. So just before submitting for we will enable it.
            $('#year_of_students').attr('disabled',true);
            $('#faculty_id').attr('disabled',true);


            $('#all_students').show();  
            $('#add_students').hide();
            $('#submit_div').show(); 
          }

        },
      });

    }
  });

  
  $('#submit').click(function(){
    var validated=1;
    var first2fields=validate2fields();
    if(first2fields==false)
    {
      validated=0;
    }
    student_ids=[];
    $("input[name='student[]']:checked").each(function(){
      student_ids.push($(this).val());
    });

    if(student_ids=='')
    {
      validated=0;
      $('#all_students_errors').html('Please select students id');
    }
    else
    {
      $('#all_students_errors').html('');
    }

    if(validated==0)
    {
      return;
    }
    else
    {
      //disabled values are not passsed in form submission. So just before submitting for we have enabled it.
      $('#year_of_students').attr('disabled',false);
      $('#faculty_id').attr('disabled',false);

      document.getElementById("finalsubmit").click();
    }

  });

});
</script>
@endsection