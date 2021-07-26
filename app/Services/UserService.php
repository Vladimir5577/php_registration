<?php

namespace App\Services;

use App\Models\User;
use Josantonius\Session\Session;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
	public function validateUserForm()
	{
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
        	$this->saveValidUserData();
        } else {
            // image upload failed
            Session::set('update_failed', 'Profile not updated');
	        return header("Location: /edit_profile");
        }
	}

	public function saveValidUserData()
	{
		$user = User::find(Session::get('auth_user_id'));

    	$user->name = $_POST['name'];
    	$user->photo = $_FILES["file-input"]["name"];
    	$user->save();

    	Session::set('update_success', 'Profile updated successfully.');
        return header("Location: /home_page");
	}

	public function getSortedUsers($sort)
	{
		switch ($_POST['order_by']) {
		    case 'name_asc':
		    	$order_name = 'asc';
		    	break;
		    case 'name_desc':
		    	$order_name = 'desc';
		    	break;
		    case 'email_asc':
		    	$order_email = 'asc';
		    	break;
		    case 'email_desc':
		    	$order_email = 'desc';
		    	break;
		    default:
		    	$order_name = 'asc';
        }

        if (isset($order_name)) {
        	$users = User::whereIsActive(true)->orderBy('name', $order_name)->get();
        }

        if (isset($order_email)) {
        	$users = User::whereIsActive(true)->orderBy('email', $order_email)->get();
        }

        return $users;
	}
}