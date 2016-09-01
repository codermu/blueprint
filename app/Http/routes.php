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
Route::get('read','Crudcontroller@lihatdata');
Route::get('hapus/{id}','Crudcontroller@hapusdata');
Route::get('formedit/{id}','Crudcontroller@editdata');
Route::post('prosesedit','Crudcontroller@proseseditdata');

Route::get('login', function () {
	 return view('login');
});

Route::post('tambahlogin','Crudcontroller@tambahlogin');
Route::get('register', function () {
	 return view('register');
});
	
Route::post('login', 'Crudcontroller@login');
Route::get('user', 'Crudcontroller@userhomepage');
Route::get('logout', 'Crudcontroller@logout');
Route::get('activate/{activation_key?}', 'Crudcontroller@activate');


Route::get('ubahpassword', 'Crudcontroller@ubahpassword');
Route::post('prosesubah', 'Crudcontroller@prosesubah');


Route::get('forgetpas', 'Crudcontroller@forgetpas');
Route::post('prosesresetpass', 'Crudcontroller@prosesresetpass');
// Route::get('resetpas', 'Crudcontroller@resetpassss');
Route::get('resetpas/{reset_key?}', 'Crudcontroller@resetpas');
Route::post('gantipas' , 'Crudcontroller@gantipas');

