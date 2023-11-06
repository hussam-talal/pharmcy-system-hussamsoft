
           
        
                <div class="clearfix"></div>
                <hr style="border:1px solid #3c8dbc;">  
                <div class="row">
                  <div class="col-md-3" >
                  <div class="form-group"> 
                    <label>    بيانات المخازن</label>
                    <select name="store_id" id="store_id" class="form-control ">
                      <option value=""> اختر المخزن  </option>
                      @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                       <option value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                      @endif
                    </select>
                 
                    </div>
                  </div>

                  <div class="col-md-3" >
                    <div class="form-group"> 
                     <label>    نوع البيع</label>
                     <select name="sales_item_type" id="sales_item_type" class="form-control ">
                    <option value="1">تجزئة</option>
                    <option value="2"> جملة</option>
                  </select>
                     </div>
                   </div>
                   <div class="col-md-3">
                    <div class="form-group"> 
                      <label>   بيانات الاصناف</label>
                      <select  id="item_code" class="form-control select2" style="width: 100%;">
                        <option value="">اختر الصنف</option>
                        @if (@isset($item_cards) && !@empty($item_cards))
                       @foreach ($item_cards as $info )
                         <option data-item_type="{{ $info->item_type }}"  
                            value="{{ $info->item_code }}"> {{ $info->name }} 
                          </option>
                       @endforeach
                        @endif
                      </select>
                      @error('suuplier_code')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                      </div>
                   </div>
                   
              <!--  الوحدات للصنف-->
                   <div class="col-md-3  " style="display: none;" id="UomDiv">
    
                  </div>
  <!--   باتشات الكميات بالمخازن-->
  <div class="col-md-4  " style="display: none;" id="inv_itemcard_batchesDiv"> </div>

                  <div class="col-md-3  ">
                  <div class="form-group">
                    <label> الكمية</label>
                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_quantity" id="item_quantity" class="form-control"  value="1"   >
                    </div>
                  </div>
                    <div class="col-md-3 ">
                    <div class="form-group">
                      <label> السعر</label>
                      <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_price" id="item_price" class="form-control"  value=""   >
                      </div>
                    </div>
                      <div class="col-md-3">
                      <div class="form-group">
                        <label> الاجمالي</label>
                        <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_total" id="total_price" class="form-control"  value=""   >
                        </div>
                      </div>
                        <div class="col-md-2">
                        <div class="form-group">
                      <button style="margin-top:35px" class="btn btn-sm btn-danger" id="AddItemToIvoiceDetailsRow">أضف للفاتورة</button>  
                          </div>
                  </div> 
                </div>
                  <div class="clearfix"></div>
                  <hr style="border:1px solid #3c8dbc;">  
                  <div class="row">
                    <h3 class="card-title card_title_center">       الاصناف المضافة علي الفاتورة  </h3>

                    <table id="example2" class="table table-bordered table-hover">
                      <thead class="custom_thead"> 
                        <th>المخزن</th>
                        <th>نوع البيع</th>
                        <th>الصنف</th>
                        <th>وحدة البيع</th>
                        <th>سعر الوحدة</th>
                        <th>الكمية</th>
                        <th>الاجمالي</th>
                        <th>العمليات</th>
                      </thead>
                      <tbody id="itemsrowtableContainterBody">

                      </tbody>

                    </table>

                  </div>
                  <div class="clearfix"></div>
                  <hr style="border:1px solid #3c8dbc;">  
<div class="row">
  <div class="col-md-3">
  <div class="form-group">
        <label>اجمالي الاصناف  </label>
        <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_cost_items"  id="total_cost_items" 
        class="form-control"  value=""  >
   </div>
  </div>
 
  <div class="col-md-2">
   <div class="form-group">
        <label>     نوع الخصم   </label>
        <select class="form-control" name="discount_type" id="discount_type">
        <option value="">لايوجد خصم</option>
        <option value="1" >    نسبة مئوية</option>
        <option value="2" > قيمة يدوي</option>
        </select>
   </div>
  </div>
  <div class="col-md-2">
   <div class="form-group">
        <label>  نسبة  الخصم </label>
        <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="discount_percent"  id="discount_percent" class="form-control"  value="0"  >
   </div>
  </div>
  <div class="col-md-2">
   <div class="form-group">
        <label>  قيمة   الخصم   </label>
        <input readonly  name="discount_value"   id="discount_value" class="form-control"  value="0"  >
   </div>
  </div>
  <div class="col-md-3">
   <div class="form-group">
        <label>     الاجمالي النهائي       </label>
        <input readonly name="total_cost"    id="total_cost" class="form-control"  value="0"  >
   </div>
  </div>
  </div>
  
  <div class="row" id="shiftDiv">
       <div class="col-md-3">
            <div class="form-group">
                 <label>    خزنة التحصيل  </label>
             <select id="treasuries_id" name="treasuries_id" class="form-control">
           @if(!@empty($user_treasuries))
           <option selected value="{{ $user_treasuries['treasuries_id']  }}"> {{ $user_treasuries['name_treasury'] }} </option>
           @else
           <option value=""> عفوا لاتوجد خزنة لديك الان</option>
           @endif
             </select>
            </div>
           </div>
           <div class="col-md-3" > 
            <div class="form-group">
              <label>  الرصيد المتاح بالخزنة   </label>
              <input  readonly name="treasuries_balance" id="treasuries_balance" class="form-control" 
              @if(!@empty($user_treasuries))
               value="{{ $user_treasuries['balance']*1 }}" 
               @else
               value="0" 
               @endif
               >
              </div>
  </div>
  <div class="row">
  
         <div class="col-md-3">
            <div class="form-group">
                 <label>     نوع الفاتورة   </label>
                 <select class="form-control" name="pill_type" id="pill_type">
                 <option value="1"  >     كاش</option>
                 <option value="2" >  اجل</option>
                 </select>
            </div>
           </div>
           <div class="col-md-3 > 
            <div class="form-group">
              <label>    المحصل  الان   </label>
              <input   name="what_paid" id="what_paid" class="form-control"   value="0"    >
              </div>
  
              <div class="col-md-3 > 
                 <div class="form-group">
                   <label>    المتبقي تحصيله    </label>
                   <input readonly   name="what_remain" id="what_remain" class="form-control"   value="0"    >
                   </div>
                   <div class="col-md-6 "> 
                    <div class="form-group">
                      <label>      الملاحظات علي الفاتورة   </label>
                      <input  style="background-color: lightgoldenrodyellow"  name="notes" id="notes" class="form-control"   value=""    >
                      </div>
                   <div class="col-md-12 text-center" > 
                      <hr>
                      <button type="submit" id="Do_Add_invoice"  class="btn btn-md btn-success"> طباعة عرض الاسعار</button>
  
                      </div>
  </div>
</div>
  
              
              
