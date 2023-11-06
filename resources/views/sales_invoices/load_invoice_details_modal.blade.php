@if (@isset($invoice_data) && !@empty($invoice_data))
@if($invoice_data['is_approved']==0)
@if($counterDetails > 0)

<div class="clearfix"></div>
<hr style="border:1px solid #3c8dbc;">

<form action="{{route("SalesInvoices.DoApproveInvoiceFinally",$invoice_data['auto_serial'])}}" method="POST">
@csrf

<div class="row">
   <div class="col-md-3">
      <div class="form-group">
         <label>اجمالي الاصناف  </label>
         <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_cost_items"  id="total_cost_items" 
            class="form-control"  value="{{ $invoice_data['total_cost_items']*1 }}" >
      </div>
   </div>
    {{-- <div class="col-md-3">
      <div class="form-group">
         <label>     الاجمالي قبل الخصم </label>
         <input readonly    id="total_befor_discount" name="total_befor_discount" class="form-control"  
            value="{{ $invoice_data['total_befor_discount']*1 }}"  >
      </div>
   </div> --}}
   <div class="col-md-3">
      <div class="form-group">
         <label>     نوع الخصم   </label>
         <select class="form-control" name="discount_type" id="discount_type">
            <option value="">لايوجد خصم</option>
            <option  value="1" >    نسبة مئوية</option>
            <option  value="2" > قيمة يدوي</option>
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     نسبة  الخصم </label>
         <input @if($invoice_data['discount_type']=="" || $invoice_data['discount_type']==null) readonly @endif    oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="discount_percent"  id="discount_percent" class="form-control"  value="{{ $invoice_data['discount_percent']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>  قيمة   الخصم   </label>
         <input readonly  name="discount_value"   id="discount_value" class="form-control"  value="{{ $invoice_data['discount_value']*1 }}"  >
      </div>
   </div>
   
</div>

<div class="row" id="shiftDiv">
   <div class="col-md-3">
      <div class="form-group">
         <label>     الاجمالي النهائي     </label>
         <input readonly name="total_cost"   id="total_cost" class="form-control"  value="{{ $invoice_data['total_cost']*1 }}"  >
      </div>
   </div>
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
</div>
<div class="row">
   <div class="col-md-3">
      <div class="form-group">
         <label>     نوع الفاتورة   </label>
         <select class="form-control" name="pill_type" id="pill_type">
            <option value=""   >     اختر نوع الفاتورة</option> 
         <option value="1"   >     كاش</option>
         <option value="2"   >  اجل</option>
         </select>
      </div>
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>    فئات الفواتير</label>
         <select name="Sales_matrial_types_id" id="Sales_matrial_types_id" class="form-control select2">
            <option value="">  اختر فئة الفاتورة</option>
            @if (@isset($Sales_matrial_types) )
            @foreach ($Sales_matrial_types as $info )
            <option @if($invoice_data['sales_matrial_types']==$info->id) selected @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
            @endforeach
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-3 "> 
      <div class="form-group">
      <label>    المحصل  الان   </label>
      <input   name="what_paid" id="what_paid" class="form-control"  @if($invoice_data['pill_type']==1)  readonly  @endif  value="@if($invoice_data['pill_type']==1) {{$invoice_data['total_cost']*1  }} @else 0 @endif"    >
   </div>
   </div>
   <div class="col-md-3" > 
      <div class="form-group">
      <label>    المتبقي تحصيله    </label>
      <input readonly   name="what_remain" id="what_remain" class="form-control"   value="@if($invoice_data['pill_type']==1) 0 @else {{$invoice_data['what_remain']*1  }}  @endif"     >
   </div>
   </div>
   <div class="col-md-6 ">
      <div class="form-group">
         <label>      الملاحظات علي الفاتورة   </label>
         <input  style="background-color: lightgoldenrodyellow"    name="notes" id="notes" class="form-control"   value="{{ $invoice_data['notes'] }}"    >
      </div>
   </div>
   <div class="col-md-6 text-left"> 
      <button type="submit" class="btn btn-sm btn-primary" id="DoApproveInvoiceFinally" style="margin-top:31px;">اعتماد وترحيل الفاتورة</button>
   </div>
</div>
</form> 
  
@else
<div class="alert alert-danger">
   عفوا لايمكن  ترحيل الفاتورة   بدون اي صنف !!!!
</div>
@endif
@endif
@endif