@extends('layouts.minbag')
@section('title')
التقارير
@endsection
@section('contentheader')
تقرير مورد
@endsection
@section('contentheaderlink')
<a href="{{ route('repsuppliers.index') }}">   تقرير مورد</a>
@endsection

@section('contentheaderactive')
عرض
@endsection
@section('content')
     

<div class="row">

<div class="col-md-4"> 
                          <div class="form-group"> 

<form method="POST" action="{{route('repsuppliers.create')}}">
    @csrf

    <label for="select-option">اختر المورد:</label>
    <select name="suuplier_code" id="suuplier_code" class="form-control select2" required>
                              <option value=""> اختر المورد</option>
                              @if (@isset($suupliers) && !@empty($suupliers))
                              @foreach ($suupliers as $info )
                                <option value="{{ $info->suuplier_code }}"> {{ $info->name }} </option>
                              @endforeach

                               @endif
                               @error('suuplier_code')
  <span class="text-danger">{{ $message }}</span>
  @enderror
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