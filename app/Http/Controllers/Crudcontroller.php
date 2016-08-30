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
	   	'nama' 		=> Input::get('nama'),
	   	'alamat' 	=> Input::get('alamat'),
	   	'kelas' 	=> Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->where('id','=',Input::get('id'))->update($data);
	   return Redirect::to('/read')->with('message','berhasil mengubah data');
   }
   
   public function tambahlogin(Request $request)
   {
   	   $this->validate($request, [
   		'email'    => 'required|unique:login|email',
        'username' => 'required|unique:login|max:10',
        'password' => 'required|max:16',
    ]);
	
	
       $activation_key = md5(date("Y-m-d H:i:s"));
       $data = array(
       		'email'				=> Input::get ('email'),
       		'username'			=> Input::get ('username'),
       		'password'  		=> bcrypt(Input::get('password')),
       		'hak_akses' 		=> 'user',
       		'activation_key' 	=> $activation_key,
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
			return Redirect::to ('/login')->with ('message','Username atau password anda salah');
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
   		$data = DB::table('login')->where('activation_key','=',$activation_key)->get();
       		if(empty($data)){
       			echo "Activation key Not valid";
       		} else {
       			$data = array(
				'activation_status' => 'active'
				);
   				DB::table('login')->where('activation_key','=',$activation_key)->update($data);	
   				echo "Your account has been Activate. please <a href='/'/> login </a> ";
       }
   }
   public function userhomepage()
   {
   	$this->ceklogin();
       return view('user');
	   
   }
   public function ubahpassword()
   {
   	   // $id_user =  Auth::user()->id;
	   // $data = DB::table('login')->where('id','=',$id_user)->get();
	   return View::make('ubah_password', compact('data'));
   }
   
   public function prosesubah(Request $request)
   {
   			$id_user = Auth::user()->id;
   			$data = DB::table('login')->where('id','=',$id_user)->get();
			
			if(!Hash::check($request->password,$data[0]->password)){
				$this-> ubahpassword('username');
				return Redirect::to('/ubahpassword/')->with('message','Password Lama Salah');
			}
			
		    if(Input::get('newpas')==Input::get('repas')){
			   $data = array(
		   		'password' => bcrypt(Input::get('newpas'))
		   		);
		   
	  	    DB::table('login')->where('id','=',$id_user)->update($data);
			
	   		return Redirect::to('/login')->with('message','Password telah diganti,silahkan login kembali');	
	   	  	} else {
	   	  		$this-> ubahpassword('username');
	   			return Redirect::to('/ubahpassword/')->with('message','konfirmasi Password Tidak Sama, Silahkan Ulangi');	
	   		}	
   }
   public function forgetpas()
   {
       return View::make('/forget_password');
   }
   
   public function prosesresetpass()
   {
      if(empty(Input::get('email'))){
       		return Redirect::to('/forgetpas')->with('message','Data Kosong, Silahkan Masukan Akun Email Anda'); 
       } else {
       		$data = DB::table('login')->where('email','=',Input::get('email'))->get();
       		if(empty($data)){
       			return Redirect::to('/forgetpas')->with('message','Akun Anda Tidak Ditemukan');
       		} else {
       			$reset_key = md5(Input::get('email').date('YMDHIS'));
				$data = array(
			   			'reset_key' => $reset_key
			    		);
			   
		       	DB::table('login')->where('email','=',Input::get('email'))->update($data);
				
				return Redirect::to('login/')->with('message','Reset key telah berhasil di kirim');
       		}
	   }
   }
   
   public function resetpass()
   {
   	   // $id_user =  Auth::user()->id;
	   // $data = DB::table('login')->where('id','=',$id_user)->get();
	   return View::make('resetpas', compact('data'));
   }
   public function resetpassss()
   {
   		return Redirect::to('login')->with('message','Masukan Activation Key pada Kolom URL');    
   }
   public function resetpas($reset_key)
   {
   		$key = DB::table('login')->where('reset_key','=',$reset_key)->get();
       	if(!empty($key)){
       		
   			return View::make('ganti_password', compact('key')); 
   			// return $key;
	   	} else {
	   		echo "Key anda tidak ditemukan";
	   	}	
        
		
		// if(Input::get('newpas')==Input::get('repas')){
			   // $data = array(
		   		// 'password' => bcrypt(Input::get('newpas'))
		   		// );
// 		   
	  	    // DB::table('login')->where('id','=',$id_user)->update($data);
// 			
	   		// return Redirect::to('/login')->with('message','Password telah diganti,silahkan login kembali');	
	   	  	// } else {
	   	  		// return Redirect::to('/resetpass/')->with('message','konfirmasi Password Tidak Sama, Silahkan Ulangi');	
	   		// }
	}

	public function ganti()
	{
		if (Input::get('newpas')!=(Input::get('repas'))) {
			return Redirect::to('/resetpas/'.Input::get('passkey'))->with('message', 'Kombinasi password tidak sama');
		}
		$data = array(
	   	'password' 		=> bcrypt(Input::get('newpas'))
	   );
	   
		 DB::table('login')->where('id','=',Auth::user()->id)->update($data);
	   return Redirect::to('/login')->with('message','berhasil mengganti password,silahkan login');
	   // return $data;
	}
}
