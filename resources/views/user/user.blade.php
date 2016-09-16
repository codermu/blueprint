@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<p></p>


<center>
	<div class="user-form">
		<h3 class ="user-text">Selamat Datang {{Auth::user()->username}} </h3> <br>
		<img src=" {{ '/img/'.Auth::user()->pic }}" class="img-user" align="center"> <br>
		<a href="pic-user" class="link-text"> &#128247;&nbsp;&nbsp;&nbsp;Change Picture</a> <br>
		<p></p>
		<a href='/viewuser'/ class="link-text"> Silahkan Lihat Data Kesini</a><br>
		<p></p>
		<a href="/change-password" class="link-text"> Change Password </a> 
		<p></p>
		<a href="{{ URL('logout')}}" class="link-text"> &#x2708; Logout</a> 
	</div>
</center>