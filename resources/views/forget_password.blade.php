<!-- Silahkan masukan email anda<br />
<input type="text" name="email" placeholder="masukan email anda" ><br />
<input type="submit" value="Forget Password" class="btn-danger"/> -->
@extends('isi/t_index')
@section('content')

<form method="post" action="{{url('/forget_password')}}">
	{{csrf_field()}}
	Silahkan Masukan Email anda : @if($errors->has())
		<span>{!! $errors->first('email') !!}</span>
		@endif
	<p><input type="text" name="email" placeholder="Email" class="form-control"> <br> <br>
	<input type="submit" value="Forget password" class="btn-danger"/>
</form>
@stop