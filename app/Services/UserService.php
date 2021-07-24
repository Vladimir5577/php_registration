<?php

namespace App\Services;

use Josantonius\Session\Session;
use App\Controllers\UserController;

class UserService
{
	public function validateUserForm()
	{
		$userController = new UserController;

		 $allowed_image_extension = array(
		        "png",
		        "jpg",
		        "jpeg"
		    );
		    
		    // Get image file extension
		    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
		    
		    // Validate file input to check if is not empty
		    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
		    	Session::set('error_image', 'Choose an image file.');
		    	return $userController->editProfile();
		    }    

		    // Validate file input to check if is with valid extension
		    else if (! in_array($file_extension, $allowed_image_extension)) {
		    	Session::set('error_image', 'Image file not valid. Only JPEG, JPG, PNG format are allowed.');
		    	return $userController->editProfile();
		    }   

		     // Validate image file size
		    else if (($_FILES["file-input"]["size"] > 2000000)) {
		        $response = array(
		            "type" => "error",
		            "message" => "Image size exceeds 2MB"
		        );
		    }    

		    else {
		    	// dd('Image exist');
		        $target = 'uploads/images/' . basename($_FILES["file-input"]["name"]);
		        // dd($target);
		        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
		            $response = array(
		                "type" => "success",
		                "message" => "Image uploaded successfully."
		            );
		        } else {
		            $response = array(
		                "type" => "error",
		                "message" => "Problem in uploading image files."
		            );
		        }
		    }
	}

	public function saveValidUserData()
	{

	}
}