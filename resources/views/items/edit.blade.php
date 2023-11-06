@extends('layouts.minbag')
@section('title')
تعديل صنف 
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
          <h3 class="card-title card_title_center"> تعديل بيانات صنف </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
      
      <form action="{{ route('items.update',$data['id']) }}" method="post" enctype="multipart/form-data" >
        <div class="row">
        @csrf
    <div class="col-md-2">    
      <div class="form-group">
<label>  باركود الصنف   </label>
<input name="barcode" id="barcode" class="form-control" value="{{ old('name',$data['barcode']) }}" placeholder="ادخل  باركود الصنف"  >
@error('barcode')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-4">   
<div class="form-group">
  <label>اسم  الصنف العلمي</label>
  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="ادخل اسم الصنف"   >
  @error('name')
  <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
</div>
<div class="col-md-4">   
  <div class="form-group">
    <label>اسم  الصنف التجاري</label>
    <input name="name1" id="name1" class="form-control" value="{{ old('name1',$data['name1']) }}" placeholder="ادخل اسم الصنف"   >
    @error('name1')
    <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>
  </div>
<div class="col-md-3"> 
<div class="form-group"> 
  <label>  نوع الصنف</label>
  <select  name="item_type" id="item_type" class="form-control">
   <option value="">اختر النوع</option> 
  <option {{  old('item_type',$data['item_type'])==1 ? 'selected' : ''}}   value="1"> مخزني</option>
  <option {{  old('item_type',$data['item_type'])==2 ? 'selected' : ''}}   value="2"> استهلاكي بتاريخ صلاحية</option>
  <option {{  old('item_type',$data['item_type'])==3 ? 'selected' : ''}}   value="3"> عهدة</option>
  </select>

  @error('item_type')
  <span class="text-danger">{{ $message }}</span>
  @enderror
  </div>
</div>

<div class="col-md-3"> 
  <div class="form-group"> 
    <label>  فئة الصنف</label>
    <select name="items_categories_id" id="items_categories_id" class="form-control ">
      <option value="">اختر الفئة</option>
      @if (@isset($items_categories) && !@empty($items_categories))
     @foreach ($items_categories as $info )
       <option {{  old('items_categories_id',$data['items_categories_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
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
      <label><span class="text-red" ></span>   الصنف البديل</label>
      <select name="alternative_medicine_name" id="alternative_medicine_name" class="form-control ">
        <option value="">اختر الصنف البديل</option>
        @if (@isset($alternative_medicine) && !@empty($alternative_medicine))
       @foreach ($alternative_medicine as $info )
         <option @if(old('alternative_medicine_id',$data['alternative_medicine_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
       @endforeach
        @endif
      </select>
      @error('alternative_medicine_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
  </div>
  <div class="col-md-3"> 
    <div class="form-group"> 
      <label>   الوحدة  الرئيسية</label>
      <select  name="unit_id" id="unit_id" class="form-control ">
        <option value="">اختر الوحدة الرئيسية</option>
        @if (@isset($units_parent) && !@empty($units_parent))
       @foreach ($units_parent as $info )
         <option {{  old('unit_id',$data['unit_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
       @endforeach
        @endif
      </select>
      @error('unit_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
    </div>
      <div class="col-md-3  "  id="retail_uom_idDiv"> 
        <div class="form-group"> 
          <label>   وحدة التجزئة  بالنسبة للوحدة الرئيسية(<span class="parentunitname"></span>)</label>
          <select  name="retail_units_id" id="retail_units_id" class="form-control ">
            <option value="">اختر الوحدة الرئيسية</option>
            @if (@isset($units_child) && !@empty($units_child))
           @foreach ($units_child as $info )
             <option {{  old('retail_units_id',$data['retail_units_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
           @endforeach
            @endif
          </select>
          @error('retail_units_id')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div>
        <div class="col-md-4  "  > 
        <div class="form-group">
          <label>عدد وحدات التجزئة  (<span class="childunitname"></span>) بالنسبة للرئيسية (<span class="parentunitname"></span>)  </label>
          <input  name="retail_unit_quntToParent" id="retail_unit_quntToParent" class="form-control"  value="{{ old('retail_unit_quntToParent',$data['retail_unit_quntToParent']*1) }}" placeholder="ادخل  عدد وحدات التجزئة"  >
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
        <option  {{  old('active',$data['active'])==1 ? 'selected' : ''}} value="1"> نعم</option>
         <option {{  old('active',$data['active'])==0 ? 'selected' : ''}} value="0"> لا</option>
        </select>
        @error('active')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
      </div>
     
      <div class="col-md-3" style="border:solid 5px #000 ; margin:10px;">
        <div class="form-group"  >
          <label> صورة الصنف</label>
      <div class="image">
     <img id="uploadedimg" class="custom_img" src="{{ asset('assets/uploads').'/'.$data['photo'] }}"  alt="لوجو الصنف">       
<button type="button" class="btn btn-sm btn-danger" id="update_image">تغير الصورة</button>
<button type="button" class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image"> الغاء</button>


 
      </div>
<div id="oldimage">

</div>


      </div> 
        </div>  
      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_edit_item_cardd" type="submit" class="btn btn-primary btn-sm"> حفظ التعديلات</button>
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

var uomretail_units_id_id=$("#retail_units_id").val();
if(retail_units_id!=""){
  var name=$("#retail_units_id option:selected").text();  
    $(".childunitname").text(name); 
}
</script>

@endsection






