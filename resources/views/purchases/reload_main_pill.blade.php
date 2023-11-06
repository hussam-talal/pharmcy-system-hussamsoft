@if (@isset($data) && !@empty($data))
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
<a href="{{ route('purchases.delete',$data['id']) }}" class="btn btn-md are_you_shue  btn-danger m-1">حذف</a>   
<a href="{{ route('purchases.edit',$data['id']) }}" class="btn btn-md btn-success">تعديل</a>

@endif
</div>


  @else
  <div class="alert alert-danger">
    عفوا لاتوجد بيانات لعرضها !!
  </div>
        @endif
  