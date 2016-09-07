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


class Crudcontroller extends Controller
{
	
   public function checkAccesAccount(){
   	$this->cekLogin();
   	if (Auth::user()->hak_akses!='admin'){
       		echo 'You can not access this page. please  <a href="/user"> click here </a> '; 
	   		die();	
	  }
   }
   public function cekLogin()
   {
   		$login_status = Session::get('login_status');
		if ($login_status=='loggedout'){
       		echo 'login <a href="/login"> please  </a> '; 
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
        $this->checkAccesAccount();
		
	   	$siswa=DB::table('siswa') ->paginate(5);
	   	$login=DB::table('login') ->paginate(5);
	   	return View::make('read', compact('siswa','login'));
	   	
	   
   }
   
   public function viewuser()
   {
       
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('view')-> with('siswa',$data);
   }
   
   public function deleteData($id)
   {
   		$this->checkAccesAccount();
       	
       	
       	DB::table('siswa') ->where ('id','=',$id)->delete();
	    return Redirect::to('/read')->with('message','Data has been Deleted');
   }
   
   public function editData($id)
   {
   	   	$this->checkAccesAccount();
		
       	$data = siswa::find($id);
       	return View::make('/form_edit')-> with('siswa',$data);
   }
   
   public function editDataProcess()
   {
        $data = array(
	   	'nama' 		=> Input::get('nama'),
	   	'alamat' 	=> Input::get('alamat'),
	   	'kelas' 	=> Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->where('id','=',Input::get('id'))->update($data);
	   return Redirect::to('/read')->with('message','Data has been Changed');
   }
   
   public function addLog(Request $request)
   {
   	   $this->validate($request, [
   		'email'    => 'required|unique:login|email',
        'username' => 'required|unique:login|max:10',
        'password' => 'required|max:16',
    ]);
	
	$file = $request->file('pic');
	
       $activation_key = md5(date("Y-m-d H:i:s"));
       $data = array(
       		'email'				=> Input::get ('email'),
       		'username'			=> Input::get ('username'),
       		'password'  		=> bcrypt(Input::get('password')),
       		'hak_akses' 		=> 'user',
       		'activation_key' 	=> $activation_key,
       		'activation_status' => 'notactive',
       		'pic'				=> $file->getClientOriginalName()
       
       		
   );
   
   	
	$file->move(public_path().'/img',$file->getClientOriginalName());
	   
	DB::table('login')->insert($data);
   
   	$root_url='http://festiware.com';
	$activation_link= $root_url. '/activate/'. $activation_key ;
    $to             = Input::get('email');
    $subject        = 'festiware account activation';
    $template_id    = "25ef503b-f23a-47a3-8795-66b0a7bc0964";
    $message_data_container  = 
                array(
                    '::fullname'=>array(Input::get('email')),
                    '::activation_link'=>array($activation_link)
                );
    $this->send_email_using_3rd_party($template_id, $to, $subject, $message_data_container);
	
	return Redirect::to('/login')->with('message','Sign Up Success,please active your account');
   }
   
   public function login()
   {
       if(Auth::attempt(['username' => Input::get('username'),'password' =>Input::get('password')]))
	   {
	   	if (Auth::user()->activation_status=="notactive"){
	   		return Redirect::to('/login')->with('message','Your account is Unverified');
			
	   	} else if (Auth::user()->hak_akses=="admin"){
	   		Session::put('login_status', 'loggedin');
	   		return  Redirect::to('/read');
			
	   	} else {
			Session::put('login_status', 'loggedin');
	   		return Redirect::to('/user');
		}
	   }
		else {
			return Redirect::to ('/login')->with ('message','Username or Password is Wrong');
	}
		
		
   }
   
   public function logout()
   {
    Auth::logout();
	Session::put('login_status', 'loggedout');
	return Redirect::to ('login')->with ('message','Logout Success');   
   }
   public function activate($activation_key="")
   {
   		if (empty($activation_key)) {
			   return Redirect::to ('/login')-> with('message', 'Please take your Activation key on your Email.');
		   }else{	
		   		$data = DB::table('login')->where('activation_key','=',$activation_key)->get();
		       		if(empty($data)){
		       			return Redirect::to('/login')->with ('message', 'Activation keys can not be found') ;
		       		} else {
		       			$data = array(
						'activation_status' => 'active'
						);
		   				DB::table('login')->where('activation_key','=',$activation_key)->update($data);	
		   				return Redirect::to('/login')->with ('message', 'Your account has been Activate,please Login') ;
		      	 }
		   }
   }
   public function userHomePage()
   {
   	$this->ceklogin();
	if (Auth::user()->activation_status=="banned"){
	   		return Redirect::to('/block-user');
	}
       return view('user');
	   
   }
   public function changePassword()
   {
	   return View::make('ubah_password', compact('data'));
   }
   
   public function changeProcess(Request $request)
   {
   			$id_user = Auth::user()->id;
   			$data = DB::table('login')->where('id','=',$id_user)->get();
			
			if(!Hash::check($request->password,$data[0]->password)){
				$this-> changePassword('username');
				return Redirect::to('/change-password/')->with('message','Old password is wrong');
			}
			
		    if(Input::get('newpas')==Input::get('repas')){
			   $data = array(
		   		'password' => bcrypt(Input::get('newpas'))
		   		);
		   
	  	    DB::table('login')->where('id','=',$id_user)->update($data);
			
	   		return Redirect::to('/login')->with('message','Password has been changed,please login');	
			
	   	  	} else {
	   	  		$this-> changePassword('username');
	   			return Redirect::to('/change-password/')->with('message','Password combination is not same');	
	   		}	
   }

   public function blockUser()
   {
       return View::make('block');
   }
   public function forgetPas()
   {
		return View::make('/forget_password');
   }
   
   public function processResetPass()
   {
      if(empty(Input::get('email'))){
       		return Redirect::to('/forget-pas')->with('message','Data is empty,please input your email account'); 
       } else {
       		$data = DB::table('login')->where('email','=',Input::get('email'))->get();
       		if(empty($data)){
       			return Redirect::to('/forget-pas')->with('message','Your account can not find');
       	} else {
       			$reset_key = md5(Input::get('email').date('YMDHIS'));
				$data = array(
			   			'reset_key' => $reset_key
			    		);
			   
		       	DB::table('login')->where('email','=',Input::get('email'))->update($data);
				
				$root_url='http://festiware.com';
				$reset_link= $root_url. '/reset-pass/'. $reset_key ; 
			    $to             = Input::get('email');
			    $subject        = 'festiware reset password';
			    $template_id    = "a63bcf55-d300-4f3e-a508-d4a1a178b329";
			    $message_data_container  = 
			                array(
                    '::fullname'=>array(Input::get('email')),
                    '::reset_password_link'=>array($reset_link)
                );
    				$this->send_email_using_3rd_party($template_id, $to, $subject, $message_data_container);
				
				return Redirect::to('login/')->with('message','Reset key has been send');
       		}
	   }
   }
   

   public function resetPass($reset_key="")
   {
   		if (empty($reset_key)){
   			return Redirect::to('login')->with('message','Please Input Your Reset Key');
   		} else {
	   		$key = DB::table('login')->where('reset_key','=',$reset_key)->get();
	       	if(!empty($key)){
	       		
	   			return View::make('ganti_password', compact('key')); 
		} else {
		   		return Redirect::to('login')->with('message','Can not find the Key');
		   	}
		}	
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
       	return View::make('/admin_password')-> with('login',$data);
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
		return View::make('edituser',compact('login','hak_akses','activation_status'));
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
	
	public function picUser(){
			
		$pic = login::find(Auth::user()->id);
		return View::make('dp_change', compact('pic'));
	}
	
	public function picProcess(Request $request){
	   $file = $request->file('pic');
	
       $data = array(
       		'pic'				=> $file->getClientOriginalName()
       );
   		
		$old_image = DB::table('login')->select('pic')->where('id','=',Auth::user()->id)->get();
	
		// $photo=DB::table('login')->where('id','=',Auth::user('id'));
		
   		$file->move(public_path().'/img',$file->getClientOriginalName());
		file::delete(public_path().'/img/'.$old_image[0]->pic);
		
		DB::table('login')->where('id','=',Input::get('id'))->update($data);
		// return $data;
		return Redirect::to('user')->with('message','Photo Has Ben Uploaded');
	}
	public function send_email_using_3rd_party($template_id, $email, $subject, $message_data_container, $email_cc=""){
        $json_string = array(
          'to' => array($email),'sub' => $message_data_container,'category' => 'test_category',
          "filters" => array("templates" => array("settings" => array("enable" => 1,"template_id" => $template_id))));
        $params = array(
            'api_user'  => 'workforce.id','api_key'=> 'pass@word1','x-smtpapi' => json_encode($json_string),
            'to'        => $email,'cc'        => $email_cc,'subject'   => $subject,
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
