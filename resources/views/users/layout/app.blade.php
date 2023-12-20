<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mr.Fun Club Garmsar</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('Admin_lte')}}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('css')}}/rtl.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>

    </style>
    @stack('style')
</head>
<body class="hold-transition layout-top-nav" dir="rtl">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{route('home')}}" class="navbar-brand">
                <img src="{{asset('Admin_lte')}}/dist/img/mfc_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">مستر فان کلاب</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">خانه</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('user.reserve.index')}}" class="nav-link">رزرو</a>
                    </li>

                    {{--<li class="nav-item">
                        <a href="index3.html" class="nav-link">بازی ها</a>
                    </li>--}}

                    <li class="nav-item">
                        <a href="{{route('user.logout')}}" class="nav-link">خروج</a>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$pageTitle}}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                @yield('content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer" style="font-size: 0.9em">
        <!-- To the right -->
        <div class="float-left d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        کلیه حقوق مادی و معنوی این وب سایت برای کافه گیم مستر فان گرمسار محفوظ می باشد.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('Admin_lte')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('Admin_lte')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('Admin_lte')}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('js')}}/bootstrap-input-spinner.js"></script>
<script>
    $(".input_spinner").inputSpinner()
</script>
@stack('js')
</body>
</html>