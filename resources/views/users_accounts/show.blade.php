@extends('layouts.minbag')
@section('title')
عرض مستخدم 
@endsection

@section('contentheader')
المستخدمين
@endsection

@section('contentheaderlink')
<a href="{{ route('users.index') }}"> مستخدمين </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-sm-1 col-md-2">
                    @can('أضافة مستخدم')
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">اضافة مستخدم</a>
                    @endcan
                </div>
  </div>
            
  <div class="card-body">
    <div class="table-responsive hoverable-table">
        <table class="table table-hover" id="example1" data-page-length='50' style=" text-align: center;">
            <thead>
                <tr>
                    <th class="wd-10p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">اسم المستخدم</th>
                    <th class="wd-15p border-bottom-0">الاسم </th>
                    <th class="wd-20p border-bottom-0">البريد الالكتروني</th>
                    <th class="wd-20p border-bottom-0">صورة المستخدم </th>
                    <th class="wd-15p border-bottom-0">حالة المستخدم</th>
                    <th class="wd-15p border-bottom-0">(الدور)الوظيفة</th>
                    <th class="wd-10p border-bottom-0">العمليات</th>
                </tr>
            </thead>
            <tbody>
    @if (!empty($users))                            
                           
    <tr>
        <td>1</td>
        <td>{{ $users['username'] }}</td>
        <td>{{ $users['name'] }}</td>
        <td>{{ $users['email'] }}</td>
        <td >
         <div class="photo"><img class="rounded-circle" src="{{ asset('assets/uploads').'/'.$users['photo'] }}" width="31" alt=" صورة المستخدم"></div>
        </td>
            <td>
            
            @if ($users['Status'] == 'مفعل')
                <div class="label text-success ">
                    {{ $users['Status'] }}
                </span>
            @else
                <div class="label text-danger ">
                    
                    {{ $users['Status']}}
                </div>
            @endif
        </td>

        <td>
            @if (!empty($users->getRoleNames()))
                @foreach ($users->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
        </td>
       

        <td>
            @can('حذف مستخدم')
                <a class="modal-effect btn btn btn-danger" data-effect="effect-scale"
                    data-users_id="{{ $users->id }}" data-username="{{ $users->username }}"
                    data-toggle="modal" href="#modaldemo8" >حذف
                </a>
            @endcan
        </td>
    </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المستخدم</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('users.delete', $users['id']) }}" method="get">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input class="form-control" value="{{$users['username']}}" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection


