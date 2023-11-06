@extends('layouts.minbag')
@section('title')
المشتريات
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
مشتريات
@endsection
@section('contentheaderlink')
<a href="{{ route('purchases.index') }}">  فواتير المشتريات </a>
@endsection
@section('contentheaderactive')
عرض التفاصيل
@endsection
@section('content')



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تفاصيل فاتورة المشتريات  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div id="ajax_responce_serarchDivparentpill">
        @if (@isset($data) && !@empty($data))
        
        {{-- <table id="example2" class="table table-bordered table-hover"> --}}
         <div class="row">
            <div class="col-2" >
                <div class="form-group" >
                  <label for="">  رقم الفاتورة </label>
                 <input readonly  class="form-control" value="{{ $data['auto_serial'] }}"> 
                </div>
              </div>  
            
                <div class="col-2" > 
                  <div class="form-group" > 
                 <Label >   رقم فاتورة المشتريات </Label>
                 <input readonly  class="form-control" value="{{ $data['DOC_NO'] }}"> 
                 
              </div>
            </div>

              <div class="col-3" >
                <div class="form-group" >
                <label for="">   المخزن المستلم للفاتورة </label>
                <input readonly  class="form-control" value="{{ $data['store_name'] }}"> 
                </div>
              </div>

              <div class="col-2">
                <div class="form-group">
                <label for="" >   تاريخ الفاتورة  </label>
                <input readonly  class="form-control" value="{{ $data['order_date'] }}"> 
                </div>
              </div>
            
                <div class="col-3">
                  <div class="form-group">
                  <label for="" >   المورد  </label>
                  <input readonly  class="form-control" value="{{ $data['supplier_name'] }}"> 
                  </div>
              </div>
            
                <div class="col-2" >
                  <div class="form-group" >
                  <label for="" > نوع الفاتورة</label>
                 @if($data['pill_type']==1) 
                 <input readonly  class="form-control" value="كاش"> 
                   @else 
                   <input readonly  class="form-control" value="اجل"> 
                   @endif
              </div> 
                </div>
        
          {{-- @if ($data['discount_type']!=null)
            
            <div  class="col-3 ">
              <div  class="form-group ">
              <label for=""> الخصم علي الفاتورة </label>
             
              @if ($data['discount_type']==1)
              <input readonly  class="form-control" value="خصم نسبة ( {{ $data['discount_percent']*1 }} ) وقيمتها ( {{ $data["discount_value"]*1 }} )"> 
          
              @else
              <input readonly  class="form-control" value=" خصم يدوي وقيمته( {{ $data["discount_value"]*1 }} )"> 
     
              @endif
            </div>
            </div>
          @else
          <div  class="col-3 ">
            <div  class="form-group">
            <label for="">    الخصم علي الفاتورة </label>
            <input readonly  class="form-control" value=" لايوجد"> 
 
              </div>
          </div>
          @endif
            
        
            <div class="col-4">
              <div class="form-group">
              <label for="" >    نسبة القيمة المضافة </label>  
            
            @if($data['tax_percent']>0)
            <input readonly  class="form-control" value=" لايوجد"> 
            @else
            <input readonly  class="form-control" value="  بنسبة ({{ $data["tax_percent"]*1 }}) %  وقيمتها ( {{ $data['tax_value']*1 }} )"> 

            @endif
            
            </div> 
          </div> --}}
          

          <div class="col-2">
          <div class="form-group">
            <label for="">       حالة الفاتورة </label><br>
           @if($data['is_approved']==1) 
           <input readonly  class="form-control" value=" مغلق ومؤرشف "> 

            @else 
            <input readonly  class="form-control" value=" مفتوحة"> 

            @endif
      
          </div>
          </div>
           
            
          <div class="col-4">
            <div class="form-group">
            <label for="" >  تاريخ  الاضافة</label> 

    @php
   $dt=new DateTime($data['created_at']);
   $date=$dt->format("Y-m-d");
   $time=$dt->format("h:i");
   $newDateTime=date("A",strtotime($time));
   $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
    @endphp
  <input readonly  class="form-control" value=" {{ $date }}
  {{ $time }}
  {{ $newDateTimeType }}
  بواسطة 
  {{ $data['added_by_admin'] }}"> 



      </div>
          </div>
     
      {{-- <div class="col-3 " colspan="2">
      <label for="" >  تاريخ اخر تحديث</label><br>
      
       @if($data['updated_by']>0 and $data['updated_by']!=null )
    @php
   $dt=new DateTime($data['updated_at']);
   $date=$dt->format("Y-m-d");
   $time=$dt->format("h:i");
   $newDateTime=date("A",strtotime($time));
   $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
    @endphp
{{ $date }}
{{ $time }}
{{ $newDateTimeType }}
بواسطة 
{{ $data['updated_by_admin'] }}



     @else
لايوجد تحديث
       @endif
      </div>
    
                --}}
           
{{-- </table> --}}
</div>
<div class="text-center">

  @if($data['is_approved']==0)
<a href="{{ route('purchases.delete',$data['id']) }}" class="btn btn-md are_you_shue  btn-danger m-1">
  <i class="nav-icon fas fa-trash"></i>حذف</a>   
<a href="{{ route('purchases.edit',$data['id']) }}" class="btn btn-md btn-success">
  <i class="nav-icon fas fa-edit"></i>تعديل</a> 

@endif
</div>
      

        </div>

     <!--  treasuries_delivery   -->



     <div class="card-header">
      @if($data['is_approved']==0)
      <button type="button" class="btn btn-info" id="load_modal_add_detailsBtn">
        اضافة صنف للفاتورة
      </button>
     @endif
        <h3 class="card-title card_title_center">
        الاصناف المضافة للفاتورة
       
        </h3>
        {{-- <button type="button" class="btn btn-success mr-auto" id="modal_add_items_newBtn" >اضافة صنف جديد</a> --}}

        <input type="hidden" id="token_search" value="{{csrf_token() }}">
        <input type="hidden" id="ajax_add_items_new_url" value="{{ route('purchases.add_items_new') }}">
        <input type="hidden" id="ajax_add_items_new_items" value="{{ route('purchases.add_items_new_items') }}">
        
        {{-- <input type="hidden" id="ajax_get_item_units_url" value="{{ route('purchases.get_item_units') }}"> --}}
        <input type="hidden" id="ajax_add_new_details" value="{{ route('purchases.add_new_details') }}">
        <input type="hidden" id="ajax_reload_itemsdetials" value="{{ route('purchases.reload_itemsdetials') }}">
        <input type="hidden" id="ajax_reload_main_pill" value="{{ route('purchases.reload_main_pill') }}">
        <input type="hidden" id="ajax_load_edit_item_details" value="{{ route('purchases.load_edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_add_details" value="{{ route('purchases.load_modal_add_details') }}">
        <input type="hidden" id="ajax_edit_item_details" value="{{ route('purchases.edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_approve_invoice" value="{{ route('purchases.load_modal_approve_invoice') }}">
        <input type="hidden" id="ajax_load_userTreasuryDiv" value="{{ route('purchases.load_userTreasuryDiv') }}">

     
        <input type="hidden" id="autoserailmain" value="{{ $data['auto_serial'] }}">




    </div>
     <div id="ajax_responce_serarchDivDetails">
          
        @if (@isset($details) && !@empty($details) && count($details)>0)
        @php
         $i=1;   
        @endphp
        
        <table id="example2" class="table table-bordered table-hover">
          <thead class="custom_thead ">
         <th>الرقم</th>
         <th>الصنف </th>
         <th> الوحده</th>
         <th> الكمية</th>
         <th> السعر</th>
         <th> تاريخ انتاج</th>
         <th> تاريخ انتهاء</th>
         <th> الاجمالي</th>

         <th>العمليات</th>
          </thead>
          <tbody>
       @foreach ($details as $info )
          <tr>
           <td>{{ $i }}</td>  
         <td>{{ $info->item_card_name }}</td>
    
         <td>{{ $info->unit_name }}</td>
         <td>{{ $info->deliverd_quantity*(1) }}</td>
         <td>{{ $info->unit_price*(1) }}</td>

         @if($info->item_card_type==2)
         <td>{{ $info->production_date }}</td>
         <td>{{ $info->expire_date}}</td>
         @endif
         <td>{{ $info->total_price*(1) }}</td>
    
         <td>
       @if($data['is_approved']==0)

       <button data-id="{{ $info->id }}" class="btn btn-sm load_edit_item_details  btn-primary">
         <i class="nav-icon fas fa-edit"></i> تعديل</button>   
       <a href="{{ route('purchases.delete_details',["id"=>$info->id,"main_id"=>$data['id']]) }}" class="btn btn-sm are_you_shue btn-danger">
        <i class="nav-icon fas fa-trash"></i>حذف</a>   
     


       @endif

         </td>

         
 
         </tr> 
    @php
       $i++; 
    @endphp
       @endforeach
 
 
 
          </tbody>
           </table>

           <div class="row p-1">
            <label style="margin-right:auto;margin-left:;padding:5px " for="">الاجمالي:</label>
            <input readonly class="border border-info bg-secondary rounded p-2" name="total_very_all" id="total_very_all" value="{{ $data['total_befor_discount']*(1) }}">
           </div>
           <div class="text-center">

            @if($data['is_approved']==0)
          <button id="load_close_approve_invoice"  class="btn btn-sm btn-primary">تحميل الاعتماد والترحيل</button>
          
          @endif
          </div>

     
         @else
         <table id="example3" class="table table-bordered table-hover">
          <thead class="custom_thead">
         <th>الرقم</th>
         <th>الصنف </th>
         <th> الوحده</th>
         <th> الكمية</th>
         <th> السعر</th>
         <th> تاريخ انتاج</th>
         <th> تاريخ انتهاء</th>
         <th> الاجمالي</th>

         <th>العمليات</th>
          </thead>
          <tbody>
     
          <tr>
           <td></td>  
         <td></td>
         <td></td>
         <td></td>
         <td></td>

       <td></td>
       <td></td>
       
         <td></td>
    
         <td></td>
 
         </tr> 
  
 
          </tbody>
           </table>
        
         <div class="alert alert-danger">
           عفوا لاتوجد بيانات لعرضها !!
         </div>

         
         <div  class="row p-1" >
          <label style="margin-right:auto;margin-left:;"  for="">الاجمالي</label>:
          <input readonly class="border border-info bg-secondary rounded p-2" name="total_very_all" id="total_very_all" value="{{ $data['total_befor_discount']*(1) }}">
         </div>
        
        <div class="text-center">

          @if($data['is_approved']==0)
        <button id="load_close_approve_invoice"  class="btn btn-md btn-primary">تحميل الاعتماد والترحيل</button>
        
        @endif
        </div>
               @endif

              </div>

    <!--  End treasuries_delivery   -->



        @else
  <div class="alert alert-danger">
    عفوا لاتوجد بيانات لعرضها !!
  </div>
        @endif
      


        </div>
      </div>
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



<div class="modal fade mt-5 mb-0" id="Add_items_new_Modal">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-success ">
      <div class="modal-header p-1">
        <h4 class="modal-title text-lg">اضافة اصناف جديدة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="Add_items_new_Modal_body" style="background-color: white !important; color:black;">
    

      </div>
      <div class="modal-footer p-2 justify-content-between">
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
        <h4 class="modal-title" style="text-align: center">  اعتماد وترحيل فاتورة المشتريات</h4>
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

<script  src="{{ asset('assets/js/purchases.js') }}"> </script>


@endsection





