@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
		<span> {{ Session::get('message')}} </span>
@endif
<form method="post" action="{{url('/admin-procces-pas')}}">
    {{csrf_field()}}
      <input type="hidden" name="id" value="{{$login->id}}">
      new password:
      <input type="password" name="newpas" placeholder="Enter the new password" class="form-control"/> <br>
      Retype password:
      <input type="password" name="repas" placeholder="Retype password" class="form-control"> <br>
      <p></p>
      <input type="submit" value="Reset password" class="btn-danger">  
</form>