<?php 

namespace App\Controllers;

use App\Models\User;
use App\Traits\Tocken;
use Josantonius\Session\Session;
use Valitron\Validator;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
	use Tocken;

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

	public function editProfile()
	{
		// $user = User::find(Session::get('auth_user_id'));

		$csrf = $this->generateTocken('user_form');

		echo $this->twig->render('pages/users/edit_profile.html.twig', [
			// 'user' => $user,
			'csrf' => $csrf
		]);


	}

	public function saveUserData()
	{
		dd($_POST);


		if (isset($_POST['upload'])) {
			$fileDestination = "images/" . basename($_FILES['image']['name']);
			dd($fileDestination);
			$moveFile = move_uploaded_file($_FILES['image']['tmp_name'], $fileDestination);

			$image = $_FILES['image']['name'];
			$text = $_POST['text'];

			$sql = "INSERT INTO upload_image (image, text) VALUES ('$image', '$text')";
			$result = mysqli_query($conn, $sql);

			if (!$result) {
				echo "The file did not upload";
			} else {
				echo "<script>alert('File uploaded successfully')</script>";
			}	

		}

		dd('bla');

		if (isset($_POST["upload"])) {
		    // Get Image Dimension
		    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
		    dd($fileinfo);
		    $width = $fileinfo[0];
		    $height = $fileinfo[1];
		    
		    $allowed_image_extension = array(
		        "png",
		        "jpg",
		        "jpeg"
		    );
		    
		    // Get image file extension
		    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
		    
		    // Validate file input to check if is not empty
		    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
		        $response = array(
		            "type" => "error",
		            "message" => "Choose image file to upload."
		        );
		    }    // Validate file input to check if is with valid extension
		    else if (! in_array($file_extension, $allowed_image_extension)) {
		        $response = array(
		            "type" => "error",
		            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
		        );
		        echo $result;
		    }    // Validate image file size
		    else if (($_FILES["file-input"]["size"] > 2000000)) {
		        $response = array(
		            "type" => "error",
		            "message" => "Image size exceeds 2MB"
		        );
		    }    // Validate image file dimension
		    else if ($width > "300" || $height > "200") {
		        $response = array(
		            "type" => "error",
		            "message" => "Image dimension should be within 300X200"
		        );
		    } else {
		        $target = "image/" . basename($_FILES["file-input"]["name"]);
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

		dd('Finish');

		$_POST['captcha_session'] = Session::get('captcha');

        $v = new Validator($_POST);
        $v->rule('required', ['name', 'photo']);
        $v->rule('lengthMin', 'password', 4);
        $v->rule('equals', 'captcha', 'captcha_session')
            ->message('Captcha ' . Session::get('captcha'));

        if($v->validate()) {
            $this->saveValidUserData();
        } else {
            echo json_encode($v->errors());
        }
	}
}