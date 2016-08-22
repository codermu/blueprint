@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span> {{ Session::get('message')}} </span>
@endif

<form method="post" action="{{url('/tambahlogin')}}">
	{{csrf_field()}}
	Email : @if($errors->has())
		<br/>
		<span>{!! $errors->first('email') !!}</span>
		<p></p>
		@endif
	<input type="text" name="email" placeholder="Email" class="form-control"> <br> <br>
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
	<p></p>
	<input type="submit" value="register" class="btn-danger"/>
</form>
@stop