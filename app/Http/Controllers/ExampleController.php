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

class Examplecontroller extends Controller
{

   public function index()
   {
        return View::make('gentelella/index');
   }

   public function blank()
   {
        return View::make('gentelella/blank');
   }

   public function manage()
   {
        return View::make('gentelella/manage');
   }

   public function form()
   {
        return View::make('gentelella/form');
   }

   public function outbox()
   {
        return View::make('gentelella/outbox');
   }

   public function profile()
   {
        return View::make('gentelella/profile');
   }

}
