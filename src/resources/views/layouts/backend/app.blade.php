<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Dashboard</title>
    <meta name="description" content="Admin Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="apple-touch-icon" href="{{asset('backend/apple-icon.png')}}" />
    <link rel="shortcut icon" href="{{asset('backend/favicon.ico')}}" />

    <link rel="stylesheet" href="{{asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/vendors/themify-icons/css/themify-icons.css')}}" />

    <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet" type="text/css" />

    @stack('header')
</head>

<body>
    <!-- Left Panel -->
    @include('layouts.backend.components.navbar')
    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">
        <!-- Header-->
        @include('layouts.backend.components.header')
        <!-- /header -->
        <!-- .content -->
        @yield('content')
    </div>
    <!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="{{asset('backend/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendors/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('backend/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/main.js')}}"></script>

    @stack('footer')
</body>

</html>
