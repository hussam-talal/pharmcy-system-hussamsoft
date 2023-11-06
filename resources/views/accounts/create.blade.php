@extends('layouts.minbag')
@section('title')
اضافة حساب مالي
@endsection

@section('contentheader')
الحسابات المالية
@endsection

@section('contentheaderlink')
<a href="{{ route('accounts.index') }}">  الحسابات المالية </a>
@endsection

@section('contentheaderactive')
اضافة
@endsection


@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة حساب مالي جديد</h3>
          <h6 class="text-red text-left"> الحقول الذي امامها * مطلوبة</h6>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
      
      <form action="{{ route('accounts.store') }}" method="post" >
        <div class="row">
        @csrf
    
<div class="col-md-4">   
<div class="form-group">
  <label><span class="text-red"> *</span>اسم  الحساب المالي</label>
  <input name="name" id="name" class="form-control" value="{{ old('name') }}"    >
  @error('name')
  <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
</div>


<div class="col-md-3"> 
  <div class="form-group"> 
    <label><span class="text-red"> *</span>  نوع الحساب</label>
    <select name="account_type" id="account_type" class="form-control ">
      <option value="">اختر النوع</option>
      @if (@isset($account_types) && !@empty($account_types))
     @foreach ($account_types as $info )
       <option @if(old('account_type')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
     @endforeach
      @endif
    </select>
    @error('account_type')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group"> 
      <label> <span class="text-red"> *</span>   هل الحساب اب رئيسي </label>
      <select name="is_main" id="is_main" class="form-control">
       <option value="">اختر الحالة</option>
      <option   @if(old('is_main')==1) selected="selected"  @endif value="1"> نعم</option>
       <option @if(old('is_main')==0 and old('is_main')!="" ) selected="selected"   @endif value="0"> لا</option>
      </select>
      @error('is_main')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
    </div>

    <div class="col-md-4" id="parentDiv"  @if(old('is_main')==1||old('is_main')=='')   style="display: none;"  @endif  > 
      <div class="form-group"> 
        <label>   الحساب الأب الرئيسي</label>
        <select name="parent_account_number" id="parent_account_number" class="form-control ">
          <option value="">اختر الحساب الرئيسي الاب</option>
          @if (@isset($parent_accounts) && !@empty($parent_accounts))
         @foreach ($parent_accounts as $info )
           <option @if(old('parent_account_number')==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }} </option>
         @endforeach
          @endif
        </select>
        @error('parent_account_number')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
      </div>
      <div class="col-md-2">   
        <div class="form-group">
          <label>   حالة رصيد اول المدة</label>
          <select name="start_balance_status" id="start_balance_status" class="form-control">
            <option value="">اختر الحالة</option>
           <option   @if(old('start_balance_status')==1) selected="selected"  @endif value="1"> دائن</option>
           <option   @if(old('start_balance_status')==2) selected="selected"  @endif value="2"> مدين</option>
           <option   @if(old('start_balance_status')==3) selected="selected"  @endif value="3"> متزن</option>
           </select>
          @error('start_balance_status')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        </div>
        <div class="col-md-3">   
          <div class="form-group">
            <label> <span class="text-red"> *</span>  رصيد أول المدة للحساب</label>
            <input  name="start_balance" id="start_balance" class="form-control"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');" value="{{ old('start_balance') }}"    >
            @error('start_balance')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          </div>
          <div class="col-md-2">
            <div class="form-group"> 
              <label>  حالة التفعيل</label>
              <select name="active" id="active" class="form-control">
               <option value="">اختر الحالة</option>
              <option   @if(old('active')==1 ) selected="selected"  @endif value="1"> نعم</option>
               <option @if(old('active')==0  and old('active')!="") selected="selected"   @endif value="0"> لا</option>
              </select>
              @error('active')
              <span class="text-danger">{{ $message }}</span>
              @enderror
              </div>
            </div>
          <div class="col-md-4">   
            <div class="form-group">
              <label>   ملاحظات</label>
              <input name="notes" id="notes" class="form-control" value="{{ old('notes') }}"    >
              @error('notes')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>


     
      
      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> اضافة</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
      
      </div>
    </div>
    
  </div>  
            </form>  
        
            

            </div>  

      


        </div>
      </div>
   





@endsection


@section('script')
<script src="{{ asset('assets/js/accounts.js') }}"></script>
@endsection





