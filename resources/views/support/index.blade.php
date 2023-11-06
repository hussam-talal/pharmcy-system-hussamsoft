@extends('layouts.minbag')
@section('title')
الدعم الفني
@endsection

@section('contentheader')
الدعم الفني
@endsection

@section('contentheaderlink')
<a href="{{ route('support.index') }}">الدعم الفني</a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')


<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">الدعم الفني</h3>
         
        </div>
        
        <div class="text-center">
        <img   width=20%  height="20%"src=" {{ asset('assets/imgs/picpro.png')}}" alt="s">
        </div>
        <h4 class="text-center" > للتواصل مع فريق الدعم الاتصال :</h4>
      <br>
      
       <table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th> رقم الهاتف</th>
      <th>الايميل </th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>محتوى العنصر الأول</td>
      <td>محتوى العنصر الثاني</td>
      
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>محتوى العنصر الأول</td>
      <td>محتوى العنصر الثاني</td>
      
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>محتوى العنصر الأول</td>
      <td>محتوى العنصر الثاني</td>
    
    </tr>
  </tbody>
</table>
        </div>
      
      
      


        </div>
      </div>
    </div>
</div>

@endsection





