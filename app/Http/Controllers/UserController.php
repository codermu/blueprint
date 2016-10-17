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


class UserController extends Controller
{
	public function cekLogin()
   {
   		$login_status = Session::get('login_status');
		if ($login_status=='loggedout'){
       		return Redirect::to('/')->with('message','Login Please'); 
		}
   }
   	
	public function checkAccesAccount(){
   	$this->cekLogin();
   	if (Auth::user()->hak_akses!='admin'){
       		return Redirect::to('/')-> with('message','Please, Login First');
	   		die();	
	  }
   }
	
   public function dataSis(){
   	return View::make('admin/add_sis');
   }
   
   public function addData()
   {
       $data = array(
	   	'nama' => Input::get('nama'),
	   	'alamat' => Input::get('alamat'),
	   	'kelas' => Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->insert($data);
	   return Redirect::to('/user_read')->with('message','Input data success');
   }
   
   
	public function viewuser()
   {
   		$this->cekLogin();
       if (Auth::user()->activation_status=="banned"){
	   		return Redirect::to('user/block');
	   }
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('user/profileuser')-> with('siswa',$data);
   }
   
   public function register()
   {
       return view::make('user/register');
   }
   
   public function newUser(){
   	$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
		
   	return view::make('user/new_user');
   }
   
   public function notActive(){
   	$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
	
   	$login=DB::table('login')->get();
   	return view::make('user/notactive_user',compact('login'));
   }
   
   public function addLog(Request $request)
   {
   	   $this->validate($request, [
   		'email'    => 'required|unique:login|email',
        'username' => 'required|unique:login|max:10',
        'password' => 'required|max:16',
    ]);
	
	$file = $request->file('pic');
	
	
	   $today = date("Y-m-d H:i:s");
	   $next_week_date = date("Y-m-d H:i:s", strtotime("+1 week"));
	   // return $today;
	   // return $next_week_date;
       $activation_key = md5(date("Y-m-d H:i:s"));
       $data = array(
       		'email'				 => Input::get ('email'),
       		'username'			 => Input::get ('username'),
       		'password'  		 => bcrypt(Input::get('password')),
       		'hak_akses' 		 => 'user',
       		'activation_key' 	 => $activation_key,
       		'activation_status'  => 'notactive',
       		'activation_date_exp'=> $next_week_date,
       		
       		
   );
   
	   
	DB::table('login')->insert($data);
   
   	$root_url='http://festiware.com';
	$activation_link= $root_url.'/activate/'.$activation_key ;
    $to             = Input::get('email');
    $subject        = 'festiware account activation';
    $template_id    = "25ef503b-f23a-47a3-8795-66b0a7bc0964";
    $message_data_container  = 
                array(
                    '::fullname'=>array(Input::get('email')),
                    '::activation_link'=>array($activation_link)
                );
    $this->send_email_using_3rd_party($template_id, $to, $subject, $message_data_container);
	
	Session::set('message','Your Account Has Been Created, Check Your Email And Verified Your Account ');
	Session::set('user_fullname',Input::get ('username'));
	Session::set('user_email',Input::get ('email'));
	
	Session::put('login_status', 'loggedin');
	return Redirect::to('new-user');
   }

	public function activate($activation_key="")
   {
   		$today = date("Y-m-d H:i:s");
   		if (empty($activation_key)) {
			   return Redirect::to ('/')-> with('message', 'Please take your Activation key on your Email.');
		   }else{
		   	$exp1=DB::table('login')->where('activation_key','=',$activation_key)->get();
			// return $exp1;
			$next1=$exp1[0]->activation_date_exp;
			$next1 = strtotime($next1);
			// return strtotime($exp1[0]->activation_date_exp);
			$now1=strtotime($today);
 
		if($now1 > $next1) {
				return Redirect::to('/')->with('message','Your activation key has been expired, please contact our Administrator or simply create your new account again');
		
			}else {	
		   		$data = DB::table('login')->where('activation_key','=',$activation_key)->get();
		       		if(empty($data)){
		       			return Redirect::to('/')->with ('message', 'Activation keys can not be found') ;
		       		} else {
		       			$data = array(
						'activation_status' => 'active'
						);
		   				DB::table('login')->where('activation_key','=',$activation_key)->update($data);	
		   				return Redirect::to('/')->with ('message', 'Your account has been Activate,please Login') ;
		      	 }
		   }
   }
   }

   public function sendKey(){
   		$activation_key = md5(date("Y-m-d H:i:s"));
		$next_week_date = date("Y-m-d H:i:s", strtotime("+1 week"));
       $data = array(
       		'activation_key' 	 => $activation_key,
       		'activation_date_exp' => $next_week_date
   );
   
   	
	   
	DB::table('login')->where('id','=',Input::get('id'))->update($data);
   
   	$root_url='http://festiware.com';
	$activation_link= $root_url.'/activate/'.$activation_key ;
    $to             = Input::get('email');
    $subject        = 'festiware account activation';
    $template_id    = "25ef503b-f23a-47a3-8795-66b0a7bc0964";
    $message_data_container  = 
                array(
                    '::fullname'=>array(Auth::user()->email),
                    '::activation_link'=>array($activation_link)
                );
    $this->send_email_using_3rd_party($template_id, $to, $subject, $message_data_container);
	return Redirect::to('notactive')->with('message','Activation Key Has Been Send');
   }
   
   public function addUser(){
   		return View::make('admin/add_user');	
   }
   
   public function deleteData($id)
   {
   		$this->checkAccesAccount();
       	
       	
       	DB::table('siswa') ->where ('id','=',$id)->delete();
	    return Redirect::to('/user_read')->with('message','Data has been Deleted');
   }
   
   public function editData($id)
   {
   	   	$this->checkAccesAccount();
		
       	$data = siswa::find($id);
       	return View::make('user/form_edit')-> with('siswa',$data);
   }
   
   public function editDataProcess()
   {
        $data = array(
	   	'nama' 		=> Input::get('nama'),
	   	'alamat' 	=> Input::get('alamat'),
	   	'kelas' 	=> Input::get('kelas'),
	   );
	   
	   DB::table('siswa')->where('id','=',Input::get('id'))->update($data);
	   return Redirect::to('/user_read')->with('message','Data has been Changed');
   }
   
   public function changePassword()
   {
	   return View::make('user/ubah_password', compact('data'));
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
		   		'password' => bcrypt(Input::get('newpas')),
				
		   		);
		   
	  	    DB::table('login')->where('id','=',$id_user)->update($data);
			
	   		return Redirect::to('/')->with('message','Password has been changed,please login');	
			
	   	  	} else {
	   	  		$this-> changePassword('username');
	   			return Redirect::to('/change-password/')->with('message','Password combination is not same');	
	   		}	
   }

   public function blockUser()
   {
   	$cekLogin = $this->cekLogin();	
	if($cekLogin!="") return $cekLogin;
   	
   	if (Auth::user()->activation_status=="banned"){
   		Session::put('login_status', 'loggedin');
   		return View::make('user/block');
   	}
		return Redirect::to('/profileuser');
       
   }
   
   public function forgetPas()
   {
		return View::make('/user/forget_password');
   }
   
   public function processResetPass()
   {
      if(empty(Input::get('email'))){
       		return Redirect::to('forget-pas')->with('message','Data is empty,please input your email account'); 
       } else {
       		$data = DB::table('login')->where('email','=',Input::get('email'))->get();
       		if(empty($data)){
       			return Redirect::to('forget-pas')->with('message','Your account can not find');
       	} else {
       			$reset_key = md5(Input::get('email').date('YMDHIS'));
				$next_time = date("Y-m-d H:i:s", strtotime('+12 hours'));
				$data = array(
			   			'reset_key' => $reset_key,
			   			'reset_date_exp'	 => $next_time
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
				
				return Redirect::to('/')->with('message','Reset key has been sent,please check your email');
       		}
	   }
   }
   

   public function resetPass($reset_key="")
   {
   		$today = date("Y-m-d H:i:s");
   		if (empty($reset_key)){
   			return Redirect::to('/')->with('message','Please Input Your Reset Key');
   		} else {
   			$exp=DB::table('login')->where('reset_key','=',$reset_key)->get();
			
			$next=$exp[0]->reset_date_exp;
			$next = strtotime($next);
			$now=strtotime($today);
		if($now > $next) {
				return Redirect::to('/forget-pas')->with('message','Your forget password key has been expired, please retry the process to get the key.');
		
			}else {
				
	   		$key = DB::table('login')->where('reset_key','=',$reset_key)->get();
	       	if(!empty($key)){
	   			return View::make('user.ganti_password', compact('key')); 
		} else {
		   		return Redirect::to('/')->with('message','Can not find the Key');
		   	}
		}
		
		}
   }
   
   
   public function picUser(){
			
		$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
		
		$pic = login::find(Auth::user()->id);
		return View::make('/user/changepic', compact('pic'));
	}
	
	public function picProcess(Request $request){
	   $file = $request->file('pic');
		
		if(empty($file)){
			return Redirect::to('pic-user')->with('message','Please, Insert Your Photo.');
		} else {
		
	       $data = array(
	       		'pic'				=> $file->getClientOriginalName()
	       );
	   		
			$old_image = DB::table('login')->select('pic')->where('id','=',Auth::user()->id)->get();
			
	   		$file->move(public_path().'/img',$file->getClientOriginalName());	
			file::delete(public_path().'/img/'.$old_image[0]->pic);
			
			DB::table('login')->where('id','=',Input::get('id'))->update($data);
			// return $data;
			return Redirect::to('user')->with('message','Photo Has Ben Uploaded');
		}
	}
	
	public function readData()
   {
	   	$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
			
	   	$siswa=DB::table('siswa')->get();
	   	return View::make('admin/user_read', compact('siswa'));
	   	
	   
   }
   
   public function readUser()
   {
	   	$cekLogin = $this->cekLogin();	
		if($cekLogin!="") return $cekLogin;
			
	   	$siswa=DB::table('siswa')->get();
	   	return View::make('user/read_user', compact('siswa'));
	   	
	   
   }
   
   public function userPro(){
   		return View::make('user/profileuser');
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