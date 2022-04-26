@extends('layouts.faculty_dash_layout')
@section('customStyle')
    <style type="text/css">
        .myTextDisplayBox{
            padding:7px;word-wrap: break-word;height:100%;border:1px solid rgb(204, 204, 204);
            border-radius:4px;
            box-sizing:border-box;
        }
    </style>
@endsection


@section('content')

<div class="row" style="vertical-align:middle;">
  <span style="font-size: 27px;">Notifications</span>
  <hr style="margin-top:5px;">
</div>

@if(count($notifications)==0)
<br/>
<div class="row bg-success" style="height: 35px;border-radius: 25px;">
    <div class="text-center" style="">
        <p style="font-size: 20px;"><b>No new notifications.</b></p>
    </div>
</div>
<br/><br/>
@else

    <form name="myForm">
      
    <input type="hidden" id="token" name="_token" value="{{Session('_token')}}">
    
    @foreach($notifications as $notification)
    <div class="panel panel-success">
        <div class="panel-heading">

            <span>{{$notification['name']}} has inserted an organized {{$notification['type']}} details</span>
            <span style="float: right;"><span class="glyphicon glyphicon-time"></span> {{$notification['created_at']}}</span>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Type</th>
                        <th>Title of activity</th>
                        <th>Role</th>
                        <th>Coordinators</th>
                        <th>Place</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Academic year</th>
                        <th>Academic semester</th>
                        <th>File</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification['type']}}</td>
                            <td>{{$notification['title_of_activity']}}</td>
                            <td>{{$notification['role']}}</td>
                            <td>{{$notification['coordinators']}}</td>
                            <td>{{$notification['place']}}</td>
                            <td>{{$notification['from_date']}}</td>
                            <td>{{$notification['to_date']}}</td>
                            <td>{{$notification['academic_year']}}</td>
                            <td>{{$notification['academic_semester']}}</td>
                            <td>
                              @if($notification['file']=='')
                              <center>-</center>
                              @else
                              <a href="{{asset('activities/faculty/'.$notification['file'].'')}}" target="_blank">File</a>
                              @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer"><button type="button" class="btn btn-info btn-sm mark_read" id="{{$notification['sr_no']}}" style="float:right;">Mark as read</button></div>
    </div>
    <br/>
    <br/>
    
    @endforeach
    </form>


@endif

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color:#5cb85c;color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Response</center></h4>
      </div>
      <div class="modal-body">
        <p style=""><b>Your notification has been marked as read.</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

        </div>
    </div>

  </div>
</div>

@endsection

@section('customJS')
<script type="text/javascript">
    $('.mark_read').click(function(){
        var notification_id=$(this).prop('id');
        token = $('#token').val();
        
        $.ajax({
            type:'POST',
            data:{notification_id:notification_id,_token:token},
            url:"{{url('faculty/delete/notification')}}",
            success:function($data)
            {
                $("#myModal").modal();
                window.setTimeout(function() {
                    location. reload(true);
                }, 2000);
            }
        });
    });
</script>
@endsection
