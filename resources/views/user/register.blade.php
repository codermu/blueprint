@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span> {{ Session::get('message')}} </span>
@endif
@if (count($errors) > 0)
    
@endif
<center>
	<h2 class="title-reg">Masukan Data Lengkap Anda</h2>
	<form method="post" action="{{url('/addLog')}}" class="form-reg" enctype="multipart/form-data">
		
		{{csrf_field()}}
			@if($errors->has())
				<span class="error-text">{!! $errors->first('email') !!}</span>
				<br>
			@endif
		Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
		<input type="text" name="email" placeholder="Email" class="form-control"> <br> <br>
			@if($errors->has())
				<span class="error-text">{!! $errors->first('username') !!}</span>
				<br>
			@endif
		Username : 
		<input type="text" name="username" placeholder="Username" class="form-control"> <br> <br>
			@if($errors->has())
				<span class="error-text">{!! $errors->first('password') !!}</span>
				<br>
			@endif
		Password : 
		<input type="password" name="password" placeholder="Password" class="form-control"><br>
		<p></p>
		Choose Your Image profile    
		<input type="file" name="pic" />
		<p></p>
		<input type="submit" value="Register" class="btn-danger"/>
	</form>
</center>
@stop