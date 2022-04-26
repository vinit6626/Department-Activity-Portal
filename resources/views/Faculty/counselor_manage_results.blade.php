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
    <li class="active"><a href="#"><b><span style="font-size:17px;">Students Results</span></b></a></li>
    <li><a href="{{url('faculty/counselor/edit/results')}}"><span style="font-size:17px;">Edit Results</span></a></li>
</ul>
<br/>
<div class="table-responsive" style="margin-left:-13px;margin-right:-3px;">
    <table class="table table-condensed table-bordered" style="width:100%;margin-bottom: 20px;">
        
        <thead>
            <tr>
                <th style="padding-left: 10px;">Student ID</th>
                <th style="padding-left: 10px;">SPI<br>(sem1)</th>
                <th style="padding-left: 10px;">CPI<br>(sem1)</th>
                <th style="padding-left: 10px;">SPI<br>(sem2)</th>
                <th style="padding-left: 10px;">CPI<br>(sem2)</th>
                <th style="padding-left: 10px;">SPI<br>(sem3)</th>
                <th style="padding-left: 10px;">CPI<br>(sem3)</th>
                <th style="padding-left: 10px;">SPI<br>(sem4)</th>
                <th style="padding-left: 10px;">CPI<br>(sem4)</th>
                <th style="padding-left: 10px;">SPI<br>(sem5)</th>
                <th style="padding-left: 10px;">CPI<br>(sem5)</th>
                <th style="padding-left: 10px;">SPI<br>(sem6)</th>
                <th style="padding-left: 10px;">CPI<br>(sem6)</th>
                <th style="padding-left: 10px;">SPI<br>(sem7)</th>
                <th style="padding-left: 10px;">CPI<br>(sem7)</th>
                <th style="padding-left: 10px;">SPI<br>(sem8)</th>
                <th style="padding-left: 10px;">CPI<br>(sem8)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{$result['student_id']}}</td>
                <td><center>{{($result['spi_sem1']=='')?'-':$result['spi_sem1']}}</center></td>
                <td><center>{{($result['cpi_sem1']=='')?'-':$result['cpi_sem1']}}</center></td>
                <td><center>{{($result['spi_sem2']=='')?'-':$result['spi_sem2']}}</center></td>
                <td><center>{{($result['cpi_sem2']=='')?'-':$result['cpi_sem2']}}</center></td>
                <td><center>{{($result['spi_sem3']=='')?'-':$result['spi_sem3']}}</center></td>
                <td><center>{{($result['cpi_sem3']=='')?'-':$result['cpi_sem3']}}</center></td>
                <td><center>{{($result['spi_sem4']=='')?'-':$result['spi_sem4']}}</center></td>
                <td><center>{{($result['cpi_sem4']=='')?'-':$result['cpi_sem4']}}</center></td>
                <td><center>{{($result['spi_sem5']=='')?'-':$result['spi_sem5']}}</center></td>
                <td><center>{{($result['cpi_sem5']=='')?'-':$result['cpi_sem5']}}</center></td>
                <td><center>{{($result['spi_sem6']=='')?'-':$result['spi_sem6']}}</center></td>
                <td><center>{{($result['cpi_sem6']=='')?'-':$result['cpi_sem6']}}</center></td>
                <td><center>{{($result['spi_sem7']=='')?'-':$result['spi_sem7']}}</center></td>
                <td><center>{{($result['cpi_sem7']=='')?'-':$result['cpi_sem7']}}</center></td>
                <td><center>{{($result['spi_sem8']=='')?'-':$result['spi_sem8']}}</center></td>
                <td><center>{{($result['cpi_sem8']=='')?'-':$result['cpi_sem8']}}</center></td>
            </tr>
            @endforeach            
        </tbody>
    </table>
</div>

@endsection


@section('customJS')
 
@endsection