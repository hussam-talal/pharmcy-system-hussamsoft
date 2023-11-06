@extends('layouts.minbag')
@section('title')
التقارير
@endsection
@section('contentheader')
تقريرعميل
@endsection
@section('contentheaderlink')
<a href="{{ route('repcustomers.index') }}">  حساب عميل</a>
@endsection

@section('contentheaderactive')
عرض
@endsection
@section('content')


     



<form method="POST" action="{{route('repcustomers.create')}}">
    @csrf
    <div class="row">

<div class="col-md-4"> 
                          <div class="form-group"> 
    <label for="select-option">اختر العميل:</label>
    <select name="customer_code" id="customer_code" class="form-control select2" required>
                              <option value=""> اختر العميل</option>
                              @if (@isset($customer) && !@empty($customer))
                              @foreach ($customer as $info )
                                <option value="{{ $info->customer_code }}"> {{ $info->name }} </option>
                              @endforeach

                               @endif
                         </select>
                         
                            </div>
                          </div>
                        
                      

                           <div class="col-md-4"> 
                            <div class="form-group">
                              <label>   بحث  من تاريخ</label>
                              <input name="order_date_form" id="order_date_form" class="form-control" type="date" value=""    >
                              @error('order_date_form')
                    <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>

                          <div class="col-md-4"> 
                            <div class="form-group">
                              <label>   بحث  الي تاريخ</label>
                              <input name="order_date_to" id="order_date_to" class="form-control" type="date" value=""    >
                              @error('order_date_to')
                    <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>
                        
                        
                          </div>
                          <button class="btn btn-center text-white" style="background-color:blue; margin-right:45%" type="submit">طلب تقرير</button>
                          </form>
                         
@endsection


