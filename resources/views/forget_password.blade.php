<!-- Silahkan masukan email anda<br />
<input type="text" name="email" placeholder="masukan email anda" ><br />
<input type="submit" value="Forget Password" class="btn-danger"/> -->
@extends('isi/t_index')
@section('content')
<center>
	<form method="post" action="{{url('/prosesresetpass')}}" class="form-forget">
		{{csrf_field()}}
		<div class="form-forg">
			Silahkan Masukan Email anda : <br>
			    @if($errors->has())
				<span>{!! $errors->first('email') !!}</span>
				@endif
				@if(Session::has('message'))
					<span> {{ Session::get('message')}} </span>
					<br>
				@endif	
			<input type="text" name="email" placeholder="Email" class="form-control"> <br> <br>
			<input type="submit" value="Forget password" class="btn-danger"/>
		</div>
	</form>
</center>
@stop