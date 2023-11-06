

@extends('layouts.minbag')
@section('title')
اضافة الصلاحيات
@endsection

@section('contentheader')
صلاحيات
@endsection

@section('contentheaderlink')
<a href="{{ route('roles.index') }}"> الصلاحيات </a>
@endsection

@section('contentheaderactive')
اضافة
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





<form action="{{ route("roles.store")}}" method="post">
    @csrf
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="col-xs-7 col-sm-7 col-md-7">
                       
                        <div class="form-group">
                            <label><span class="text-red" >*</span>  اسم  الصلاحية</label>
                            <input name="role" id="role" class="form-control"  placeholder="ادخل اسم الصلاحية"   >
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
                            </li>
                            @foreach($permission as $value)
                            <label>
                            <input type="checkbox" name="permission[]"  value="{{$value->id}}"  class="name"  >
                             {{ $value->name }} 
                                
                            </label> <br>
                            @endforeach
                            </li>

                        </ul>
                        </li>
                        </ul>
                    </div>
                    <!-- /col -->
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                    </div>

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



