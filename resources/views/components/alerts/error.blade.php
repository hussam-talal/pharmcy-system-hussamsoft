@if(Session::has('error'))
<div>
    <div class="form-group text-center">
<div class="alert alert-danger" role="alert">
    {{  Session::get('error') }}
  </div>
</div>
</div>

  @endif
