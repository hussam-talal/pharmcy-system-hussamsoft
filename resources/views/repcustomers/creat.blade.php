@extends('layouts.minbag')
@section('title')
التقارير
@endsection

@section('contentheader')
تقرير عميل
@endsection
@section('contentheaderlink')
<a href="{{ route('repcustomers.index') }}">  حساب عميل</a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')


      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">     تقرير تفصيلي   </h3>
          
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
          <p>اسم العميل:  {{$name_cus}} </p>
           
        <p> رقم الحساب: {{$account_number}}</p>
        
        <p> التاريخ:</p>
        <label id="date">

       
    <script>
        var today = new Date();
        var date = today.toLocaleDateString();
         document.getElementById("date").innerHTML = date;
    </script>

</label>
          
             @php
           $i=1;   
          @endphp
          @php
           $s=0;   
          @endphp
          
              
          
          @if (@isset($trans) && !@empty($trans))
          
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>مسلسل</th>
           <th>له </th>
           <th>  عليه </th>
         
           <th>   رقم السند </th>
           <th>التاريخ</th>
           <th>البيان</th>
            </thead>
            <tbody>
            @php
              $s=0;
              $m=0;
              @endphp
         @foreach ($trans as $info )
         <tr>
             <td>{{ $i }}</td> 

             @if($info->sales_matrial_types>0)
               <td>لايوجد</td>
             <td>
             
             {{$info->total_cost}}

             @php
           $s=$s+$info->total_cost;
@endphp
             
             </td>
             
             <td>  </td>
    
    <td>{{$info->invoice_date }}</td>  
     <td> مبيعات</td> 
             
          
            

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
           
      
         
         </tr>
           
      @php
         $i++; 
      @endphp
         @endforeach

         
         <td>#</td>
   <td>اجمالي له:{{$s}}</td>
   <td>اجمالي عليه:{{$m}}</td>

   
    <td>المبلغ المستحق@if ($s>$m) له @elseعليه@endif :{{$s-$m}}</td>
            </tbody>
             </table>
             
           
        
      
           
    
             <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('repcustomers.print',[$account_number,'A4',$order_date_form, $order_date_to,$code_cus]) }}" class="btn btn-primary btn-xs">
          <i class="nav-icon fas fa-print"></i>طباعة</a>
        </div>
      </div>
   
      

       
      </div>
        </div>
     
</div>



@else
<div class="alert alert-danger">لاتوجد تفاصيل</div>
@endif

@endsection





