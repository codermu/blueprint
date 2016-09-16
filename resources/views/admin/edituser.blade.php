@extends('isi/t_index')

@section('content')



<div class="container">

@if(Session::has('message'))

 <span class="label label-success">{{ Session::get('message') }}</span>

@endif

<center>

<h2 class="title-reg">User Change form</h2>

<form method="post" action="{{url('/user-process')}}" class="form-reg">
{{csrf_field()}}
	<input type="hidden" name="id" value="{{$login->id}}">
      Username &nbsp;:
      <input type="text" name="username" value="{{$login->username}}" class="form-control"><br>
      
      Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
      <input type="text" name="email" value="{{$login->email}}" class="form-control"/> <br>
      <p></p>

      Hak Akses &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
      <select name="hak_akses" class="list-text">
      	@foreach($hak_akses as $ha)
      		@if($ha->hak_akses == $login->hak_akses)
		      <option value="{{ $ha->hak_akses }}" selected=""> {{ $ha->hak_akses }} </option>
		     @else
		      <option value="{{ $ha->hak_akses }}"> {{ $ha->hak_akses }} </option>
		    @endif
      	@endforeach
      </select > <br>
      <p></p>
      
      Activation Status :
      <select name="activation_status" class="list-text">
      	@foreach($activation_status as $ac)
      		@if($ac->activation_status == $login->activation_status)
		      <option value="{{ $ac->activation_status }}" selected=""> {{ $ac->activation_status }} </option>
		     @else
		      <option value="{{ $ac->activation_status }}"> {{ $ac->activation_status }} </option>
		    @endif
      	@endforeach 
      </select > <br>

  <br>
      <p></p>
      <input type="submit" value="Ubah Data" class="btn-danger">  
</form>
</center>