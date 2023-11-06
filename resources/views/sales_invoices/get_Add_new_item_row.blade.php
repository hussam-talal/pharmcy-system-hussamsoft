<tr>
<td>
  {{ $received_data['store_name'] }}
  <input type="hidden" name="store_id_array[]" class="store_id_array" value="{{ $received_data['store_id'] }}">
  <input type="hidden" name="sales_item_type_array[]" class="sales_item_type_array" value="{{ $received_data['sales_item_type'] }}">
  <input type="hidden" name="item_code_array[]" class="item_codearray" value="{{ $received_data['item_code'] }}">
  <input type="hidden" name="uom_id_array[]" class="uom_id_array" value="{{ $received_data['unit_id'] }}">
  <input type="hidden" name="inv_itemcard_batches_id_array[]" class="inv_itemcard_batches_id_array" value="{{ $received_data['items_batches_autoserial'] }}">
  <input type="hidden" name="item_quantity_array[]" class="item_quantity_array" value="{{ $received_data['item_quantity'] }}">
  <input type="hidden" name="item_quantity_array[]" class="item_quantity_array" value="{{ $received_data['item_quantity'] }}">
  <input type="hidden" name="item_price_array[]" class="item_price_array" value="{{ $received_data['item_price'] }}">  <input type="hidden" name="isparentuom_array[]" class="isparentuom_array" value="{{ $received_data['ismainunit'] }}">

<input type="hidden" name="item_total_array[]" class="item_total_array" value="{{ $received_data['item_total'] }}">



</td>
<td>{{ $received_data['sales_item_type_name'] }}</td>
<td>{{ $received_data['item_code_name'] }}</td>
<td>{{ $received_data['unit_id_name'] }}</td>
<td>{{ $received_data['item_price']*1 }}</td>
<td>{{ $received_data['item_quantity']*1 }}</td>
<td>{{ $received_data['item_total']*1 }}</td>
<td>
  <button  class="btn remove_current_row btn-sm btn-danger">حذف</button>  
</td>

</tr>