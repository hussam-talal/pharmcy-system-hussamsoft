@extends('layouts.minbag')
@section('title')
الموردين
@endsection
@section('contentheader')
الحسابات
@endsection
@section('contentheaderlink')
<a href="{{ route('supplier.index') }}">    الموردين </a>
@endsection

@section('contentheaderactive')
عرض
@endsection
@section('content')
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات   الموردين  </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('supplier.ajax_search') }}">
        
          <a href="{{ route('supplier.create') }}" class="btn btn-md btn-success" >اضافة جديد</a>
          <a href="{{ route('suppliers_categories.index') }}" class="btn btn-md  btn-dark ">فئات الموردين</a> 
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">
            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="suuplier_code"> برقم المورد
            <input  type="radio"  name="searchbyradio" id="searchbyradio" value="account_number"> برقم الحساب
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> بالاسم
            <input autofocus style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" اسم  - رقم الحساب  - كود المرود" class="form-control"> <br>
            
                      </div>
                      <div class="col-md-4">
                        <div class="form-group"> 
                          <label>  بحث بحالة الرصيد</label>
                          <select name="searchByBalanceStatus" id="searchByBalanceStatus" class="form-control">
                            <option   value="all"> بحث بالكل</option>
                            <option   value="1"> دائن</option>
                            <option  value="2"> مدين</option>
                            <option    value="3"> متزن</option>
                          </select>
                         
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group"> 
                            <label>  بحث بحالة التفعيل</label>
                            <select name="searchByactiveStatus" id="searchByactiveStatus" class="form-control">
                              <option   value="all"> بحث بالكل</option> 
                              <option   value="1"> مفعل</option>
                              <option  value="0"> معطل</option>
                            </select>
                           
                            </div>
                          </div>
                          </div>
               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">
          
          @if (@isset($data) && !@empty($data) && count($data)>0)

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
          <th>العمليات</th>

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




             <td @if($info->active==1) class="bg-success" @else class="bg-danger" @endif  >@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('supplier.edit',$info->id) }}" class="btn btn-sm  btn-primary ml-2">تعديل</a> 
        @can('حذف مستخدم')  
        <a href="{{ route('supplier.delete',$info->id) }}" class="btn btn-sm  btn-danger">حذف</a>   
      @endcan
         </td>
           
   
           </tr> 
     
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

@endsection

@section('script')
<script src="{{ asset('assets/js/suppliers.js') }}"></script>
@endsection

