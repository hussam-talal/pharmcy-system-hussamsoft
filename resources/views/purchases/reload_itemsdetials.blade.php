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