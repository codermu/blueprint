@if(Session::has('message'))
 <span class="label label-success">{{ Session::get('message') }}</span>
@endif
<p></p>
Selamat Datang {{Auth::user()->username}} <br>
Silahkan Lihat Data <a href='/viewuser'/> Kesini</a><br>
<a href="{{ URL('logout')}}">Logout</a>  ||  <a href="ubahpassword">ubah password</a>
