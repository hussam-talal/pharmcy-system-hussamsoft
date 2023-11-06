@extends('layouts.minbag')
@section('title')
مرتجع المشتريات العام
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('purchasesreturn.index') }}">  فواتير مرتجع المشتريات العام </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تفاصيل فاتورة مرتجع مشتريات عام  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div id="ajax_responce_serarchDivparentpill">
            <div class="row">
              {{-- @if (@isset($data) && !@empty($data) ) --}}
              <div class="col-md-3">
                <div class="form-group"> 
                   <label>  رقم الفاتورة</label>
                   
             <input readonly class="form-control" id="autoserial" value="{{ $data['auto_serial'] }}">
          </div>
             </div>
            <div class="col-3">
            <div class="form-group">
              <label>  تاريخ الفاتورة</label>
              <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
              @error('notes')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>
            
            <div class="col-3">
              <div class="form-group"> 
                <label>   بيانات الموردين</label>
                <select name="suuplier_code" id="suuplier_code" class="form-control select2">
                  <option value="">اختر المورد</option>
                  @if (@isset($suuplier) && !@empty($suuplier))
                 @foreach ($suuplier as $info )
                   <option @if(old('suuplier_code')==$info->suuplier_code) selected="selected" @endif value="{{ $info->suuplier_code }}"> {{ $info->name }} </option>
                 @endforeach
                  @endif
                </select>
                @error('suuplier_code')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>

      <div class="col-3">
      <div class="form-group"> 
        <label>     المخازن</label>
        <select name="store_id" id="store_id" class="form-control select2">
          <option value=""> اختر   مخزن صرف المرتجع</option>
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
            </div>

     <!--  treasuries_delivery   -->
     <div class="card-header">
        <h3 class="card-title card_title_center">
        الاصناف المضافة للفاتورة
        @if($data['is_approved']==0)
        <button type="button" class="btn btn-info" id="load_modal_add_detailsBtn">
          اضافة صنف للفاتورة
        </button>
       @endif
        </h3>
        <input type="hidden" id="token_search" value="{{csrf_token() }}">
        <input type="hidden" id="ajax_get_item_uoms_url" value="{{ route('purchasesreturn.get_item_units') }}">
        <input type="hidden" id="ajax_Add_item_to_invoice" value="{{ route('purchasesreturn.Add_item_to_invoice') }}">
        <input type="hidden" id="ajax_reload_itemsdetials" value="{{ route('purchasesreturn.reload_itemsdetials') }}">
        {{-- <input type="hidden" id="ajax_reload_parent_pill" value="{{ route('purchasesreturn.reload_parent_pill') }}"> --}}
        <input type="hidden" id="ajax_load_edit_item_details" value="{{ route('purchasesreturn.load_edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_add_details" value="{{ route('purchasesreturn.load_modal_add_details') }}">
        <input type="hidden" id="ajax_edit_item_details" value="{{ route('purchasesreturn.edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_approve_invoice" value="{{ route('purchasesreturn.load_modal_approve_invoice') }}">
        <input type="hidden" id="ajax_load_TreasuryDiv" value="{{ route('purchasesreturn.load_usersTreasuryDiv') }}">
        <input type="hidden" id="ajax_get_item_batches" value="{{ route('purchasesreturn.get_item_batches') }}">
        <input type="hidden" id="autoserail" value="{{ $data['auto_serial'] }}">


     </div>
    </div>
     <div id="ajax_responce_serarchDivDetails">
          
        @if (@isset($details) && !@empty($details) && count($details)>0)
        @php
         $i=1;   
        @endphp
        
        <table id="example2" class="table table-bordered table-hover">
          <thead class="custom_thead">
         <th>مسلسل</th>
         <th>الصنف </th>
         <th> الوحده</th>
         <th> الكمية</th>
         <th> السعر</th>
         <th> الاجمالي</th>

         <th></th>
          </thead>
          <tbody>
       @foreach ($details as $info )
          <tr>
           <td>{{ $i }}</td>  
         <td>{{ $info->item_card_name }}
        @if($info->item_card_type==2)
        <br>
        تاريخ انتاج  {{ $info->production_date }} <br>

        تاريخ انتهاء  {{ $info->expire_date }} <br>
      باتش رقم {{ $info->batch_auto_serial }}

        @endif
        
        
        </td>
         <td>{{ $info->unit_name }}</td>
         <td>{{ $info->deliverd_quantity*(1) }}</td>
         <td>{{ $info->unit_price*(1) }}</td>
         <td>{{ $info->total_price*(1) }}</td>
    
         <td>
       @if($data['is_approved']==0)

       <a href="{{ route('purchasesreturn.delete_details',["id"=>$info->id,"id_parent"=>$data['id']]) }}" class="btn btn-sm are_you_shue   btn-danger">حذف</a> 
       <button data-id="{{ $info->id }}" class="btn btn-sm load_edit_item_details  btn-primary">
        <i class="nav-icon fas fa-edit"></i> تعديل</button> 
       <a href="{{ route('purchasesreturn.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a> 


       @endif

         </td>

         
 
         </tr> 
    @php
       $i++; 
    @endphp
       @endforeach
 
 
 
          </tbody>
           </table>

           <div class="row">
            <div class="col-md-12">
               <div class="form-group text-center">
                @if($data['is_approved']==0)
                
                <button id="load_close_approve_invoice"  class="btn btn-md btn-primary"> ترحيل</button>
                
                @endif              
               </div>
            </div>
            </div>

           
   
     
         @else
         <div class="alert alert-danger">
           عفوا لاتوجد بيانات لعرضها !!
         </div>
               @endif

      </div>
    



    <!--  End treasuries_delivery   -->



     
      


        </div>
      </div>
   


<div class="modal fade " id="Add_item_Modal">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">اضافة اصناف للفاتورة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="Add_item_Modal_body" style="background-color: white !important; color:black;">
    
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


<div class="modal fade " id="edit_item_Modal">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title text-center">تحديث صنف  بالفاتورة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="edit_item_Modal_body" style="background-color: white !important; color:black;">
     


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade " id="ModalApproveInvocie">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title" style="text-align: center">  اعتماد وترحيل فاتورة مرتجع مشتريات عام</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="ModalApproveInvocie_body" style="background-color: white !important; color:black;">
    


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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

<script  src="{{ asset('assets/js/purchases_general_return.js') }}"> </script>


@endsection





