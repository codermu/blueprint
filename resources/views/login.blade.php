@extends('isi/t_index')
@section('content')



<center>
	<h1 class="title-text"> Festiware </h1>
	<form method="post" action="{{url('/login')}}" class="form-login">
		{{csrf_field()}}
		<div class="form-body">
			<div class="msg-text"><br /><br />
				@if(Session::has('message'))
				<span> {{ Session::get('message')}} </span>
				@endif
			</div>
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
		<input type="password" name="password" placeholder="Password" class="form-control"><p></p>
		<a href="{{ URL('/register') }}" class="link-reg">Sign Up</a> || 
		<a href="{{ URL('/forgetpas')}}" class="link-reg">Forget password </a> <p></p> 
		<p></p>
		
		<input type="submit" value="Login" class="btn-danger"/>
		</div>
	</form>
</center>
@stop