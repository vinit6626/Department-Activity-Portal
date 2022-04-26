@extends('layouts.faculty_dash_layout')

@section('customStyle')

<link rel="stylesheet" href="{{asset('css/jquery.dataTables.css')}}">
<style type="text/css">
  .dataTables_filter{
    display: none;
  }
  table.dataTable thead th {
  font-weight: !important;
  border-right: 1px solid rgb(221, 221, 221);
  }
</style>
@endsection

@section('content')
<div class="container" style="margin-left:-10px;max-width:1055px;">

<ul class="nav nav-tabs" style="vertical-align:middle;margin-bottom:10px;margin-left:0px;">
    <li class="active"><a href="#"><b><span style="font-size:17px;">Published Papers</span></b></a></li>
</ul>
<br/>


@if(session()->has('success_message'))
  <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{session('success_message')}}
  </div>
@endif

<div class="table-responsive">
    <table id="example" class="table table-condensed display cell-border" style="width:100%;margin-bottom: 20px;border-top:1px solid rgb(221, 221, 221);">
        <thead>
            <tr>
                <th style="padding-left: 10px;vertical-align:middle;">Sr no</th>
                <th style="padding-left: 10px;vertical-align:middle;">Paper Title</th>
                <th style="padding-left: 10px;vertical-align:middle;">Authors Detail</th>

                <th style="padding-left: 10px;vertical-align:middle;">Paper Type</th>
                <th style="padding-left: 10px;border-left:1px solid rgb(221, 221, 221);vertical-align:middle;">ISSN</center></th>
                <th style="padding-left: 10px;vertical-align:middle;">ISBN</th>
                <th style="padding-left: 10px;vertical-align:middle;">DOI number</th>
                
                <th style="padding-left: 10px;vertical-align:middle;">Conference Name</th>
                <th style="padding-left: 10px;vertical-align:middle;">Journal Name</th>
                
                <th style="padding-left: 10px;vertical-align:middle;">Published/ Presented</th> 
                <th style="padding-left: 10px;vertical-align:middle;">Volume & Issue</th>
                <th style="padding-left: 10px;vertical-align:middle;">Page Num</th>
                <th style="padding-left: 10px;vertical-align:middle;">Impact Factor</th>
                <th style="padding-left: 10px;vertical-align:middle;">Publication Month</th>
                <th style="padding-left: 10px;vertical-align:middle;">Publication Year</th>                  
                <th style="padding-left: 10px;vertical-align:middle;">Academic year</th>
                <th style="padding-left: 10px;vertical-align:middle;">Academic semester</th>
                <th style="padding-left: 10px;vertical-align:middle;">File</th>
                <th style="padding-left: 10px;vertical-align:middle;">Edit</th>

            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            @foreach($activities as $activity)
            <tr>
              <td>{{++$i}}</td>
              <td>{{$activity['paper_title']}}</td>
              <td>{{$activity['authors_detail']}}</td>

              <td>{{$activity['paper_type']}}</td>
              <td><center>{{($activity['ISSN']=='')?'-':$activity['ISSN']}}</center></td>
              <td><center>{{($activity['ISBN']=='')?'-':$activity['ISBN']}}</center></td>
              <td><center>{{($activity['DOI_number']=='')?'-':$activity['DOI_number']}}</center></td>
              <td><center>{{($activity['conference_name']=='')?'-':$activity['conference_name']}}</center></td>
              <td><center>{{($activity['journal_name']=='')?'-':$activity['journal_name']}}</center></td>
              <td>{{$activity['published_or_presented']}}</td>
              <td><center>{{($activity['volume_and_issue']=='')?'-':$activity['volume_and_issue']}}</center></td>
              <td><center>{{($activity['page_num']=='')?'-':$activity['page_num']}}</center></td>
              <td><center>{{($activity['impact_factor']=='')?'-':$activity['impact_factor']}}</center></td>
              <td>{{$activity['publication_month']}}</td>
              <td>{{$activity['publication_year']}}</td>
              <td>{{$activity['academic_year']}}</td>
              <td>{{$activity['academic_semester']}}</td>
              <td>
                @if($activity['file']=='')
                <center>-</center>
                @else
                <a href="{{asset('activities/faculty/'.$activity['file'].'')}}" target="_blank">File</a>
                @endif
              </td>
              <td><a href="{{url('faculty/edit/published_paper/'.$activity['sr_no'])}}">Edit</a>
              </td>
            </tr>
            @endforeach            
        </tbody>
    </table>
</div>
</div>
@endsection

@section('customJS')
<script type="text/javascript">
$(document).ready(function() {

    var table = $('#example').DataTable({
      //"ordering": false,
      "bInfo":false,
      "dom": '<"top"i>rt<"bottom"flp><"clear">',
      
    });

});
</script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.js')}}"></script>
@endsection