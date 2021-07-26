<?php 

namespace App\Controllers;

use App\Models\User;
use App\Traits\Tocken;
use App\Services\UserService;
use Josantonius\Session\Session;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
	use Tocken;

	public function index()
	{	
		return $this->homePage();
	}

	public function homePage()
	{
		$auth_user_id = Session::get('auth_user_id');
		$user = User::find($auth_user_id);

		if ($user) {
			echo $this->twig->render('pages/users/user_home.html.twig', [
				'user' => $user,
				'update_success' => Session::pull('update_success'),
				'email_confirmed_failed' => Session::pull('email_confirmed_failed'),
				'email_confirmed_successfully' => Session::pull('email_confirmed_successfully'),
			]);

			return;  
		}

		return header("Location: /register");
	}

	public function editProfile()
	{
		$user = User::find(Session::get('auth_user_id'));

		$csrf = $this->generateTocken('user_form');

		if ($user) {
			echo $this->twig->render('pages/users/edit_profile.html.twig', [
				'user' => $user,
				'csrf' => $csrf,
				'error_name' => Session::pull('error_name'),
				'error_image' => Session::pull('error_image'),
				'error_csrf' => Session::pull('error_csrf'),
				'update_failed' => Session::pull('update_failed'),
				'update_success' => Session::pull('update_success'),
			]);
			return;
		}
		

		return header("Location: /register");
	}

	public function saveUserData()
	{
		// validate csrf
		if (!$this->validateTocken($_POST['csrf'])) {
            Session::set('error_csrf', '419 Page has been expired! Please refresh the page!');
	    	return header("Location: /edit_profile");
        } 
	   
	   (new UserService)->validateUserForm();
	}

	public function getUsers()
    {
    	$auth_user_id = Session::get('auth_user_id');

    	if ($auth_user_id) {
    		$users = User::whereIsActive(true)->orderBy('name', 'asc')->get();

	    	echo $this->twig->render('pages/users/users_wiev.html.twig', [
				'users' => $users,
			]);
			return;
    	}

    	return header("Location: /register");
    }

    public function getUsersBySort()
    {
    	$auth_user_id = Session::get('auth_user_id');

    	if ($auth_user_id) {

			$userService = new UserService;
			$users = $userService->getSortedUsers($_POST);

	    	echo $this->twig->render('pages/users/users_wiev.html.twig', [
				'users' => $users,
			]);
			return;
    	}

    	return header("Location: /register");
    }
}