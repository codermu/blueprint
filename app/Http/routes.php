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


// Route::get('/', function () {
	 // return view('new_login');

// });
Route::get('/','AdminController@index');
Route::get('/viewuser', 'UserController@viewuser' );

Route::get('data-sis','UserController@dataSis');
Route::post('add-data','UserController@addData');
Route::get('read','AdminController@readData');
Route::get('user_read','UserController@readData');
Route::get('read-user','UserController@readUser');
Route::get('delete/{id}','UserController@deleteData');
Route::get('form-edit/{id}','UserController@editData');
//Route::get('form-edit/{id}','AdminController@editData');
Route::post('edit-data','UserController@editDataProcess');
Route::get('register','UserController@register');
Route::post('addLog','UserController@addLog');
Route::get('new-user','UserController@newUser');
Route::get('notactive','UserController@notActive');
Route::post('send-key','UserController@sendKey');
	
Route::post('login', 'AdminController@login');
Route::get('user', 'AdminController@userHomePage');
Route::get('logout', 'AdminController@logout');
Route::get('activate/{activation_key?}', 'UserController@activate');


Route::get('change-password', 'UserController@changePassword');
Route::post('change-process', 'UserController@changeProcess');


Route::get('forget-pas', 'UserController@forgetPas');
Route::post('process-reset-pass', 'UserController@processResetPass');
Route::get('reset-pass/{reset_key?}', 'UserController@resetPass');
Route::post('change-pass' , 'AdminController@changePass');

Route::get('admin-change/{id}','AdminController@adminChange'); 
Route::post('admin-procces-pas','AdminController@adminProcessPas');
Route::get('block-user','UserController@blockUser');
Route::get('edit-user/{id}','AdminController@editUser'); 
Route::post('user-process','AdminController@userProcess');


Route::get('pic-user','UserController@picUser');
Route::post('pic-proc','UserController@picProcess');
Route::get('user-home','UserController@userPro');
// Route::get('template', function () {
	 // return view('template/index');
// });
Route::get('/gentelella/index','ExampleController@index');
Route::get('/gentelella/blank','ExampleController@blank');
Route::get('/gentelella/manage','ExampleController@manage');
Route::get('/gentelella/form','ExampleController@form');
Route::get('/gentelella/outbox','ExampleController@outbox');
Route::get('/gentelella/profile','ExampleController@profile');

