@extends('isi/t_index')
@section('content')

@if(Session::has('message'))
	<span> {{ Session::get('message')}} </span>
@endif
@if (count($errors) > 0)
    
@endif
<center>
	<h2 class="title-reg">Choose Photo</h2>
	<form method="post" action="{{url('/pic-proc')}}" class="form-pic" enctype="multipart/form-data">
		
		{{csrf_field()}}
		<input type="hidden" name="id" value="{{Auth::user()->id}}">
		<input type="file" name="pic" class="but-pic"/>
		<p></p>
		<input type="submit" value="Change" class="btn-danger"/>
	</form>
</center>
@stop