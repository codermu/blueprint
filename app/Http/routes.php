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

Route::post('add-data','Crudcontroller@addData');
Route::get('read','Crudcontroller@readData');
Route::get('delete/{id}','Crudcontroller@deleteData');
Route::get('form-edit/{id}','Crudcontroller@editData');
Route::post('edit-data','Crudcontroller@editDataProcess');

Route::get('login', function () {
	 return view('login');
});

Route::post('addLog','Crudcontroller@addLog');
Route::get('register', function () {
	 return view('register');
});
	
Route::post('login', 'Crudcontroller@login');
Route::get('user', 'Crudcontroller@userHomePage');
Route::get('logout', 'Crudcontroller@logout');
Route::get('activate/{activation_key?}', 'Crudcontroller@activate');


Route::get('change-password', 'Crudcontroller@changePassword');
Route::post('change-process', 'Crudcontroller@changeProcess');


Route::get('forget-pas', 'Crudcontroller@forgetPas');
Route::post('process-reset-pass', 'Crudcontroller@processResetPass');
Route::get('reset-pass/{reset_key?}', 'Crudcontroller@resetPass');
Route::post('change-pass' , 'Crudcontroller@changePass');

Route::get('admin-change/{id}','Crudcontroller@adminChange'); 
Route::post('admin-procces-pas','Crudcontroller@adminProcessPas');
Route::get('block', function () {
	 return view('block');
});