@extends('isi/t_index')
@section('content')

<h3> Silahkan masukan password baru anda</h3>
@if(Session::has('message'))
		<span> {{ Session::get('message')}} </span>
@endif
<form method="post" action="{{url('/gantipas')}}">
    {{csrf_field()}}
    <input type="hidden" name="passkey" value="{{ $key[0]->reset_key }}" />
      <input type="hidden" name="id" value="">
      new password:
      <input type="password" name="newpas" placeholder="masukan password baru" class="form-control"/> <br>
      Retype password:
      <input type="password" name="repas" placeholder="masukan ulang password baru anda" class="form-control"> <br>
      <p></p>
      <input type="submit" value="Reser password" class="btn-danger">  
</form>