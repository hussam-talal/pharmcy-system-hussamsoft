@extends('layouts.minbag')
@section('title')
   الصلاحيات المستخدمين
@endsection

@section('contentheader')
صلاحيات المستخدمين 
@endsection

@section('contentheaderlink')
<a href="{{ route('roles.index') }}"> صلاحيات المستخدمين </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')



@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الصلاحية بنجاح",
                type: "error"
            });
        }

    </script>
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            {{-- @can('أضافة صلاحية') --}}
                                <a class="btn btn-primary btn-sm m-2" href="{{ route('roles.create') }}">اضافة صلاحيات</a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <?php
                            $i=1;
                            ?>
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        
                                        {{-- @can('تعديل صلاحية') --}}
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                        {{-- @endcan --}}

                                        @if ($role->name !== 'owner')
                                            @can('حذف صلاحية')
                                            <a href="{{ route('roles.delete',$role->id) }}" class="btn btn-sm are_you_shue  btn-danger">
                                                <i class="nav-icon fas fa-trash"></i>حذف
                                                
                                            @endcan
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

@endsection

@section('script')
<script src="{{ asset('assets/js/treasuries1.js') }}"></script>

@endsection


