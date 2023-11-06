@extends('layouts.minbag')
@section('title')
اضافة مستخدم جديدة
@endsection

@section('contentheader')
مستخدمين
@endsection

@section('contentheaderlink')
<a href="{{ route('users.index') }}"> مستخدمين </a>
@endsection

@section('contentheaderactive')
اضافة
@endsection



@section('content')

<div class="row">


    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('users_accounts.index') }}">رجوع</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{route('users_accounts.store')}}" method="post">
                    {{csrf_field()}}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-4" id="fnWrapper">
                                <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="username" value="{{old('username')}}" required="" type="text">
                            </div>
                            <div class="parsley-input col-md-4" id="fnWrapper">
                                <label>الاسم : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="name" value="{{old('name')}}" required="" type="text">
                            </div>

                            <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="email" value="{{old('email')}}" required="" type="email">
                            </div>
                        </div>

                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="password" required="" type="password">
                        </div>

                        <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="confirm-password" required="" type="password">
                        </div>
                        
                        <div class="col-lg-3">
                            <label class="form-label">حالة المستخدم</label>
                            <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="مفعل">مفعل</option>
                                <option value="غير مفعل">غير مفعل</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>(الدور)الوظيفة</label>
                                <select name="role" id="role" class="form-control ">
                                  
                                    @if (@isset($roles) && !@empty($roles))
                                  @foreach ($roles as  $role )
                                    <option 
                                     value="{{ $role->name }}" > {{ $role->name }} </option>
                                  @endforeach
                                   @endif
                                 </select>
                             </div>

                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-primary pd-x-20 mb-3 mt-2" type="submit">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

@endsection



