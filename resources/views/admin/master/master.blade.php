<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CMS- @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/custom.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .content-header{
            padding: 25px .5rem;
        }
        .breadcrumb{
            position: absolute;
            top: 10%;
            right: 10px;
        }
        .mbtm30{
            margin-bottom: 30px;
        }
        .margin5{
            margin:10px;
        }

        .dropdown-message{
            overflow-y: auto !important;
            max-height: 345px;
        }
        .notifiction-avatar .avatar {
            position: relative;
            display: inline-block;
            width: 40px;
            white-space: nowrap;
            border-radius: 1000px;
            vertical-align: bottom;
            background: #0275d8;
            color: white;
        }
        .notifiction-user-first-alpha {
            text-align: center;
            line-height: 3;
            font-weight: bold;
        }
        .notifiction-avatar.avatar-online{
            position: relative;
            background-color: #ebebeb;
            border-radius: 30px;
            position: relative;
            display: inline-block;
            width: 50px;
            white-space: nowrap;
            border-radius: 1000px;
            vertical-align: sub;
            height: 50px;
        }
    </style>
    @yield('head')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            @if($site_settings->messenger == 1)
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
{{--                    <span class="badge badge-danger navbar-badge">3</span>--}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-message">

                </div>
            </li>
        @endif
            <!-- Notifications Dropdown Menu -->
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <i class="far fa-bell"></i>--}}
{{--                    <span class="badge badge-warning navbar-badge">15</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                    <span class="dropdown-item dropdown-header">15 Notifications</span>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                        <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                        <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                        <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </li>
        </ul>
    </nav>
    <!-- /.navbar -->


    @include('admin.master.sidebar')

    @yield('content')


<!-- Main Footer -->
    <footer class="main-footer">
        <strong> CMS Developed By <a href="https://anaxdesigns.com/">Anaxdesigns.com</a> </strong>

        <div class="float-right d-none d-sm-inline-block">
            <b>Laravel Version</b> 7.25.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

{{--Modal for Responsive File Manager --}}
<div class="modal fade mymodal" id="fileManager">

    <div class="modal-dialog" style="max-width: 65% !important;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="position: absolute;right: 20px;font-size: 35px;">&times;</button>

                <h4 class="modal-title">File Manager</h4>

            </div>

            <div class="modal-body" style="padding:0px; margin:0px;">

                <iframe width="100%" height="500" src="@filemanager_get_resource(dialog.php)?&lang=en_EN&akey=@filemanager_get_key()" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>

            </div>

        </div>

    </div>

</div>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('admin/adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin/adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/adminLTE/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('admin/adminLTE/dist/js/demo.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('admin/adminLTE/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('admin/adminLTE/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin/adminLTE/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('admin/adminLTE/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('admin/adminLTE/plugins/chart.js/Chart.min.js')}}"></script>

<script src="{{asset('admin/js/custom.js')}}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{asset('admin/adminLTE/dist/js/pages/dashboard2.js')}}"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    $(document).ready(function(e) {
        @if(Session::has('mesg'))

        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title:  "{{Session::get('mesg')}}",
            showConfirmButton: false,
            timer: 1500
        })
        @endif

        @if(Session::has('error'))
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text:  "{{Session::get('error')}}",
            })
        @endif

    });

    function messagenotice () {
        $.ajax({
            url     : '{{URL::to('get-message-notification')}}',
            method  : 'get',
            success : function(data){
                console.log(data);
                $('.dropdown-message').html(data.result);
            }
        });
    }

    setInterval(function (e) {
        messagenotice();
    },3000)


</script>
@yield('js')

</body>
</html>
