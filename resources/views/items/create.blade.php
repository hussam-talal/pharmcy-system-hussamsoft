@extends('layouts.minbag')
@section('title')
اضافة صنف 
@endsection
@section('contentheader')
الأصناف
@endsection
@section('contentheaderlink')
<a href="{{ route('items.index') }}">  الأصناف </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة صنف جديد</h3>
          <h6 class=" text-red text-left">   الحقول الذي امامة * مطلوب</h6>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
      
      <form action="{{ route('items.store') }}" method="post" enctype="multipart/form-data" >
        <div class="row">
        @csrf
    <div class="col-md-3">    
      <div class="form-group">
<label>  باركود الصنف</label>
<input name="barcode" id="barcode" class="form-control" value="{{ old('barcode') }}" placeholder="ادخل  باركود الصنف"  >
@error('barcode')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-4">   
<div class="form-group">
  <label><span class="text-red" >*</span> اسم الصنف العلمي  </label>
  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الصنف"   >
  @error('name')
  <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
</div>
<div class="col-md-4">   
  <div class="form-group">
    <label><span class="text-red" ></span>    اسم الصنف التجاري</label>
    <input name="name1" id="name1" class="form-control" value="{{ old('name1') }}" placeholder="ادخل اسم الصنف"   >
  </div>
  </div>
<div class="col-md-3"> 
<div class="form-group"> 
  <label> <span class="text-red" >*</span> نوع الصنف</label>
  <select name="item_type" id="item_type" class="form-control">
   <option value="">اختر النوع</option>
  <option   @if(old('item_type')==1) selected="selected"  @endif value="1"> مخزني</option>
  <option   @if(old('item_type')==2) selected="selected"  @endif value="2"> استهلاكي بتاريخ صلاحية</option>
  <option   @if(old('item_type')==3) selected="selected"  @endif value="3"> عهدة</option>
  </select>

  @error('item_type')
  <span class="text-danger">{{ $message }}</span>
  @enderror
  </div>
</div>

<div class="col-md-3"> 
  <div class="form-group"> 
    <label><span class="text-red" >*</span>  فئة الصنف</label>
    <select name="items_categories_id" id="items_categories_id" class="form-control ">
      <option value="">اختر الفئة</option>
      @if (@isset($items_categories) && !@empty($items_categories))
     @foreach ($items_categories as $info )
       <option @if(old('items_categories_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
     @endforeach
      @endif
    </select>
    @error('items_categories_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
  </div>

  <div class="col-md-3"> 
    <div class="form-group"> 
      <label>   الصنف البديل</label>
      <select name="alternative_medicine_id" id="alternative_medicine_id" class="form-control ">
        <option value="">اختر الصنف البديل</option>
        @if (@isset($alternative_medicine) && !@empty($alternative_medicine))
       @foreach ($alternative_medicine as $info )
         <option @if(old('alternative_medicine_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
       @endforeach
        @endif
      </select>
      @error('alternative_medicine_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
    </div>
  
  <div class="col-md-<td>{{ $info->name }}</td> "> 
    <div class="form-group"> 
      <label><span class="text-red" >*</span> الوحدة الرئيسية</label>
      <select name="unit_id" id="unit_id" class="form-control ">
        <option value="">اختر الوحدة الرئيسية</option>
        @if (@isset($units_parent) && !@empty($units_parent))
       @foreach ($units_parent as $info )
         <option @if(old('unit_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
       @endforeach
        @endif
      </select>
      @error('unit_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
    </div>
      <div class="col-md-3  "   id="retail_uom_idDiv"> 
        <div class="form-group"> 
          <label> <span class="text-red" >*</span>الوحدة التجزئة (<span class="parentunitname"></span>)</label>
          <select name="retail_units_id" id="retail_units_id" class="form-control ">
            <option value="">اختر الوحدة التجزئة</option>
            @if (@isset($units_child) && !@empty($units_child))
           @foreach ($units_child as $info )
             <option @if(old('retail_units_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
           @endforeach
            @endif
          </select>
          @error('retail_units_id')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div>
        <div class="col-md-5 relatied_retial_counter "@if (old('retail_units_id')=='') style="display: none;" @endif> 
        <div class="form-group">
          <label>عدد وحدات التجزئة  (<span class="childunitname"></span>) بالنسبة للرئيسية(<span class="parentunitname"></span>)  </label>
          <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="retail_unit_quntToParent" id="retail_unit_quntToParent" class="form-control"  value="{{ old('retail_unit_quntToParent') }}" placeholder="ادخل  عدد وحدات التجزئة"  >
          @error('retail_unit_quntToParent')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div>
      <div class="col-md-2">
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
     
      <div class="col-md-3" style="border:solid 5px #000 ; margin:10px;">
        <div class="form-group"> 
          <label>   صورة الصنف ان وجدت</label>
        <img id="uploadedimg" src="#" alt="uploaded img" style="width: 200px; width: 200px;" >        
       <input onchange="readURL(this)" type="file" id="item_img" name="item_img" class="form-control">
          @error('photo')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div>  
      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> اضافة</button>
        <a href="{{ route('items.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
      
      </div>
    </div>
    
   </div>  
  </form>  
        
</div>  

</div>
</div>
    

@endsection


@section('script')
<script src="{{ asset('assets/js/items.js') }}"></script>
<script>
var unit_id=$("#unit_id").val();
if(unit_id!=""){
  var name=$("#unit_id option:selected").text();  
    $(".parentunitname").text(name); 
}

var retail_units_id=$("#retail_units_id").val();
if(retail_units_id!=""){
  var name=$("#retail_units_id option:selected").text();  
    $(".childunitname").text(name); 
}
</script>

@endsection






