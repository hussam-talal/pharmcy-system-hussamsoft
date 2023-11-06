@extends('layouts.minbag')
@section('title')
الضبط العام
@endsection

@section('contentheader')
الضبط العام
@endsection

@section('contentheaderlink')
<a href="{{ route('adminPanelSetting.index') }}">  الضبط العام</a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        @if (@isset($data) && !@empty($data))
        <table id="example2" class="table table-bordered table-hover">
         
            <tr>
                <td class="width30">اسم الصيدلية</td> 
                <td > {{ $data['system_name'] }}</td>
            </tr>

            <tr>
                <td class="width30">كود الصيدلية</td> 
                <td > {{ $data['com_code'] }}</td>
            </tr>

            <tr>
                <td class="width30">حالة الصيدلية</td> 
                <td > @if($data['active']==1) مفعل  @else معطل @endif</td>
            </tr>

            <tr>
                <td class="width30">عنوان  الصيدلية</td> 
                <td > {{ $data['address'] }}</td>
            </tr>

            <tr>
                <td class="width30">هاتف  الصيدلية</td> 
                <td > {{ $data['phone'] }}</td>
            </tr>

           
            
            <tr>
                <td class="width30">  رسالة التنبية اعلي الشاشة الصيدلية</td> 
                <td > {{ $data['general_alert'] }}</td>
            </tr>
            <tr>
                <td class="width30">شعار  الصيدلية</td> 
                <td >
             <div class="image">
      <img class="custom_img" src="{{ asset('assets/uploads').'/'.$data['photo'] }}"  alt="شعار الصيدلية">       
                
            </div>

                </td>
            </tr>
  
            <tr>
                <td class="width30">  تاريخ اخر تحديث</td> 
                <td > 
       @if($data['updated_by']>0 and $data['updated_by']!=null )
    @php
   $dt=new DateTime($data['updated_at']);
   $date=$dt->format("Y-m-d");
   $time=$dt->format("h:i");
   $newDateTime=date("A",strtotime($time));
   $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
    @endphp
{{ $date }}
{{ $time }}
{{ $newDateTimeType }}
بواسطة 
{{ $data['updated_by_admin'] }}





     @else
لايوجد تحديث
       @endif
       @can('عرض الضبط العام')
<a href="{{ route('adminPanelSetting.edit') }}" class="btn btn-sm btn-success">تعديل</a>

@endcan
                </td>
            </tr> 
           
          </table>

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



