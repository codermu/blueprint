@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span> {{ Session::get('message')}} </span>
@endif



@if (count($errors) > 0)
    
@endif
<center>
	<h2 class="title-reg">Masukan Data Lengkap Anda</h2>
	<form method="post" action="{{url('/tambahlogin')}}" class="form-reg">
		<div class="alert alert-danger">
	        <ul>
	            <!-- @foreach ($errors->all() as $error)
	                <li>{{ "data tidak boleh kosong" }}</li>
	            @endforeach -->
	        </ul>
    	</div>
		{{csrf_field()}}
		Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: @if($errors->has())
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
</center>
@stop