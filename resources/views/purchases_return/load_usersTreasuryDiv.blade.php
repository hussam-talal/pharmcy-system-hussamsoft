<div class="col-md-3">
    <div class="form-group">
         <label>    خزنة الصرف  </label>
     <select id="treasuries_id" class="form-control">
   @if(!@empty($user_treasurcy))
   <option selected value="{{ $user_treasurcy['treasuries_id']  }}"> {{ $user_treasurcy['name_treasury'] }} </option>
   @else
   <option value=""> عفوا لاتوجد خزنة لديك الان</option>
   @endif

     </select>

    </div>
   </div>
   <div class="col-md-3" > 
    <div class="form-group">
      <label>  الرصيد بالخزنة   </label>
      <input  readonly name="treasuries_balance" id="treasuries_balance" class="form-control" 
      @if(!@empty($user_treasurcy))
       value="{{ $user_treasurcy['balance']*1 }}" 
       @else
       value="0" 
       @endif
       >
      </div>