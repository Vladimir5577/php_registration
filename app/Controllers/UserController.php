<?php 

namespace App\Controllers;

use App\Models\User;
use Josantonius\Session\Session;

class UserController extends Controller
{
	public function homePage()
	{
		// dd(Session::get('auth_user_id'));

		$auth_user_id = Session::get('auth_user_id');

		// if ($auth_user_id) {
			$user = User::find($auth_user_id);
			echo $this->twig->render('pages/users/user_home.html.twig', [
				'user' => $user,
			]);  
		// }

		// dd('not autn');
     	// echo $this->twig->render('pages/users/user_home.html.twig');   
	}
}