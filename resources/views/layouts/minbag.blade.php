<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('title')</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/SansPro/SansPro.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/custom_rtl.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/systemstyle2.css')}}">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
 @include('includes.header')
  @include('includes.sidebar')
  @include('includes.content')
</div>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/js/general.js') }}"></script>
@yield('script')
</body>
</html>