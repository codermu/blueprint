 <?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
	 return view('login');

});
Route::get('/home', function () {
	 return view('home');

});
Route::get('/viewuser', 'Crudcontroller@viewuser' );

Route::post('tambahdata','Crudcontroller@tambahdata');
Route::get('read',  function () {
	return view('read');
});
Route::get('read','Crudcontroller@lihatdata');
Route::get('hapus/{id}','Crudcontroller@hapusdata');
Route::get('formedit/{id}','Crudcontroller@editdata');
Route::post('prosesedit','Crudcontroller@proseseditdata');
Route::get('login', function () {
	 return view('login');
});
	 // if(Auth::user()){
	// if(Auth::user()->hak_akses=="admin"){
		 // return view('home');
	// }else{
		// return view('user'); }
	// } else{
		// return view('login'); }
// });

Route::post('tambahlogin','Crudcontroller@tambahlogin');
Route::get('register', function () {
	 return view('register');
});
	// if(Auth::user()){
		// if(Auth::user()->hak_akses=="admin"){
		// return view('register');
	// }else{
		// return view('user');
	// }
	// }else{
		// return view('register');
	// }
// });
Route::post('login', 'Crudcontroller@login');
Route::get('user', 'Crudcontroller@userhomepage');
	// if(Auth::user()){
		// if(Auth::user()->hak_akses=="admin"){
		// return view('login');
	// }else{
		// return view('user');
	// }
	// } else{
		// return view('login'); }
// });;
Route::get('logout', 'Crudcontroller@logout');
Route::get('activate/{activation_key}', 'Crudcontroller@activate');
