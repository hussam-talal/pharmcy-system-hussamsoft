@extends('layouts.minbag')
@section('title')
تعديل صلاحية المستخدم

@endsection

@section('contentheader')
الصلاحيات
@endsection

@section('contentheaderlink')
<a href="{{ route('roles.index') }}"> صلاحيات المستخدمين </a>
@endsection

@section('contentheaderactive')
تعديل
@endsection



@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطا</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('roles.update', $role['id'])}}" method="POST">
  @csrf
{{-- {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!} --}}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                  <div class="form-group">
                    <label><span class="text-red" >*</span>  اسم  الصلاحية</label>
                    <input name="name" id="name" class="form-control" value="{{$role['name']}}" placeholder="{{$role['name']}}  "   >
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-4">
                        <ul id="treeview1">
                            <li><a href="#">الصلاحيات</a>
                                <ul>
                                    <li>
                                        @foreach($permission as $value)
                                        <label>
                                          <input type="checkbox" name="permission[]"  value="{{$value->id}}" {{ in_array($value->id, $rolePermissions) ? 'checked' : ''}} 
                                           class="name" >
                                           {{ $value->name }}  
                                          </label> <br>
{{-- 
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                            {{ $value->name }}</label>
                                        <br /> --}}
                                        @endforeach
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                    <!-- /col -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
</form>
@endsection


