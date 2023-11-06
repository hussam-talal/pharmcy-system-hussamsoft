@extends('layouts.minbag')
@section('title')
الاصناف البديلة
@endsection
@section('contentheader')
الاصناف البديلة
@endsection
@section('contentheaderlink')
<a href="{{ route('alternatives.index') }}">  الاصناف البديلة </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تعديل   صنف بديل </h3>
        
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        @if (@isset($data) && !@empty($data))
      <form action="{{ route('alternatives.update',$data['id']) }}" method="post" >
        @csrf
        
      <div class="form-group">
        <label>اسم  الصنف البديل</label>
        <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
     

        {{-- <div class="form-group"> 
          <label>  نوع الوحدة </label>
          <select @if($total_counter_used>0) disabled  @endif name="is_main" id="is_main" class="form-control">
           <option value="">اختر النوع</option>
          <option   @if(old('is_main')==1) selected="selected"  @endif value="1"> وحدة اب</option>
           <option   @if(old('is_main')==0) selected="selected"  @endif value="0"> وحدة تجزئة</option>
          </select>
          @error('is_main')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          </div> --}}
          <div class="form-group"> 
            <label>  حالة التفعيل</label>
            <select name="active" id="active" class="form-control">
             <option value="">اختر الحالة</option>
             <option {{  old('active',$data['active'])==1 ? 'selected' : ''}}   value="1"> نعم</option>
             <option {{ old('active',$data['active'])==0 ? 'selected' : ''}}  value="0"> لا</option>
            </select>
            @error('active')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
      <div class="form-group text-center">
<button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
<a href="{{ route('alternatives.index') }}" class="btn btn-sm btn-danger">الغاء</a>    

      </div>

    
    </form>  

        @else
  <div class="alert alert-danger">
    عفوا لاتوجد بيانات لعرضها !!
  </div>
        @endif
      


        </div>
      </div>
    </div>
</div>





@endsection



