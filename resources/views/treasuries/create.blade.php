@extends('layouts.minbag')
@section('title')
اضافة خزنة جديدة
@endsection

@section('contentheader')
الخزن
@endsection

@section('contentheaderlink')
<a href="{{ route('treasuries.index') }}"> الخزن </a>
@endsection

@section('contentheaderactive')
اضافة
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
    
      <form action="{{ route('treasuries.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="col-md-4">
      <div class="form-group">
<label>اسم الخزنة</label>
<input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الخزنة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
@error('name')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-3">
<div class="form-group">
  <label> هل رئيسية</label>
  <select name="is_main" id="is_main" class="form-control">
   <option value="">اختر النوع</option>
   <option  @if(old('is_main')==1) selected="selected"  @endif value="1"> نعم</option>
   <option @if(old('is_main')==0 and old('is_main')!="") selected="selected"   @endif value="0"> لا</option>

  </select>

  @error('is_main')
  <span class="text-danger">{{ $message }}</span>
  @enderror
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
    <label> اخر رقم ايصال صرف نقدية  </label>
    <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_exhcange" id="last_isal_exhcange" class="form-control"  value="{{ old('last_isal_exhcange') }}" placeholder="ادخل رقم اخر ايصال صرف " oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
    @error('last_isal_exhcange')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label> اخر رقم ايصال تحصيل نقدية </label>
      <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_collect" id="last_isal_collect" class="form-control"  value="{{ old('last_isal_collect') }}" placeholder="ادخل رقم اخر تحصيل" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      @error('last_isal_collect')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
    </div>
    <div class="col-md-3">
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
      <div class="col-md-12">
        <div class="form-group text-center">
          <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> اضافة</button>
          <a href="{{ route('treasuries.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
        
        </div>
      </div>
   
        
            
            </form>  
        
            

            </div>  

      


        </div>
      </div>
    </div>
</div>





@endsection



