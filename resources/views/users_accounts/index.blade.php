@extends('layouts.minbag')
@section('title')
 الصلاحيات
@endsection

@section('contentheader')
المستخدمين
@endsection

@section('contentheaderlink')
<a href="{{ route('users.index') }}"> المستخدمين </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  المستخدمين</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('users_accounts.ajax_search') }}">
          @can('أضافة مستخدم')
          <a href="{{ route('users_accounts.create') }}" class="btn btn-md btn-success" >اضافة جديد</a>
        @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="col-md-4">
<input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control"> <br>

          </div>
       
        <div id="ajax_responce_serarchDiv">
          
          @if (@isset($data) && !@empty($data))
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>مسلسل</th>
           <th>اسم المستخدم</th>
           <th>  حالة المستخدم</th>
           <th>العمليات</th>
          
            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>{{$info->Status}}
                 
             </td> 
         <td>
          <a class="btn btn-success btn-md"
          href="{{ route('users.show', $info->id) }}">عرض</a>
        <a href="{{ route('users_accounts.details',$info->id) }}" class="btn btn-md btn-info">صلاحيات خاصة</a>   
   
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


