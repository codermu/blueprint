<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
use Hash;
use Redirect;
use View;
use Auth;
use Session;


class Crudcontroller extends Controller
{
	
   public function cekhakakses(){
   	$this->ceklogin();
   	if (Auth::user()->hak_akses!='admin'){
       		echo 'Anda tidak memiliki hak akses kesini. silahkan <a href="/user"> kesini </a> '; 
	   		die();	
	  }
   }
   public function ceklogin()
   {
   		$login_status = Session::get('login_status');
		// var_dump($login_status);
   		if ($login_status=='loggedout'){
       		echo 'silahkan <a href="/login"> login kembali </a> '; 
	   		die();	
	  }
       
   }
   public function tambahdata()
   {
       $data = array(
	   	'nama' => Input::get('nama'),
	   	'alamat' => Input::get('alamat'),
	   	'kelas' => Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->insert($data);
	   return Redirect::to('/read')->with('message','berhasil menambah data');
   }
   
   public function lihatdata()
   {
        $this->cekhakakses();
		
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('read')-> with('siswa',$data);
   	 	return View('siswa', compact('user'));
	   
   }
   
   public function viewuser()
   {
       
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('view')-> with('siswa',$data);
   	 	return View('siswa', compact('user'));
   }
   
   public function hapusdata($id)
   {
   		$this->cekhakakses();
       	
       	DB::table('siswa') ->where ('id','=',$id)->delete();
	    return Redirect::to('/read')->with('message','berhasil menghapus data');
   }
   
   public function editdata($id)
   {
   	   	$this->cekhakakses();
		
       	$data= DB::table('siswa')->where('id','=',$id)->first();
	   	return View::make('/form_edit')-> with('siswa',$data);
   }
   
   public function proseseditdata()
   {
        $data = array(
	   	'nama' => Input::get('nama'),
	   	'alamat' => Input::get('alamat'),
	   	'kelas' => Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->where('id','=',Input::get('id'))->update($data);
	   return Redirect::to('/read')->with('message','berhasil mengubah data');
   }
   
   public function tambahlogin()
   {
       $activation_key = md5(date("Y-m-d H:i:s"));
       $data = array(
       		'email' => Input::get ('email'),
       		'username' => Input::get ('username'),
       		'password' => bcrypt(Input::get('password')),
       		'hak_akses' => 'user',
       		'activation_key' => $activation_key,
       		'activation_status' => 'notactive'
       		
   );
   	$msg = 'please activate your account :'. $activation_key;
   	DB::table('login')->insert($data);
	mail(Input::get('email'),"Activation Key",$msg);
	return Redirect::to('/login')->with('message','berhasil mendaftar');
   }
   
   public function login()
   {
       if(Auth::attempt(['username' => Input::get('username'),'password' =>Input::get('password')]))
	   {
	   	if (Auth::user()->activation_status=="notactive"){
	   		return Redirect::to('/login')->with('message','Akun anda belum terverifikasi');
			
	   	} else if (Auth::user()->hak_akses=="admin"){
	   		Session::put('login_status', 'loggedin');
	   		return  Redirect::to('/read');
			
	   	} else {
			Session::put('login_status', 'loggedin');
	   		return Redirect::to('/user');
		}
	   }
		else {
			echo "gagal login";
	}
		
		
   }
   
   public function logout()
   {
    Auth::logout();
	Session::put('login_status', 'loggedout');
	return Redirect::to ('login')->with ('message','berhasil logout !');   
   }
   public function activate($activation_key)
   {
   		$data = array(
			'activation_status' => 'active'
		);
   		DB::table('login')->where('activation_key','=',$activation_key)->update($data);	
   		echo "Your account has been Activate. please <a href='/'/> login </a> ";    
   }
   public function userhomepage()
   {
   	$this->ceklogin();
       return view('user');
	   
   }
   public function ubahpassword($username)
   {
   	   $data['id'] =  Auth::user()->id;
	   return View::make('ubah_password', compact('data'));
	   // $data= DB::table('login')->where('username','=',$username)->first();
	   // return View::make('ubah_passwword')-> with('login',$data);
   }
   
   public function prosesubah(Request $request)
   {
	   	  $data = array(
	   		'password' => bcrypt(Input::get('repas')),
	   		);
	   
	  	    DB::table('login')->where('id','=',Input::get('id'))->update($data);
	   		return Redirect::to('/login')->with('message','Password telah diganti,silahkan login kembali');	
   }
}
