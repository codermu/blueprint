<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Datetime;

const DEFAULT_URL = 'https://conf-aba18.firebaseio.com';
const DEFAULT_TOKEN = 'AIzaSyAAYvzzPAjNC0AYQcm3ka1xnrviXrs5iPw';
const DEFAULT_PATH = '/data';


class FirebaseController extends Controller
{
	public function main() {
		
		$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
		
		// --- storing an array ---
		$test = array(
		    "foo" => "bar",
		    "i_love" => "lamp",
		    "id" => 42
		);
		$dateTime = new DateTime();
		$firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);
		
		// --- storing a string ---
		$firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");
		
		// --- reading the stored string ---
		$name = $firebase->get("0");		
		
		echo $name;
		
		return view('firebase');
	}
	
	
	
}