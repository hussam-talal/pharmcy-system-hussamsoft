@extends('layouts.minbag')
@section('title')
ضبط الأصناف
@endsection

@section('contentheader')
الأصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('items.index') }}">  الأصناف </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')


  
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات   الأصناف</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('items.ajax_search') }}">
          @can('أضافةاصناف')
          <a href="{{ route('items.create') }}" class="btn btn-md btn-success" >اضافة صنف جديد</a>
        @endcan
          <a href="{{ route('units.index') }}" class="btn  btn-dark btn-md ">وحدات الأصناف</a> 
        <a href="{{ route('items_categories.index') }}" class="btn btn-primary btn-md">فئات الأصناف</a> 
        </div>
      </div> 
      </div> 
    </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">
            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="barcode"> بالباركود
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="item_code"> بالكود
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> بالاسم

            <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" اسم - باركود - كود للصنف" class="form-control"> <br>
            
                      </div>
                      <div class="col-md-4"> 
                        <div class="form-group"> 
                          <label>  بحث بنوع الصنف</label>
                          <select name="item_type_search" id="item_type_search" class="form-control">
                           <option value="all"> بحث بالكل</option>
                          <option   value="1"> مخزني</option>
                          <option  value="2"> استهلاكي بتاريخ صلاحية</option>
                          <option   value="3"> عهدة</option>
                          </select>
                        
                          @error('item_type')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                          </div>
                        </div>
                        
                        <div class="col-md-4"> 
                          <div class="form-group"> 
                            <label>   بحث بفئة الصنف</label>

                            <select name="items_categories_id_search" id="items_categories_id_search" class="form-control ">
                           <option value="all"> بحث بالكل</option>
                              @if (@isset($items_categories) && !@empty($items_categories))
                             @foreach ($items_categories as $info )
                               <option value="{{ $info->id }}"> {{ $info->name }} </option>
                             @endforeach
                              @endif
                            </select>
                            @error('items_categories_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                          </div>
               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">
          
          @if (@isset($data) && !@empty($data))
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
            <th>كود آلي </th>
           <th>الاسم العلمي </th>
           <th>الاسم التجاري </th>
           <th> النوع </th>
           <th> الفئة </th>
           <th> الصنف البديل </th>
           <th> الوحدة الرئيسية </th>
           <th>  الكمية الحالية </th>
           <th>  الكمية التجزئة </th>
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
             <td>{{ $info->alternative_medicine_name }}</td>  
             <td>{{ $info->unit_name }}</td>  
             <td>{{ $info->All_QUENTITY*1 }} {{ $info->unit_name }}</td>
             <td>{{ $info->QUENTITY_all_Retails*1 }} {{ $info->unit_name }}</td>    
             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
         <td>
          @can('تعديل اصناف')
        <a href="{{ route('items.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
      @endcan
        <a href="{{ route('items.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>  
        @can('حذف اصناف')
        <a href="{{ route('items.delete',$info->id) }}" class="btn btn-sm   btn-danger">حذف</a>   
      @endcan   
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
              لاتوجد بيانات لعرضها !!
           </div>
                 @endif

        </div>
      </div>

        </div>
     
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/items.js') }}"></script>

@endsection


