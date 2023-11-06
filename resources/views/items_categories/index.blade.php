@extends('layouts.minbag')
@section('title')
الضبط العام
@endsection

@section('contentheader')
 فئات الأصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('items.index') }}">  الأصناف </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  فئات الأصناف</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('treasuries.ajax_search') }}">
        
          <a href="{{ route('items_categories.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
     
        <div id="ajax_responce_serarchDiv">
          
          @if (@isset($data) && !@empty($data))
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>الرقم</th>
           <th>اسم التصنيف</th>
           <th>حالة التفعيل</th>
           <th> تاريخ الاضافة</th>
           <th> تاريخ التحديث</th>
           <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
             <td > 
     
              @php
             $dt=new DateTime($info->created_at);
             $date=$dt->format("Y-m-d");
             $time=$dt->format("h:i");
             $newDateTime=date("A",strtotime($time));
             $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
              @endphp
          {{ $date }} <br>
          {{ $time }}
          {{ $newDateTimeType }}  <br>
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
                     {{ $date }}  <br>
                     {{ $time }}
                     {{ $newDateTimeType }}  <br>
                     بواسطة 
                     {{ $data['updated_by_admin'] }}
                          @else
                     لايوجد تحديث
                            @endif
                     
       </td>           

             
         <td>

         <a href="{{ route('items_categories.edit',$info->id) }}" class="btn btn-sm  btn-primary m-2">تعديل</a>   
      

         <a href="{{ route('items_categories.delete',$info->id) }}" class="btn btn-sm  btn-danger">حذف</a>   
        
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
<script src="{{ asset('assets/js/treasuries.js') }}"></script>

@endsection


