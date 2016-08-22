@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span> {{ Session::get('message')}} </span>
@endif

<form method="post" action="{{url('/login')}}">
	{{csrf_field()}}
	Username : @if($errors->has())
		<br/>
		<span>{!! $errors->first('username') !!}</span>
		<p></p>
		@endif
	<input type="text" name="username" placeholder="Username" class="form-control"> <br> <br>
	Password : @if($errors->has())
		<br/>
		<span>{!! $errors->first('password') !!}</span>
		<p></p>
		@endif
	<input type="password" name="password" placeholder="Password" class="form-control"><br>
	<a href="{{ URL('/register') }}">Daftar</a> <p></p> 
	<p></p>
	<input type="submit" value="Login" class="btn-danger"/>
</form>
@stop