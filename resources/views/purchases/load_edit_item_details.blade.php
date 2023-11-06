@if(!@empty($reload_main_pill) )

@if($reload_main_pill['is_approved']==0)
@if(!@empty($item_data_detials))
<div class="row">
    <div class="col-md-4">
     <div class="form-group"> 
       <label>   بيانات الاصناف</label>
       <select  id="item_code_add" class="form-control select2" style="width: 100%;">
         <option value="">اختر الصنف</option>
         @if (@isset($item_cards) && !@empty($item_cards))
        @foreach ($item_cards as $info )
          <option @if($item_data_detials['item_code']==$info->item_code) selected="selected" @endif data-type="{{ $info->item_type }}"   value="{{ $info->item_code }}"> {{ $info->name }} </option>
        @endforeach
         @endif
       </select>
       @error('suuplier_code')
       <span class="text-danger">{{ $message }}</span>
       @enderror
       </div>
    </div>
 
    
    <div class="col-md-4 relatied_to_itemCard" >
    <div class="form-group">
     <label> الكمية المستلمة</label>
     <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="quantity_add" class="form-control"  value="{{ $item_data_detials['deliverd_quantity']*1 }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
     </div>
   </div>
   <div class="col-md-4 relatied_to_itemCard" >
     <div class="form-group">
      <label>  سعر الوحدة</label>
      <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="price_add" class="form-control"  value="{{ $item_data_detials['unit_price']*1 }}"   oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
    </div>
 
    <div class="col-md-4 relatied_to_date" @if($item_data_detials['item_card_type']!=2) style="display: none;" @endif>
     <div class="form-group">
      <label>   تاريخ الانتاج</label>
      <input type="date"    id="production_date" class="form-control"  value="{{ $item_data_detials['production_date'] }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
    </div>
 
    <div class="col-md-4 relatied_to_date" @if($item_data_detials['item_card_type']!=2) style="display: none;" @endif>
        <div class="form-group">
      <label>   تاريخ انتهاء الصلاحية</label>
      <input type="date"    id="expire_date" class="form-control"   value="{{ $item_data_detials['expire_date'] }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
    </div>
    <div class="col-md-4 relatied_to_itemCard" >
     <div class="form-group">
      <label>   الاجمالي</label>
      <input   readonly  id="total_add" class="form-control"  value="{{ $item_data_detials['total_price']*1 }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
    </div>
 
    <div class="col-md-12">
     <div class="form-group text-center">
     <button  data-id="{{ $item_data_detials['id'] }}" type="button" class="btn btn-sm btn-danger" id="EditDetailsItem">تعديل للفاتورة</button>
   </div>
    </div>
 
       </div>
 
 








@else
<div class="alert alert-danger">
عفوا غير قادر الي الوصول للبيانات المطلوبة
</div>
      @endif

@else
<div class="alert alert-danger">
عفوا لايمكت تحديث فاتورة معتمدة ومؤرشفة
</div>
      @endif

@else
<div class="alert alert-danger">
عفوا لاتوجد بيانات لعرضها !!
</div>
@endif