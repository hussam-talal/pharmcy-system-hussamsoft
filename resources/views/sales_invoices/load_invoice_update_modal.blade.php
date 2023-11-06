@extends('layouts.minbag')
@section('title')
المبيعات
@endsection
<input type="hidden" id="invoiceautoserial" value="{{ $invoice_data['auto_serial'] }}">

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
فواتير المبيعات 
@endsection
@section('contentheaderlink')
<a href="{{ route('SalesInvoices.index') }}">  المبيعات  </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">     فواتير المبيعات للعملاء  </h3>

      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_get_item_units" value="{{ route('SalesInvoices.get_item_units') }}">
      <input type="hidden" id="ajax_get_load_modal_addMirror" value="{{ route('SalesInvoices.load_modal_addMirror') }}">
      <input type="hidden" id="ajax_get_load_modal_addActiveInvoice" value="{{ route('SalesInvoices.load_modal_addActiveInvoice') }}">
      <input type="hidden" id="ajax_get_item_batches" value="{{ route('SalesInvoices.get_item_batches') }}">
      <input type="hidden" id="ajax_get_item_unit_price" value="{{ route('SalesInvoices.get_item_unit_price') }}">
      <input type="hidden" id="ajax_get_Add_new_item_row" value="{{ route('SalesInvoices.get_Add_new_item_row') }}">
      <input type="hidden" id="ajax_get_store" value="{{ route('SalesInvoices.store') }}">
      <input type="hidden" id="ajax_get_Add_item_to_invoice" value="{{ route('SalesInvoices.Add_item_to_invoice') }}">
      <input type="hidden" id="ajax_reload_main_pill" value="{{ route('SalesInvoices.reload_main_pill') }}">
      <input type="hidden" id="ajax_get_reload_items_in_invoice" value="{{ route('SalesInvoices.reload_items_in_invoice') }}">
      <input type="hidden" id="ajax_get_recalclate_parent_invoice" value="{{ route('SalesInvoices.recalclate_parent_invoice') }}">
      <input type="hidden" id="ajax_get_remove_active_row_item" value="{{ route('SalesInvoices.remove_active_row_item') }}">
      {{-- <input type="hidden" id="ajax_DoApproveInvoiceFinally" value="{{ route('SalesInvoices.DoApproveInvoiceFinally') }}"> --}}
      <input type="hidden" id="ajax_load_usershiftDiv" value="{{ route('SalesInvoices.load_usershiftDiv') }}">
      <input type="hidden" id="ajax_load_invoice_details_modal" value="{{ route('SalesInvoices.load_invoice_details_modal') }}">
      <input type="hidden" id="ajax_do_add_new_customer" value="{{ route('SalesInvoices.do_add_new_customer') }}">
      <input type="hidden" id="ajax_getlastaddedcustomer" value="{{ route('SalesInvoices.get_last_added_customer') }}">
      <input type="hidden" id="ajax_searchforcustomer" value="{{ route('SalesInvoices.searchforcustomer') }}">
      <input type="hidden" id="ajax_searchforitems" value="{{ route('SalesInvoices.searchforitems') }}">
   </div>
{{-- @if($invoice_data['is_approved']==0) --}}

<div class="card-body">
  
<div class="row" id="refresh_main_pill">
   @if (@isset($invoice_data) && !@empty($invoice_data) )
   
   <div class="col-md-3">
      <div class="form-group"> 
         <label>  رقم الفاتورة</label>
         
   <input readonly class="form-control" id="invoiceautoserial" value="{{ $invoice_data['auto_serial'] }}">
</div>
   </div>
   <div class="col-md-3">
      <div class="form-group"> 
         <label>    تاريخ الفاتورة</label>
         
         <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="">
      </div>
   </div>

   <div class="col-md-3" >
      <div class="form-group"> 
       <label>    نوع البيع</label>
       <select name="sales_item_type" id="sales_item_type_main" class="form-control ">
      <option value="1">تجزئة</option>
      <option value="2"> جملة</option>
      
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
             <option  value="{{ $info->id }}"> {{ $info->name }} </option>
           @endforeach
            @endif
          </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <input id="searchforitem" class="form-control" type="text" placeholder="باركود - كود -اسم" >
         <div id="searchforitemresultDiv">
            <select  id="item_code" name="item_code" class="form-control " style="width: 100%;">
               <option value="">اختر الصنف</option>
          @if (@isset($item_cards) && !@empty($item_cards))
            @foreach ($item_cards as $info )
           <option data-item_type="{{ $info->item_type }}"  
              value="{{ $info->item_code }}"> {{ $info->name }} 
            
            </option>
         @endforeach
          @endif
            </select>
         </div>
      </div>
   </div>
     <!--  الوحدات للصنف-->
   <div class="col-md-3  " style="display: none;" id="UomDiv">
   </div>
   <!--   باتشات الكميات بالمخازن-->
   <div class="col-md-4  " style="display: none;" id="inv_itemcard_batchesDiv">
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>    بيانات المخازن</label>
         <select name="store_id" id="store_id" class="form-control ">
            <option value=""> اختر المخزن  </option>
            @if (@isset($stores) && !@empty($stores))
            @php $i=1;  @endphp
            @foreach ($stores as $info )
            <option @if($i==1) selected @endif value="{{ $info->id }}"> {{ $info->name }} </option>
            @php $i++;  @endphp
            @endforeach
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-3  ">
      <div class="form-group">
         <label> الرف</label>
         <input  name="item_price" id="item_raph" class="form-control"  value=""   >
      </div>
   </div>
   <div class="col-md-3  ">
      <div class="form-group">
         <label> الكمية</label>
         <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_quantity" id="item_quantity" class="form-control"  value="1"   >
      </div>
      </div>
      <div class="col-md-3  ">
      <div class="form-group">
         <label> السعر</label>
         <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_price" id="item_price" class="form-control"  value=""   >
      </div>
      </div>
 
   <div class="col-md-3" id="customer_codeDiv" >
       <div class="form-group"> 
         <label>   بيانات العملاء
          (<a id="load_add_new_customer" title=" اضافة عميل جديد " href="#">جديد <i   class="fa fa-plus-circle  "></i> </a>) 
         </label>
         <input type="text" class="form-control" id="searchbytextforcustomer" placeholder="اسم العميل - كود العميل">
       <div id="searchbytextforcustomerDiv">
         <select name="customer_code" id="customer_code" class="form-control ">
            
               <option value=""> لايوجد عميل</option>
               {{-- @if (@isset($customers) && !@empty($customers))
              @foreach ($customers as $info )
                <option @if($invoice_data['customer_code']==$info->customer_code and $invoice_data['is_has_customer']==1) selected @endif  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
              @endforeach
               @endif --}}
             </select>
       </div>
         </div>
       </div>
       <div class="col-md-3" style="display: none">
         <div class="form-group">
            <label>اجمالي   </label>
            <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_price"  id="total_price" 
               class="form-control"  value="0"  >
         </div>
      </div>
      
      @if($invoice_data['is_approved']==0)
     <div class="col-md-2  ">
     <div class="form-group">
      <button style="margin-top:35px" class="btn btn-sm btn-success" id="AddItemToIvoiceDetailsActive"> أضافة </button>  
    </div>
   </div>
   @endif
</div>
@endif

<div class="clearfix"></div>
<hr style="border:1px solid #3c8dbc;">
<div class="row" id="activeItemisInInvoiceDiv">
   <h3 class="card-title card_title_center">       الاصناف المضافة علي الفاتورة  </h3>
   <table id="example2" class="table table-bordered table-hover">
      <thead class="custom_thead">
         <th>المخزن</th>
         <th>نوع البيع</th>
         <th>الصنف</th>
         <th>وحدة البيع</th>
         <th>سعر الوحدة</th>
         <th>الكمية</th>
         <th>الخصم</th>
         <th>الاجمالي</th>
         <th>العمليات</th>
      </thead>
      <tbody id="itemsrowtableContainterBody">
         @if(!@empty($sales_invoices_details))
         @foreach ($sales_invoices_details as $info )
         <tr>
            <td>
               {{ $info->store_name }}
               <input type="hidden" name="item_total_array[]" class="item_total_array" value="{{$info->total_price}}">
            </td>
            <td>
               @if($info->sales_item_type==1) تجزئة   @elseif($info->sales_item_type==2)  جملة @else  لم يحدد @endif
            </td>
            <td>{{ $info->item_name }}</td>
            <td>{{ $info->uom_name }}</td>
            <td>{{ $info->unit_price*1 }}</td>
            <td>{{ $info->quantity*1 }}</td>
            <td>{{ 0*1 }}</td>

            <td>{{ $info->total_price*1 }}</td>
            <td>
               <button  data-id="{{ $info->id }}" class="btn remove_active_row_item are_you_shue btn-sm btn-danger">حذف</button>  
            </td>
         </tr>
         @endforeach
         @endif
      </tbody>
   </table>
   <div class="col-md-3">
      <div class="form-group">
         <label>اجمالي الاصناف  </label>
         <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_cost_items"  id="total_cost_items" 
            class="form-control"  value="{{ $invoice_data['total_cost_items']*1 }}"  >
      </div>
   </div>
   
   
</div>
@if($invoice_data['is_approved']==0)
<div class="row">
<div class="col-md-12">
   <div class="form-group text-center">
      <button type="button" style="margin:center" class="btn btn-sm btn-info" id="approveToIvoiceDetailsActive"> حفظ وترحيل </button>  
   </div>
</div>
</div>
@endif

<div class="modal fade " id="approve_invoice_Modal">
   <div class="modal-dialog modal-xl" >
     <div class="modal-content bg-info">
       <div class="modal-header">
         <h4 class="modal-title"> حفظ فاتورة المبيعات</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span></button>
       </div>
       <div class="modal-body" id="approve_invoice_Modal_body" style="background-color: white !important; color:black;">
    

       </div>
       <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 <!-- /.modal -->

@endsection
@section("script")
<script src="{{ asset('assets/js/sales_invoices.js') }}"></script>
<script  src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection
{{-- @else
<div class="alert alert-danger">
   عفوا لايمكن التعديل علي فاتورة معتمده وتم ترحيلها !!!!
</div>
@endif --}}