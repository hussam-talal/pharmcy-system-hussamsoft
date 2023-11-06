<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title></title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/style77.css">
    </head>
    <body >
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
						@yield('systemdata')
						<div class="login-left">
							<div class="login-left-wrap">
								@if ($errors->any())
								@foreach ($errors->all() as $error)
									<x-alerts.danger :error="$error" />
								@endforeach
							@endif
								@yield('content')
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/script.js"></script>
</html>