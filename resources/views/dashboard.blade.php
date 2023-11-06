@extends('layouts.minbag')

@section('logo')
 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		  <div class="image">
			 <img src="{{ asset('assets/uploads').'/'.$systemData['photo'] }}" class="img-circle elevation-2" alt="User Image">
		  </div>
		  <div class="info">
			 <a href="#" class="d-block">{{ $systemData['system_name'] }}</a>
		  </div>
	   </div> 
@endsection

@section('title')
الرئيسية
@endsection

@section('contentheader')
الرئيسية
@endsection

@section('contentheaderlink')
<a href="{{ route('dashboard') }}"> الرئيسية </a>
@endsection

@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="row" style="background-image: url({{ asset('assets/images/النظام-المحاسبي.png') }}) ;background-size:cover;background-repeate:ni-repeate; min-height:600px;">
    
</div>


@endsection



