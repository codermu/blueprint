@extends('isi/t_index')
@section('content')

<div class="container">
@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<form method="post" action="{{url('/prosesedit')}}">
    {{csrf_field()}}
      <input type="hidden" name="id" value="{{$siswa->id}}">
      Nama:
      <input type="text" name="nama" value="{{$siswa->nama}}" class="form-control"><br>
      Alamat:
      <input type="text" name="alamat" value="{{$siswa->alamat}}" class="form-control"/> <br>
      Kelas:
      <input type="text" name="kelas" value="{{$siswa->kelas}}" class="form-control"> <br>
      <p></p>
      <input type="submit" value="Ubah Data" class="btn-danger">  
</form>