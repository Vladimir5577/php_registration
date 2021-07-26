<?php

namespace App\Controllers\Api;

use Phpass\Hash;
use App\Models\User;
use App\Traits\Tocken;
use App\Services\AuthService;
use App\Controllers\Controller;
use Phpass\Hash\Adapter\Pbkdf2;
use Josantonius\Session\Session;
use Spatie\ArrayToXml\ArrayToXml;

class AuthApiController extends Controller
{
	use Tocken;

	public function login()
	{
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];
			$user = User::whereEmail($email)->first();
	        
	        if (!$user) {
	            echo json_encode(['error' => 'Wrong credentials']);
	            return;
	        }

	        $adapter = new Pbkdf2(array (
	            'iterationCount' => 15000
	        ));
	        $phpassHash = new Hash($adapter);

	        if ($phpassHash->checkPassword($password, $user->password)) {
	            // Password matches...
	            $token = $this->generateTocken($user->id);
	            Session::set('api_token', $token);
	            echo json_encode(['token' => $token]);
	        } else {
	            // wrong password
	            echo json_encode(['error' => 'Wrong credentials']);
	        }
		} else {
			echo json_encode(['error' => 'Email and Password are required!']);
		}
	}

	public function getUsers()
	{
        if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
            list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
            if (strcasecmp($type, "Bearer") == 0) {
                if ($this->validateTocken($data)) {
                    $users = User::get();
                    echo json_encode($users);
                }
            } else {
                echo json_encode(['error' => 'Wrong credentials']);
            }
        } else {
            echo json_encode(['error' => 'Wrong credentials']);
        }
	}

	public function getUsersXml()
	{
		if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
            list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
            if (strcasecmp($type, "Bearer") == 0) {
                if ($this->validateTocken($data)) {
                    $array = User::get()->toarray();
					$result = ArrayToXml::convert(['__numeric' => $array]);
					echo(header('content-type: text/xml'));
					echo $result;
                }
            } else {
                echo json_encode(['error' => 'Wrong credentials']);
            }
        } else {
            echo json_encode(['error' => 'Wrong credentials']);
        }
	}
}