<?php

namespace App\Services;

use App\Models\User;
use Valitron\Validator;
use App\Traits\Tocken;
use Josantonius\Session\Session;
use App\Interfaces\AuthInterface;

class AuthService implements AuthInterface
{
    use Tocken;

    public function saveUserToDatabase()
    {
        $this->validateRegisterForm();
    }

	public function validateRegisterForm()
	{
		$_POST['captcha_session'] = Session::get('captcha');

        $v = new Validator($_POST);
        $v->rule('required', ['email', 'password', 'captcha']);
        $v->rule('email', 'email');
        $v->rule('lengthMin', 'password', 4);
        $v->rule('equals', 'captcha', 'captcha_session')
            ->message('Captcha ' . Session::get('captcha'));

        if($v->validate()) {
            $this->saveValidUserData();
        } else {
            echo json_encode($v->errors());
        }
	}

	public function saveValidUserData()
	{
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check if user already exists
        $user = User::where('email', $_POST['email'])->first();
        if ($user) {
            echo json_encode(['email' => 'Email already exists.']);
            return;
        }

        // hash password
        $adapter = new \Phpass\Hash\Adapter\Pbkdf2(array (
            'iterationCount' => 15000
        ));
        $phpassHash = new \Phpass\Hash($adapter);
        $passwordHash = $phpassHash->hashPassword($_POST['password']);

        $user = new User();
        $user->email = $_POST['email'];
        $user->password = $passwordHash;
        $user->key = rand(100000,999999);

        $user->save();

        $user_id = $user->id;
        Session::set('auth_user_id', $user_id);
        $tocken = $this->generateTocken($user_id);

        echo json_encode([
            'auth' => true,
            'tocken' => $tocken,
            'auth_user_id' => $user_id,
        ]);

	}
}