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

use App\Models\login;
use App\Models\siswa;


class Crudcontroller extends Controller
{
	
   public function cekHakAkses(){
   	$this->ceklogin();
   	if (Auth::user()->hak_akses!='admin'){
       		echo 'You can not access this page. please  <a href="/user"> click here </a> '; 
	   		die();	
	  }
   }
   public function cekLogin()
   {
   		$login_status = Session::get('login_status');
		// var_dump($login_status);
   		if ($login_status=='loggedout'){
       		echo 'login <a href="/login"> please  </a> '; 
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
	   return Redirect::to('/read')->with('message','Input data success');
   }
   
   public function lihatdata()
   {
        $this->cekhakakses();
		
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('read')-> with('siswa',$data);
	   
   }
   
   public function viewuser()
   {
       
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('view')-> with('siswa',$data);
   }
   
   public function hapusdata($id)
   {
   		$this->cekhakakses();
       	
       	
       	DB::table('siswa') ->where ('id','=',$id)->delete();
	    return Redirect::to('/read')->with('message','Data has been Deleted');
   }
   
   public function editdata($id)
   {
   	   	$this->cekhakakses();
		
       	$data = siswa::find($id);
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
	   return Redirect::to('/read')->with('message','Data has been Changed');
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
   
	DB::table('login')->insert($data);
   
   	// $to=Input::get('email');
	// $subject='festiware account activation';
	// $msg = 'please activate your account via this link http://festiware.com/activate/'. $activation_key;
// 	
	// mail($to,$subject,$msg);
	
	// registration 
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
	   		return Redirect::to('/login')->with('message','your account cannot verification');
			
	   	} else if (Auth::user()->hak_akses=="admin"){
	   		Session::put('login_status', 'loggedin');
	   		return  Redirect::to('/read');
			
	   	} else {
			Session::put('login_status', 'loggedin');
	   		return Redirect::to('/user');
		}
	   }
		else {
			return Redirect::to ('/login')->with ('message','Username or password is wrong');
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
			   return Redirect::to ('/login')-> with('message', 'Please Input Your Activation Key.');
		   }else{	
		   		$data = DB::table('login')->where('activation_key','=',$activation_key)->get();
		       		if(empty($data)){
		       			echo "Activation key is Not valid";
		       		} else {
		       			$data = array(
						'activation_status' => 'active'
						);
		   				DB::table('login')->where('activation_key','=',$activation_key)->update($data);	
		   				return Redirect::to('/login')->with ('message', 'your account has been activate,please login') ;
		      	 }
		   }
   }
   public function userhomepage()
   {
   	$this->ceklogin();
       return view('user');
	   
   }
   public function ubahpassword()
   {
	   return View::make('ubah_password', compact('data'));
   }
   
   public function prosesubah(Request $request)
   {
   			$id_user = Auth::user()->id;
   			$data = DB::table('login')->where('id','=',$id_user)->get();
			
			if(!Hash::check($request->password,$data[0]->password)){
				$this-> ubahpassword('username');
				return Redirect::to('/ubahpassword/')->with('message','Old password is wrong');
			}
			
		    if(Input::get('newpas')==Input::get('repas')){
			   $data = array(
		   		'password' => bcrypt(Input::get('newpas'))
		   		);
		   
	  	    DB::table('login')->where('id','=',$id_user)->update($data);
			
	   		return Redirect::to('/login')->with('message','Password has been changed,please login');	
			
	   	  	} else {
	   	  		$this-> ubahpassword('username');
	   			return Redirect::to('/ubahpassword/')->with('message','password combination is not the same');	
	   		}	
   }
   public function forgetpas()
   {
       return View::make('/forget_password');
   }
   
   public function prosesresetpass()
   {
      if(empty(Input::get('email'))){
       		return Redirect::to('/forgetpas')->with('message','Data is empty,please input your email account'); 
       } else {
       		$data = DB::table('login')->where('email','=',Input::get('email'))->get();
       		if(empty($data)){
       			return Redirect::to('/forgetpas')->with('message','Your account can not find');
       	} else {
       			$reset_key = md5(Input::get('email').date('YMDHIS'));
				$data = array(
			   			'reset_key' => $reset_key
			    		);
			   
		       	DB::table('login')->where('email','=',Input::get('email'))->update($data);
				
				// $to=Input::get('email');
				// $subject='festiware reset password';
				// $msg = 'please change your password account via this link http://festiware.com/resetpas/'. $reset_key;
// 				
				// mail($to,$subject,$msg);
				
				$root_url='http://festiware.com';
				$reset_link= $root_url. '/resetpas/'. $reset_key ; 
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
   
   public function resetpass()
   {
	   return View::make('resetpas', compact('data'));
   }
   
   public function resetpas($reset_key="")
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
     public function gantipas()
	{
		if (Input::get('newpas')!=(Input::get('repas'))) {
			return Redirect::to('/resetpas/'.Input::get('passkey'))->with('message', 'password combination is not the same');
		}
		
		$data = array(
	   	'password' 		=> bcrypt(Input::get('newpas'))
	   );
	   
		 DB::table('login')->where('reset_key','=',Input::get('passkey'))->update($data);
		 
		return Redirect::to('/login')->with('message','Password has been changed,please login');
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
