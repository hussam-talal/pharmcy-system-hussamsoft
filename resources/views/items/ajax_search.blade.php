  
          @if (@isset($data) && !@empty($data) && count($data) >0)
          @php
           $i=1;   
          @endphp
           <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
              <th>كود آلي </th>
           <th>الاسم العلمي </th>
           <th>الاسم الشائع </th>
           <th> النوع </th>
           <th> الفئة </th>
           <th> الوحدة الرئيسية </th>
           <th>  الكمية الحالية </th>
           <th>حالة التفعيل</th>
         
           <th>العمليات</th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $info->item_code }}</td>  
             <td>{{ $info->name }}</td>  
             <td>{{ $info->name1 }}</td> 
             <td>@if($info->item_type==1) مخزني  @elseif($info->item_type==2) استهلاكي بصلاحية   @elseif($info->item_type==3) عهدة @else غير محدد @endif</td>  
             <td>{{ $info->items_categories_name }}</td>  
             <td>{{ $info->units_name }}</td>  
             <td>{{ $info->All_QUENTITY*1 }} {{ $info->units_name }}</td>  


             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('items.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('items.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>   

         </td>
           
   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
             
             <br>
             <div class="col-md-12" id="ajax_pagination_in_search">
                {{ $data->links() }}
             </div>
       
           @else
           <div class="clearfix"></div>
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif
