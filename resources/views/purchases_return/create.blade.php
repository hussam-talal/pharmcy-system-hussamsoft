@extends('layouts.minbag')
@section('title')
مرتجع المشتريات العام
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('purchasesreturn.index') }}">  فواتير مرتجع المشتريات العام </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة  فاتورة مرتجع مشتريات عام من مورد </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
    
      <form action="{{ route('purchasesreturn.store') }}" method="post" >
        @csrf
          <div class="form-group"> 
            <label>    بحث</label>
            <select name="search" id="search" class="form-control select2">
              <option value="">اختر البحث</option>
            
               <option value="1"> الموردين </option>
               <option value="2"> التاريخ </option>
               <option value="3"> رقم الفاتورة </option>
               <option value="4"> اسم الدواء </option>
               <option value="5">  الباركود </option>

            </select>
            @error('suuplier_code')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
          
          <input name="searchonpurchases" id="searchonpurchases" type="search" value="" class="form-control"  >
          {{-- @error('notes')
          <span class="text-danger">{{ $message }}</span>
          @enderror --}}
        </div>

  
  <div class="form-group"> 
    <label>    بيانات المخازن</label>
    <select name="store_id" id="store_id" class="form-control select2">
      <option value=""> اختر   مخزن صرف المرتجع</option>
      @if (@isset($stores) && !@empty($stores))
     @foreach ($stores as $info )
       <option @if(old('store_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
     @endforeach
      @endif
    </select>
    @error('store_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
    <div class="form-group">
          <label>  تاريخ الفاتورة</label>
          <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
          @error('notes')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

      <div class="form-group text-center">
        <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
        <a href="{{ route('purchasesreturn.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
      
      </div>
        
            
            </form>  
        
            

            </div>  

        </div>
      </div>
    </div>
</div>

@endsection

@section("script")

<script  src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
  //Initialize Select2 Elements
  $('.select2').select2({
    theme: 'bootstrap4'
  });
  </script>
@endsection



