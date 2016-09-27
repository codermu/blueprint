<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class HistoryController extends Controller
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
}
