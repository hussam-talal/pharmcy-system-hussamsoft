
          @if (@isset($data) && !@empty($data) && count($data)>0)
         
   
          @if($mirror['searchByBalanceStatus']!=3)
          <table style="width: 95%; margin: 0 auto;" id="example2" class="table table-bordered table-hover">
            <thead style="background-color: gray" class="custom_thead">
         
              @if($mirror['searchByBalanceStatus']==2)
              <th>اجمالي المستحق تحصيله من الموردين</th>

              @elseif($mirror['searchByBalanceStatus']==1)
              <th>اجمالي المتسحق صرفه للموردين</th>

             @else
             <th>اجمالي المستحق تحصيله من الموردين</th>
             <th>اجمالي المتسحق صرفه  للموردين</th>
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
          مبلغ مستحق علي الموردين بقمية ({{ $mirror['net']*1 }} ريال) 
          @elseif($mirror['net']< 0)
          مبلغ مستحق للموردين بقمية ({{ $mirror['net']*1*(-1) }} ريال)

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
           <th>  الفئة </th>
           <th> رقم الحساب </th>
           <th>  الرصيد </th>
           <th>  الهاتف </th>
           <th>  ملاحظات </th>
           <th> التفعيل</th>
          <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
           
             <td>{{ $info->name }}</td>  
             <td>{{ $info->suuplier_code }}</td>  
             <td>{{ $info->suppliers_categories_name }}</td>  

             
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
              <td>{{ $info->phones }}</td>  
              <td>{{ $info->notes }}</td>  

              <td @if($info->active==1) class="bg-success" @else class="bg-danger" @endif>
                @if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('supplier.edit',$info->id) }}" class="btn btn-md  btn-primary">تعديل</a>   

         </td>
           
   
           </tr> 
     
         @endforeach
   
   
   
            </tbody>
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
