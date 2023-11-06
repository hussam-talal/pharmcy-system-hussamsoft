<div class="row">
    <div class="col-md-4 ">   
      <div class="form-group">
        <label><span class="text-red" >*</span>  اسم  الصنف</label>
        <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الصنف"   >
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      </div>
      <div class="col-md-4 "> 
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
      
      <div class="col-md-4 "> 
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

        <div class="col-md-4 "> 
          <div class="form-group"> 
            <label><span class="text-red" >*</span> الوحدة الرئيسية</label>
            <select name="unit_id" id="unit_id" class="form-control ">
              <option value="">اختر الوحدة الرئيسية</option>
              @if (@isset($units_main) && !@empty($units_main))
             @foreach ($units_main as $info )
               <option @if(old('unit_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
             @endforeach
              @endif
            </select>
            @error('unit_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
          </div>
      
          
            <div class="col-md-4  "   id="retail_uom_idDiv"> 
              <div class="form-group"> 
                <label> <span class="text-red" >*</span>الوحدة التجزئة (<span class="parentunitname"></span>)</label>
                <select name="retail_units_id" id="retail_units_id" class="form-control ">
                  <option value="">اختر الوحدة التجزئة</option>
                  @if (@isset($units_retail) && !@empty($units_retail))
                 @foreach ($units_retail as $info )
                   <option @if(old('retail_units_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                 @endforeach
                  @endif
                </select>
                @error('retail_units_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
              </div>
      
              <div class="col-md-4 "> 
              <div class="form-group">
                <label>عدد وحدات التجزئة  (<span class="childunitname"></span>) بالنسبة للرئيسية(<span class="parentunitname"></span>)  </label>
                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="retail_unit_quntToParent" id="retail_unit_quntToParent" class="form-control"  value="{{ old('retail_unit_quntToParent') }}" placeholder="ادخل  عدد وحدات التجزئة"  >
                @error('retail_unit_quntToParent')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
              </div>
      
              
                <div class="col-md-4  "  > 
                  <div class="form-group">
                    <label> <span class="text-red" >*</span>سعر الوحدة الرئيسية (<span class="parentunitname"></span>)  </label>
                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="price" id="price" class="form-control"  value="{{ old('price') }}" placeholder="ادخل السعر " >
                    @error('price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                  </div>
      
                  <div class="col-md-4  "  > 
                  <div class="form-group">
                    <label>سعر  جملة  (<span class="parentunitname"></span>)  </label>
                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="gomla_price" id="gomla_price" class="form-control"  value="{{ old('gomla_price') }}" placeholder=" ادخل سعر الجملة" >
                    @error('gomla_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                  </div>
                  <div class="col-md-4  " > 
                    <div class="form-group">
                      <label><span class="text-red" >*</span>سعر  تكلفة الشراء لوحدة الرئيسية (<span class="parentunitname"></span>)  </label>
                      <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="cost_price" id="cost_price" class="form-control"  value="{{ old('cost_price') }}" placeholder="ادخل السعر " >
                      @error('cost_price')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                      </div>
                    </div>

      <div class="col-md-6 " style="display: none">
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
                      <button type="button" class="btn btn-sm btn-success" id="AddToItem">اضافة اصناف جديدة </button>
                    </div>
                     </div>
  </div>

   {{-- <div class="col-md-4  relatied_to_itemCard" style="display: none;" id="UomDivAdd">
    
   </div> --}}
  
