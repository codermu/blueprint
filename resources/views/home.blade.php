@extends('isi/t_index')
@section('content')


<form method="POST" action="{{url('/add-data')}}">
	{{csrf_field()}}
		Nama : <input type="text" name="nama" class="form-control"/> <br>
		Alamat :
		<input type="text" name="alamat" class="form-control"/> <br>
		Kelas :
		<input type="text" name="kelas" class="form-control"/> <br>
		<p></p>
		<input type="submit" value="Tambah Data" class="btn-danger"/>
</form>
<span> Ingin lihat data? <a href="{{url('/read')}}"> Kesini </a> </span>