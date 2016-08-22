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
      <th>Action</th>

    <?php $no=1; ?>
    @foreach ($siswa as $data)
    <?php 
      if ($no % 2 == 0) {
        $warna = '#29B6F6';
        $war = 'white';
      } else {
        $warna = '#FF4081';
        $war = 'white';
      }
    ?>
    <tr style=" background-color:{{$warna}}; color:{{$war}} ">
      <td>{{$no++}}</td>
      <td>{{$data -> nama}}</td>
      <td>{{$data -> alamat}}</td>
      <td>{{$data -> kelas}}</td>
      <td> 
        <a href="hapus/{{ $data->id}}" style=" background-color:{{$warna}}; color:{{$war}} " class="link-table">Hapus</a> || 
        <a href="formedit/{{ $data->id}}" style=" background-color:{{$warna}}; color:{{$war}} " class="link-table"> Edit </a>
      </td>
    </tr>
    @endforeach
  </table>
  <center>
  		{!! $siswa->render() !!}<br>
  		<a href="{{url('/home')}}">silahkan masukan data disini</a>
  </center>
  <left>
	<a href="{{ URL('logout')}}">Logout</a>
  </left>
@stop