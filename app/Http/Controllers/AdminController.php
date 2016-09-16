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
use File;

use App\Models\login;
use App\Models\siswa;


class AdminController extends Controller
{
	public function index()
	{
		return View::make ('login');
	}
   
   public function cekLogin()
   {
   		$login_status = Session::get('login_status');
		if ($login_status=='loggedout'){
       		return redirect('/')->with('message','Please Login Again.');	
	  } else {
	  	return "";
	  }
       
   }
   	
   public function checkAccesAccount(){
   	
   	$cekLogin = $this->cekLogin();	
	if($cekLogin!="") return $cekLogin;	
   	
   	if (Auth::user()->hak_akses!='admin'){
       		return Redirect::to('/user')->with('message','You Cant Acces Thats Page.');
	   		die();	
	  }
   }
   
   public function addData()
   {
       $data = array(
	   	'nama' => Input::get('nama'),
	   	'alamat' => Input::get('alamat'),
	   	'kelas' => Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->insert($data);
	   return Redirect::to('/read')->with('message','Input data success');
   }
   
   public function readData()
   {
   		$cekAkses = $this->checkAccesAccount();
		if($cekAkses!="") return $cekAkses;
		
		
	   	$login=DB::table('login') ->get();
	   	return View::make('admin/admin_read', compact('login'));
	   	
	   
   }
   
   public function login()
   {
       if(Auth::attempt(['username' => Input::get('username'),'password' =>Input::get('password')]))
	   {
	   	if (Auth::user()->activation_status=="notactive"){
	   		return Redirect::to('/')->with('message','Your account is Unverified');
			
	   	} else if (Auth::user()->hak_akses=="admin"){
	   		Session::put('login_status', 'loggedin');
	   		return  Redirect::to('/read');
			
	   	} else {
			Session::put('login_status', 'loggedin');
	   		return Redirect::to('/user');
		}
	   }
		else {
			return Redirect::to ('/')->with ('message','Username or Password is Wrong');
	}
		
		
   }
   
	public function logout()
	   {
	    Auth::logout();
		Session::put('login_status', 'loggedout');
		return Redirect::to('/')->with ('message','Logout Success');   
	   }
	   
	   
   
   	 public function userHomePage(){
   	 	
		$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
   	
		if (Auth::user()->activation_status=='banned'){
	   		return Redirect::to('user/block');
		}
       		return View::make('/user'); 
   		}
     public function changePass()
	{
		if (Input::get('newpas')!=(Input::get('repas'))) {
			return Redirect::to('/reset-pass/'.Input::get('passkey'))->with('message', 'password combination is not the same');
		}
		
		$data = array(
	   	'password' 		=> bcrypt(Input::get('newpas'))
	   );
	   
		 DB::table('login')->where('reset_key','=',Input::get('passkey'))->update($data);
		 
		return Redirect::to('/login')->with('message','Password has been changed,please login');
	}
	
	public function adminChange($id)
	{
		$this->checkAccesAccount();
				
		$data = login::find($id);
       	return View::make('admin/admin_changepas')-> with('login',$data);
	}
	
	public function adminProcessPas()
	{
		if (empty(Input::get('newpas'))){
			return Redirect::to('admin-change/'. input::get('id'))->with('message','Password is empty');
		}
		if(Input::get('newpas')==Input::get('repas')){
			   $data = array(
		   		'password' => bcrypt(Input::get('newpas'))
		   		);
		   
	  	    DB::table('login')->where('id','=',Input::get('id'))->update($data);
			
	   		return Redirect::to('/read')->with('message','Password has been changed');	
			
	   	  	} else {
	   	  		return Redirect::to('/admin-change/'. Input::get('id'))->with('message','Password combination is not same');	
			}
		
	}
	
	public function editUser($id)
	{
		$this->checkAccesAccount();
				
		$login = login::find($id);
		$hak_akses = login::select('hak_akses')->distinct()->get();
		$activation_status = login::select('activation_status')->distinct()->get();
		// return $activation;
		// return $hak_akses;
		return View::make('/admin/user_edit',compact('login','hak_akses','activation_status'));
	}
	
	public function userProcess()
	{
		$data = array(
		   		'username' => Input::get('username'),
		   		'email' => Input::get('email'),
		   		'hak_akses' => Input::get('hak_akses'),
		   		'activation_status' => Input::get('activation_status')
		   		);
		   
		   	
	  	    DB::table('login')->where('id','=',Input::get('id'))->update($data);
			
	   		return Redirect::to('/read')->with('message','User has been changed');
	}
	
	public function send_email_using_3rd_party($template_id, $email, $subject, $message_data_container, $email_cc=""){
        $json_string = array(
          'to' => array($email),'sub' => $message_data_container,'category' => 'test_category',
          "filters" => array("templates" => array("settings" => array("enable" => 1,"template_id" => $template_id))));
        $params = array(
            'api_user'  => 'workforce.id','api_key'=> 'pass@word1','x-smtpapi' => json_encode($json_string),
            'to'        => $email,'cc'  => $email_cc, 'subject'   => $subject,
            'html'      => " ",'text'=> " ",'from'=> 'no-reply@indosystem.com');
			
        $request =  'https://api.sendgrid.com/api/mail.send.json';
        $session = curl_init($request);
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_SSLVERSION, 6);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        curl_close($session);  
        if(!isset($response->errors)) return true;
        else return $response->message;
    }
}
