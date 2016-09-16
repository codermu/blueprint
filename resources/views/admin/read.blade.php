@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span class="label-succes"> {{ Session::get('message') }}</span>
@endif
	

<p></p>
  <table cellspacing="3" cellpadding="5" align="center" class="table-info">
  	{{csrf_field()}}
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
        $warna = 'cornflowerblue';
        $war = 'white';
      } else {
        $warna = 'white';
        $war = 'cornflowerblue';
      }
    ?>
    <tr style=" background-color:{{$warna}}; color:{{$war}} ">
      <td>{{$no++}}</td>
      <td>{{$data -> nama}}</td>
      <td>{{$data -> alamat}}</td>
      <td>{{$data -> kelas}}</td>
      <td> 
        <a href="delete/{{ $data->id}}" onclick="return confirm('Are your sure want delete this data?')" style=" background-color:{{$warna}}; color:{{$war}} " class="link-table">Hapus</a> || 
        <a href="form-edit/{{ $data->id}}" style=" background-color:{{$warna}}; color:{{$war}} " class="link-table"> Edit </a>
      </td>
    </tr>
    @endforeach
  </table>
  	<center>
  		{!! $siswa->render() !!} <br>
  		<a href="{{url('/home')}}" class="link-text"> Silahkan masukan data disini</a>
  	</center>
  	<p></p>
  <table cellspacing="3" cellpadding="5" align="center" class="table-info">
  		<tr>
  			<th> No </th>
  			<th> ID </th>
  			<th> Username </th>
  			<th> Email</th>
  			<th> Hak Akses </th>
  			<th> Activation Status</th>
  			<!-- <th> Image </th> -->
  			<th> Other </th>
  		</tr>
	  	<?php $ni=1; ?>
	  	@foreach($login as $data2)
	  	<?php 
	      if ($ni % 2 == 0) {
	        	$warni = 'cornflowerblue';
        		$wari = 'white';
      		} else {
        		$warni = 'white';
        		$wari = 'cornflowerblue';
	      }
	    ?>
  		<tr style=" background-color:{{$warni}}; color:{{$wari}} ">
      		<td>{{$ni++}}</td>
      		<td>{{$data2 -> id}}</td>
      		<td>{{$data2-> username}}</td>
      		<td>{{$data2 -> email}}</td>
      		<td>{{$data2 -> hak_akses}}</td>
      		<td>{{$data2 -> activation_status}}</td>
      		<!-- <td>  <img src=" {{ '/img/'.$data2->pic }}" class="pic-user"></td> -->
      		<td> <a href="admin-change/{{ $data2->id}}" style=" background-color:{{$warni}}; color:{{$wari}} " class="link-table"> Change Password </a> ||
      			 <a href="edit-user/{{ $data2->id}}" style=" background-color:{{$warni}}; color:{{$wari}} " class="link-table"> Edit </a>
      		</td>
  		</tr>
  		@endforeach
  </table>
  <center>
  		{!! $login->render() !!} <br>
  </center>
  <left>
	<a href="{{ URL('logout')}}">Logout</a>
  </left>
 
  
@stop