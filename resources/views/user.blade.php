@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<p></p>

Selamat Datang {{Auth::user()->username}} <br>
<a href="pic-user"> Change Picture</a> <br>
<img src=" {{ '/img/'.Auth::user()->pic }}" style="width: 35%;"> 
<p></p>
Silahkan Lihat Data <a href='/viewuser'/> Kesini</a><br>
<a href="{{ URL('logout')}}">Logout</a>  ||  <a href="/change-password"> Change Password </a>
