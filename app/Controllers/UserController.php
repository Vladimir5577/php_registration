<?php 

namespace App\Controllers;

use App\Models\User;
use App\Traits\Tocken;
use Josantonius\Session\Session;
use App\Services\UserService;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
	use Tocken;

	public function homePage()
	{
		// dd(Session::id());

		$auth_user_id = Session::get('auth_user_id');
		$user = User::find($auth_user_id);
		// dd($user);

		if ($user) {
			echo $this->twig->render('pages/users/user_home.html.twig', [
				'user' => $user,
				'update_success' => Session::pull('update_success'),
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
	    
	    $allowed_image_extension = array("png", "jpg","jpeg");
	    
	    // Get image file extension
	    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
	    
	    // Validate file input to check if is not empty
	    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
	    	Session::set('error_image', 'Choose an image file.');
	    	return header("Location: /edit_profile");
	    }    

	    // Validate file input to check if is with valid extension
	    if (! in_array($file_extension, $allowed_image_extension)) {
	    	Session::set('error_image', 'Image file not valid. Only JPEG, JPG, PNG format are allowed.');
	    	return header("Location: /edit_profile");
	    }   

	     // Validate image file size
	    if (($_FILES["file-input"]["size"] > 2000000)) {
	    	Session::set('error_image', 'Image size exceeds 2MB');
	        return header("Location: /edit_profile");
	    }

	    // validate name field
	    if (!$_POST['name']) {
	    	Session::set('error_name', 'Name is requered!');
	        return header("Location: /edit_profile");
	    }
	    
    	// save image
        $target = 'uploads/images/' . basename($_FILES["file-input"]["name"]);
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
        	// image upload success
        	
        	$user = User::find(Session::get('auth_user_id'));

        	$user->name = $_POST['name'];
        	$user->photo = $_FILES["file-input"]["name"];
        	$user->save();

        	Session::set('update_success', 'Profile updated successfully.');
	        return header("Location: /home_page");
        } else {
            // image upload failed
            Session::set('update_failed', 'Profile not updated');
	        return header("Location: /edit_profile");
        }

		dd('Finish');
	}
}