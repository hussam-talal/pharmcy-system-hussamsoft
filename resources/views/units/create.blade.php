@extends('layouts.minbag')
@section('title')
الوحدات
@endsection
@section('contentheader')
الوحدات
@endsection
@section('contentheaderlink')
<a href="{{ route('units.index') }}">  الوحدات </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة وحدة صنف </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
    
      <form action="{{ route('units.store') }}" method="post" >
        @csrf
        <div class="row">
          <div class="col-md-4">
      <div class="form-group">
<label>اسم  الوحدة</label>
<input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الوحدة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
@error('name')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-4">
<div class="form-group"> 
  <label>   نوع الوحدة</label>
  <select name="is_main" id="is_main" class="form-control">
   <option value="1">اختر النوع</option>
  <option   @if(old('is_main')==1) selected="selected"  @endif value="1"> وحدة رئيسية</option>
   <option @if(old('is_main')==0 and old('is_main')!="" ) selected="selected"   @endif value="0"> وحدة تجزئة</option>
  </select>
  @error('is_main')
  <span class="text-danger">{{ $message }}</span>
  @enderror
  </div>
</div>

<div class="col-md-4">
      <div class="form-group"> 
        <label>  حالة التفعيل</label>
        <select name="active" id="active" class="form-control">
         <option value="">اختر الحالة</option>
        <option   @if(old('active')==1) selected="selected"  @endif value="1"> نعم</option>
         <option @if(old('active')==0 and old('active')!="" ) selected="selected"   @endif value="0"> لا</option>
        </select>
      
        @error('active')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
      </div>
        </div>
      <div class="form-group text-center">
        <button type="submit" class="btn btn-primary btn-md"> اضافة</button>
        <a href="{{ route('units.index') }}" class="btn btn-md btn-danger">الغاء</a>    
      
      </div>
        
            
            </form>  
        
            

            </div>  

      


        </div>
      </div>
    </div>
</div>





@endsection



