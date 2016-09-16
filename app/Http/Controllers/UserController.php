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
       		return Redirect::to('/')-> with('message','Please, Login Again.'); 
	   		die();	
	  }
   }
   	
	public function checkAccesAccount(){
   	$this->cekLogin();
   	if (Auth::user()->hak_akses!='admin'){
       		return Redirect::to('/')-> with('message','Please, Login First');
	   		die();	
	  }
   }
   
   
	public function viewuser()
   {
   		$this->cekLogin();
       if (Auth::user()->activation_status=="banned"){
	   		return Redirect::to('user/block');
	   }
	   	$data=DB::table('siswa') ->paginate(5);
	   	return View::make('user/view')-> with('siswa',$data);
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
	   $next_time = date("Y-m-d H:i:s", strtotime('+12 hours'));
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
       		'pic'				 => $file->getClientOriginalName(),
       		'activation_date_exp'=> $next_week_date,
       		'reset_date_exp'	 => $next_time
       		
       		
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
	
	return Redirect::to('/')->with('message','Sign Up Success,please active your account');
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
   
   // public function userHomePage()
   // {
   	// $this->cekLogin();
//    	
	// if (Auth::user()->activation_status=='banned'){
	   		// return Redirect::to('user/block');
	// }
       		// return View::make('/user'); 
   // }
   
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
		   		'password' => bcrypt(Input::get('newpas'))
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
   		$this->cekLogin();
   	if (Auth::user()->activation_status=="banned"){
   		return View::make('user/block');
   	}
		return Redirect::to('/user');
       
   }
   
   public function forgetPas()
   {
		   	// $key = DB::table('login')->where('id','=',2)->get();
   		    // $date_int = strtotime($key[0]->created_at);
				// var_dump(strtotime(date('h:i')));
				
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
	       		// $date_int = strtotime($key[0]->created_at);
				// var_dump($date_int);
				
	   			return View::make('ganti_password', compact('key')); 
		} else {
		   		return Redirect::to('login')->with('message','Can not find the Key');
		   	}
		}	
   }
   
   public function picUser(){
			
		$pic = login::find(Auth::user()->id);
		return View::make('/user/dp_change', compact('pic'));
	}
	
	public function picProcess(Request $request){
	   $file = $request->file('pic');
	
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
	
	public function readData()
   {
	   	$this->cekLogin();
			
	   	$siswa=DB::table('siswa')->get();
	   	return View::make('user/user_read', compact('siswa'));
	   	
	   
   }
}
