<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <!-- Styles -->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css')}}">
    <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;

                margin: 0;
            }


            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        
</head>
<body>
<div class="container-fluid" style="margin-top:100px;">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md" >
                    <p style="font-size:60px;">Birla Vishvakarma Mahavidyalaya</p>
                    <p style="font-size:40px;">Department Activity Portal</p>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row" style="text-align:center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                <div class="col-md-4"><a href="{{route('student.login')}}" class="btn btn-info" role="button" style="width:150px;">Student</a></div>
                <div class="col-md-4"><a href="{{route('faculty.login')}}" class="btn btn-info" role="button" style="width:150px;">Faculty</a></div>
                <div class="col-md-4"><a href="{{route('admin.login')}}" class="btn btn-info" role="button" style="width:150px;">Admin</a></div>
                </div>
            </div>
            <div class="col-md-2"></div>

        </div>
</div>       
</body>
</html>