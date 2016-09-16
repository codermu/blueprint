@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<form method="post" action="{{url('/change-process')}}">
    {{csrf_field()}}
      <input type="hidden" name="id" value="">
      Old Password:
      <input type="password" name="password" placeholder="Enter your password" class="form-control"><br>
      New password:
      <input type="password" name="newpas" placeholder="Enter your new password" class="form-control"/> <br>
      Retype password:
      <input type="password" name="repas" placeholder="Retype your password" class="form-control"> <br>
      <p></p>
      <input type="submit" value="Ubah password" class="btn-danger">  
</form>