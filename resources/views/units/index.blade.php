@extends('layouts.minbag')
@section('title')
الوحدات
@endsection
@section('contentheader')
الوحدات
@endsection
@section('contentheaderlink')
<a href="{{ route('items.index') }}">  الأصناف</a>
@endsection
@section('contentheaderactive')
عرض الوحدات
@endsection
@section('content')

 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات وحدات  للأصناف</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('units.ajax_search') }}">
        
          <a href="{{ route('units.create') }}" class="btn btn-md btn-success" >اضافة جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">
            <label>    بحث بالاسم</label>

            <input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control"> <br>
            
                      </div>
                      <div class="col-md-4">
                      <div class="form-group"> 
                        <label>    بحث بالنوع</label>
                        <select name="is_main_search" id="is_main_search" class="form-control">
                         <option value="all"> بحث بالكل</option>
                        <option  value="1"> وحدة رئيسية</option>
                         <option value="0"> وحدة تجزئة</option>
                        </select>
                       
                        </div>
                      </div>
               <div class="clearfix"></div>
               <div class="col-md-12">      
        <div id="ajax_responce_serarchDiv">
          
          @if (@isset($data) && !@empty($data))
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>الرقم</th>
           <th>اسم الوحدة</th>
           <th> نوع الوحدة</th>
           <th>حالة التفعيل</th>
           <th> تاريخ الاضافة</th>
           <th> تاريخ التحديث</th>
           <th>العمليات</th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->is_main==1) واحدة رئيسية @else وحدة تجزئة @endif</td> 

             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
             <td > 
     
              @php
             $dt=new DateTime($info->created_at);
             $date=$dt->format("Y-m-d");
             $time=$dt->format("h:i");
             $newDateTime=date("A",strtotime($time));
             $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
              @endphp
          {{ $date }} 
          بواسطة 
          {{ $info->added_by_admin}}
          
          
                          </td>
                          
     <td > 
  @if($info->updated_by>0 and $info->updated_by!=null )
                         @php
                        $dt=new DateTime($info->updated_at);
                        $date=$dt->format("Y-m-d");
                        $time=$dt->format("h:i");
                        $newDateTime=date("A",strtotime($time));
                        $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                         @endphp
                     {{ $date }} 
                     بواسطة 
                     {{ $data['updated_by_admin'] }}
                          @else
                     لايوجد تحديث
                            @endif
                     
       </td>            
         <td>

        <a href="{{ route('units.edit',$info->id) }}" class="btn btn-md  btn-primary">تعديل</a>   
   
         </td>
           
   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
      <br>
           {{ $data->links() }}
       
           @else
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif

        </div>
      </div>
      
      

      </div>
        </div>
     
</div>





@endsection

@section('script')
<script src="{{ asset('assets/js/units.js') }}"></script>

@endsection


