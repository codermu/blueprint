@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<form method="post" action="{{url('/prosesubah')}}">
    {{csrf_field()}}
      <input type="hidden" name="id" value="{{ $data[0]->id }}">
      old Password:
      <input type="password" name="password" placeholder="masukan password lama" class="form-control"><br>
      new password:
      <input type="password" name="newpas" placeholder="masukan password baru" class="form-control"/> <br>
      Retype password:
      <input type="password" name="repas" placeholder="masukan ulang password baru anda" class="form-control"> <br>
      <p></p>
      <input type="submit" value="Ubah password" class="btn-danger">  
</form>