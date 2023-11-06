
<div class="form-group"> 
    <label>     وحدة البيع</label>
    <select  id="unit_id" class="form-control select2" style="width: 100%;">
      @if (@isset($item_card_Data) && !@empty($item_card_Data))
    
    <option selected data-ismainunit="1" value="{{ $item_card_Data['unit_id'] }}"> {{ $item_card_Data['main_unit_name']  }} (وحده رئيسية) </option>
    <option  data-ismainunit="0" value="{{ $item_card_Data['retail_units_id'] }}"> {{ $item_card_Data['retial_unit_name']  }} (وحدة تجزئة) </option>
    
    
    @endif
    </select>
   
    </div>