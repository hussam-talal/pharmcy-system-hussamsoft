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
    <button  data-id="{{ $info->id }}" class="btn are_you_shue remove_active_row_item btn-sm btn-danger">حذف</button>  
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
