<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>طباعة  تقرير </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
      <style>
         td{font-size: 15px !important;text-align: center;}
 
      </style>

   <body style="padding-top: 10px;font-family: tahoma;">
      <table  cellspacing="0" style="width: 30%; margin-right: 5px; float: right;  border: 1px dashed black "  dir="rtl">
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> كود المورد 
               <span style="margin-right: 10px;">/ {{ $data["suuplier_code"] }}</span>
           
            </td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> اسم المورد  <span style="margin-right: 10px;">/ {{ $data['supplier_name'] }}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">  رقم التيلفون  <span style="margin-right: 10px;">/ {{ $data['supplier_phone']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   تاريخ   <span style="margin-right: 10px;" >/ @php echo date("Y-m-d"); @endphp </span></td>
         </tr>
         <tr>
         </tr>
         <tr>
         </tr>
      </table>
      <br>
      <table style="width: 30%;float: right;  margin-right: 5px;" dir="rtl">
         <tr>
            <td style="text-align: center;padding: 5px;">  <span style=" display: inline-block;
               width: 200px;
               height: 30px;
               text-align: center;
               background: yellow !important;
               border: 1px solid black; border-radius: 15px;font-weight: bold;"> كشف حساب مورد </span></td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;">  <span style=" display: inline-block;
               width: 200px;
               height: 30px;
               text-align: center;
               color: red;
               border: 1px solid black; "> رقم : {{ $data['auto_serial'] }} </span></td>
         </tr>
         <tr>
          
         </tr>
      </table>
      {{-- <table style="width: 35%;float: right; margin-left: 5px; " dir="rtl">
         <tr>
            <td style="text-align:left !important;padding: 5px;">
               <img style="width: 150px; height: 110px; border-radius: 10px;" src="{{ asset('assets/uploads').'/'.$systemData['photo'] }}"> 
               <p>{{ $systemData['system_name'] }}</p>
            </td>
         </tr>
      </table> --}}
 <div class="clearfix"></div>
 <p></p>
      <table  dir="rtl" border="1" style="width: 98%;  auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr style="background-color: gainsboro">
            <td style="font-weight: bold;">م</td>
            <td style="font-weight: bold;">له</td>
            <td  style="font-weight: bold;">عليه</td>
            <td  style="font-weight: bold;">رقم الايصال </td>
            <td style="font-weight: bold;">تاريخ</td>
            <td  style="font-weight: bold;">بيان</td>
            
         </tr>
         @if(!@empty($details) and count($details)>0)
         @php $i=1; @endphp
         @php
              $s=0;
              $m=0;
              @endphp
         @foreach($details as $info)
         <tr>
             <td>{{ $i }}</td>
             @if($info->order_type==1||$info->order_type==3)
             @if($info->order_type==1) 
             <td>
             
             {{$info->total_cost}}

             @php
           $s=$s+$info->total_cost;
@endphp
             
             </td>
             <td>لايوجد</td>
             <td>{{$info->DOC_NO}}</td>
    
    <td>{{$info->order_date }}</td>  
     <td> مشتريات</td> 
             @else
             <td>لايوجد</td>
            <td> 
              {{$info->total_cost}} 
              @php
           $m=$m+$info->total_cost;
@endphp
           
            </td> 
            
            <td>{{$info->DOC_NO}}</td>
    
            <td>{{$info->order_date }}</td>  
             <td>مرتجع مشتريات</td> 
            @endif

            @else


            @if($info->money_for_account<0)
            <td>{{$info->money_for_account*(-1)}}</td>
            @php
           $s=$s+$info->money_for_account;
@endphp
            <td>لايوجد</td>
          @else
          td>لايوجد</td>
          <td>{{$info->money_for_account}}</td>
          @php
           $m=$m+$info->money_for_account;
@endphp
          @endif
        <td> {{ $info->isal_number }}</td>  
             
             <td>{{$info->move_date }}</td>  
             <td>{{$info->byan}}</td> 
            
          
          @endif
           
      @php
         $i++; 
      @endphp
         @endforeach
         </tr>
         <td>#</td>
         <td>اجمالي له:{{$s}}</td>
   <td>اجمالي عليه:{{$m}}</td>
   <td>المبلغ     المستحق:   @if ($s>$m) له @else  عليه @endif :{{$s-$m}} </td>
         @endif
      </table>
      
      <br>
      <!-- <table  dir="rtl" border="1" style="width: 98%; margin: 0 auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr >
            <td style="font-weight: bold;">اجمالي الفاتورة</td>
            <td style="font-weight: bold;">خصم</td>
            <td style="font-weight: bold;">قيمة مضافة</td>
            <td style="font-weight: bold;">صافي الفاتورة </td>
            <td style="font-weight: bold;">مدفوع</td>
            <td  style="font-weight: bold;">متبقي</td>
         </tr>
         <tr>
            <td>{{ $data["total_befor_discount"]*(1)}}</td>
            <td>{{$data['discount_value']*(1)}}</td>
            <td>{{$data['tax_value']*(1)}}</td>
            <td>{{$data['total_cost']*(1)}}</td>
            <td>{{$data['what_paid']*(1)}}</td>
            <td>{{$data['what_remain']*(1)}}</td>
         </tr>
      </table> -->
      <p style="position: fixed;
         padding: 10px 10px 0px 10px;
         bottom: 0;
         width: 100%;
         /* Height of the footer*/ 
         text-align: center;font-size: 16px; font-weight: bold;
         "> {{ $systemData['address'] }} - {{ $systemData['phone'] }} </p> 
      <script>
         window.print();
           
      </script> 
   </body>
</html>