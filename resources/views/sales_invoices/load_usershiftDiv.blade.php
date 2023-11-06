<div class="col-md-3">
  <div class="form-group">
     <label>     الاجمالي النهائي     </label>
     <input readonly name="total_cost"   id="total_cost" class="form-control"  value="{{ $invoice_data['total_cost']*1 }}"  >
  </div>
</div>

<div class="col-md-3">
    <div class="form-group">
         <label>    خزنة التحصيل  </label>
     <select id="treasuries_id" class="form-control">
   @if(!@empty($user_treasuries))
   <option selected value="{{ $user_treasuries['treasuries_id']  }}"> {{ $user_treasuries['name_treasury'] }} </option>
   @else
   <option value=""> عفوا لاتوجد خزنة لديك الان</option>
   @endif

     </select>

    </div>
   </div>
   <div class="col-md-3 > 
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