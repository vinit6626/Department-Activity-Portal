<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{asset('css\bootstrap.min.css')}}">

    <title>Dashboard</title>
    <link rel="stylesheet" href="{{asset('css\Poppins_Fonts.css')}}"/>
    <link rel="stylesheet" href="{{asset('css\dashboard_style.css')}}"/>
    <script src="{{asset('\js\angular-1.6.9.min.js')}}"></script>
    @yield('customStyle')
</head>

<body>

<div class="wrapper">
  <!-- Sidebar Holder -->
    <div id="sidebar" style="position:sticky;top: 0;">
    <nav>
        
        <div class="text-center" style="margin-top: 10px;">
          <img src="{{asset(($admin['profile_image']!='')?'images/profiles/admins/'.$admin['profile_image'].'':'/images/profiles/user.jpg')}}" style="width:50px;height:50px;box-shadow: 1px 2px 15px #fff;" class="avatar img-circle" alt="User Profile">
          <h4>{{$admin['name']}}</h4>
          <hr>
        </div>
        <ul class="list-unstyled components" style="margin-top:-20px;">
          <li>
                <a href="{{url('/admin/dashboard')}}">Profile</a>
          </li>
          <li>
            <a href="#accountsSubmenu" data-toggle="collapse" aria-expanded="false">Accounts</a>
            <ul class="collapse list-unstyled" id="accountsSubmenu">
              <li><a href="{{url('admin/show/students/unverified')}}">Students</a></li>
              <li><a href="{{url('admin/show/faculties/unverified')}}">Faculties</a></li>
            </ul>
          </li>
          <li>
            <a href="#counselorsSubmenu" data-toggle="collapse" aria-expanded="false">Counselors</a>
            <ul class="collapse list-unstyled" id="counselorsSubmenu">
              <li><a href="{{url('admin/add/counselor')}}">Add New Counselor</a></li>
              <li><a href="{{url('admin/show/all/counselors')}}">Existing Counselors</a></li>
            </ul>
          </li>
          <li>
            <a href="#reportsSubmenu" data-toggle="collapse" aria-expanded="false">Generate Report</a>
            <ul class="collapse list-unstyled" id="reportsSubmenu">
              <li><a href="{{url('admin/generate/students/reports')}}">Students</a></li>
              <li><a href="{{url('admin/generate/faculties/reports')}}">Faculties</a></li>
            </ul>
          </li>
        </ul>
    </nav>
    </div>

    <!-- Page Content Holder -->
    <div id="content" style="width:100%;">

        <nav class="navbar navbar-default" style="top:0;box-shadow: 10px 4px 10px #888888;margin-bottom:20px;">
            
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn" style="float:left;margin-right:10px;">
                <i class="glyphicon glyphicon-align-left"></i>
                <span></span>
            </button>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="float:right;margin-right:5px;">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
          <div class="container-fluid">
            <div class="row">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><span style="word-break: keep-all;">Birla Vishvakarma Mahavidyalaya</span></a>
                    
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{url('admin/change_password')}}"><span class="glyphicon glyphicon-pencil"></span> Change password</a></li>
                        <li><a href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                        </li>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>

          </div>
        </nav>

        <div class="container-fluid" style="background-color:white;margin-left:10px;margin-right: 10px;box-shadow: 5px 10px 18px #888888;margin-bottom:20px;">
            <div style="margin-left:10px;margin-right: 10px;margin-top:10px;margin-bottom:10px;">
            <!-- content starts -->
            @yield('content')
            <!-- content ends -->
            </div>
        </div>
    
    </div>
</div>
<!-- jQuery library -->
<script src="{{asset('\js\jquery-3.3.1.min.js')}}"></script>

<!-- Latest compiled JavaScript -->
<script src="{{asset('\js\bootstrap.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {
      $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
        $(this).toggleClass("active");
      });
    });
    function windowH() {
       var wH = $(window).height();
       $('#sidebar').css({height: wH});
    }

    windowH();
</script>

@yield('customJS')

</body>

</html>