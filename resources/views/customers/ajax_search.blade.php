
          @if (@isset($data) && !@empty($data) && count($data)>0)
   
          @if($mirror['searchByBalanceStatus']!=3)
          <table style="width: 95%; margin: 0 auto;" id="example2" class="table table-bordered table-hover">
            <thead style="background-color: gray" class="custom_thead">
         
              @if($mirror['searchByBalanceStatus']==2)
              <th>اجمالي المستحق تحصيله من العملاء</th>

              @elseif($mirror['searchByBalanceStatus']==1)
              <th>اجمالي المتسحق ارجاعه  للعملاء</th>

             @else
             <th>اجمالي المستحق تحصيله من العملاء</th>
             <th>اجمالي المتسحق ارجاعه  للعملاء</th>
             <th>   الصافي</th>
             @endif

           
       
         

          </thead>
            <tbody>
        <tr>
          
          @if($mirror['searchByBalanceStatus']==2)
          <td>{{ $mirror['debit_sum']*1 }} ريال</td>

          @elseif($mirror['searchByBalanceStatus']==1)
          <td>{{ $mirror['credit_sum']*1*(-1) }} ريال </td>

         @else
         <td>{{ $mirror['debit_sum']*1 }} ريال</td>
         <td>{{ $mirror['credit_sum']*1*(-1) }} ريال</td>
         <td>
          @if($mirror['net']>0)
          مبلغ مستحق علي العملاء بقمية ({{ $mirror['net']*1 }} ريال) 
          @elseif($mirror['net']< 0)
          مبلغ مستحق  للعملاء بقمية ({{ $mirror['net']*1*(-1) }} ريال)

          @else
اتزان (0)
          @endif


        </td>
         @endif

        </tr>
            </tbody>
          </table>

          @endif
          <hr>
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
        
           <th>الاسم </th>
           <th>  الكود </th>
           <th> رقم الحساب </th>
           <th>  الرصيد </th>
           <th>  العنوان </th>
           <th>  الهاتف </th>

           <th>  ملاحظات </th>

           <th> التفعيل</th>
          <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
           
             <td>{{ $info->name }}</td>  
             <td>{{ $info->customer_code }}</td>  

             
             <td>{{ $info->account_number }}</td>  
             <td> 
           
            @if($info->current_balance >0)
            مدين ب ({{ $info->current_balance*1 }}) ريال  
            @elseif ($info->current_balance <0)
            دائن ب ({{ $info->current_balance*1*(-1) }})   ريال

          @else
      متزن
           
          @endif
          
            </td> 
            
            <td>{{ $info->address }}</td>  
            <td>{{ $info->phones }}</td>  

            <td>{{ $info->notes }}</td>  

             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('customer.edit',$info->id) }}" class="btn btn-md btn-primary">تعديل</a>   

         </td>
           
   
           </tr> 
     
         @endforeach
   
   
   
            </tbody>
             </table>
             </table>
      <br>
      <div class="col-md-12" id="ajax_pagination_in_search">
         {{ $data->links() }}
      </div>
       
           @else
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif
