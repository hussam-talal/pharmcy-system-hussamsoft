@extends('layouts.auth')
@section('systemdata')
<div class="login-right">
	<img class="img-fluid" src="{{ asset('assets/uploads').'/'.$systemData['photo'] }} " alt="Logo"><br>
	{{ $systemData['system_name'] }}
</div>
@endsection
@section('content')
<h1>تسجيل دخول</h1><br>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
@endif
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="username" type="text" placeholder="اسم المستخدم ">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="كلمة المرور">
	</div>
	<div class="form-group">
		<button class="btn btn-primary btn-block" type="submit">تسجيل دخول</button>
	</div>
</form>

@endsection