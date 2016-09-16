@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<form method="post" action="{{url('/prosesubah')}}">
    {{csrf_field()}}
      <input type="hidden" name="id" value="">
      new password:
      <input type="password" name="newpas" placeholder="Enter your new Password " class="form-control"/> <br>
      Retype password:
      <input type="password" name="repas" placeholder="Retype your password" class="form-control"> <br>
      <p></p>s
      <input type="submit" value="Ubah password" class="btn-danger">  
</form>