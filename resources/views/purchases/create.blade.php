@extends('layouts.minbag')
@section('title')
المشتريات
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
مشتريات
@endsection
@section('contentheaderlink')
<a href="{{ route('purchases.index') }}">  فواتير المشتريات </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')

<div class="card">
<div class="row">
    <div class="col-12">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة  فاتورة مشتريات من مورد </h3>
        </div>
      </div>
    </div>

        <!-- /.card-header -->
        <div class="card-body">
    
      <form action="{{ route('purchases.store') }}" method="post" >
        @csrf
        <div class="row">
        <div class="col-md-3 ">
        <div class="form-group ">
          <label>  تاريخ الفاتورة</label>
          <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
          @error('notes')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-4 ">
        <div class="form-group ">
          <label>   رقم الفاتورة المسجل بأصل فاتورة المشتريات</label>
          <input name="DOC_NO" id="DOC_NO" type="text"  class="form-control" value="{{ old('DOC_NO') }}"    >
          @error('DOC_NO')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-4">
          <div class="form-group "> 
            <label class="">   بيانات الموردين</label>
            <select name="suuplier_code" id="suuplier_code" class=" form-control select2  ">
              <option  value="">اختر المورد</option>
              @if (@isset($suupliers) && !@empty($suupliers))
              @foreach ($suupliers as $info )
               <option @if(old('suuplier_code')==$info->suuplier_code) selected="selected" @endif value="{{ $info->suuplier_code }}"> {{ $info->name }} </option>
             @endforeach
              @endif
            </select>
            @error('suuplier_code')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>
  
     <div class="col-md-3 ">
<div class="form-group"> 
  <label>   نوع الفاتورة</label>
  <select name="pill_type" id="pill_type" class="form-control">
  <option   @if(old('pill_type')==1) selected="selected"  @endif value="1">  كاش</option>
   <option @if(old('pill_type')==2 ) selected="selected"   @endif value="2">  اجل</option>
  </select>
  @error('pill_type')
  <span class="text-danger">{{ $message }}</span>
  @enderror
  </div>
     </div>

  <div class="col-md-4 ">
  <div class="form-group"> 
    <label>    بيانات المخازن</label>
    <select name="store_id" id="store_id" class="form-control select2  " >
      <option value=""> اختر المخزن المستلم للفاتورة</option>
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
  </div>

  <div class="col-md-5 ">
  <div class="form-group">
    <label>  ملاحظات</label>
    <input name="notes" id="notes" class="form-control" value="{{ old('notes') }}"    >
    @error('notes')
    <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>
  </div>
    <div class="col-md-12 ">
      <div class="form-group text-center">
        <button type="submit" class="btn btn-primary btn-md m-1 border-2"> اضافة</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-md btn-danger">الغاء</a>    
      
      </div>
    </div>

    </div>
        
            
            </form>  
        
            

            </div>  

      


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



