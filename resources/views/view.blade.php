@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span class="label-succes"> {{ Session::get('message') }}</span>
@endif
	

<p></p>
  <table cellspacing="3" cellpadding="5" align="center" class="table-info">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Alamat</th>
      <th>Kelas</th>
      
    <?php $no=1; ?>
    @foreach ($siswa as $data)
    <?php 
      if ($no % 2 == 0) {
        $warna = 'white';
        $war = 'cornflowerblue';
      } else {
        $warna = 'cornflowerblue';
        $war = 'white';
      }
    ?>
    <tr style=" background-color:{{$warna}}; color:{{$war}} ">
      <td>{{$no++}}</td>
      <td>{{$data -> nama}}</td>
      <td>{{$data -> alamat}}</td>
      <td>{{$data -> kelas}}</td>
    </tr>
    @endforeach
  </table>
  <center>
  		{!! $siswa->render() !!}<br>
  </center>
  <left>
	<a href="{{ URL('logout')}}">Logout</a>
  </left>
@stop