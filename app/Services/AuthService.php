<?php

namespace App\Services;

use Phpass\Hash;
use App\Models\User;
use App\Traits\Tocken;
use Valitron\Validator;
use Phpass\Hash\Adapter\Pbkdf2;
use Josantonius\Session\Session;
use App\Interfaces\AuthInterface;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService implements AuthInterface
{
    use Tocken;

    /**
     * @return mixed|void
     */
    public function saveUserToDatabase()
    {
        $this->validateRegisterForm();
    }

    /**
     * Validate register form
     *
     * @return mixed|void
     */
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

    /**
     * Save vadid user data
     *
     * @return mixed|void
     */
	public function saveValidUserData()
	{
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check if user already exists
        $user = User::where('email', $email)->first();
        if ($user) {
            echo json_encode(['email' => 'Email already exists.']);
            return;
        }

        // save a new user
        $user = new User();
        $user->email = $email;
        $user->password = $this->hashUserPassword($password);
        $user->key = $this->generateRandomKeyForUser();
        $user->registered_at = $this->setDateUserRegistration();

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

    /**
     * Login
     *
     * @return mixed|void
     */
    public function loginUser()
    {
        $this->validateLoginForm();
    }

    /**
     * Validate login form
     *
     * @return mixed|void
     */
    public function validateLoginForm()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        Session::set('email', $email);

        $_POST['captcha_session'] = Session::get('captcha');

        $v = new Validator($_POST);
        $v->rule('required', ['email', 'password']);
        $v->rule('email', 'email');

        if($v->validate()) {
            $this->tryLoginWithValidUserCredentials($email, $password);
        } else {
            $errors = $v->errors();

            if (array_key_exists('email', $errors)) {
                Session::set('error_email', $errors['email'][0]);
            }

            if (array_key_exists('password', $errors)) {
                Session::set('error_password', $errors['password'][0]);
            }

            return header("Location: /login");
        }
    }

    /**
     * Login after validation
     *
     * @param $email
     * @param $password
     * @return mixed|void
     */
    public function tryLoginWithValidUserCredentials($email, $password)
    {
        $user = User::whereEmail($email)->first();
        
        if (!$user) {
            Session::set('error_login', 'Wrong credentials');
            return header("Location: /login");
        }

        $adapter = new Pbkdf2(array (
            'iterationCount' => 15000
        ));
        $phpassHash = new Hash($adapter);

        if ($phpassHash->checkPassword($password, $user->password)) {
            // Password matches...
            Session::set('auth_user_id', $user->id);
            $tocken = $this->generateTocken($user_id);
            return header("Location: /home_page");
        } else {
            // wrong password
            Session::set('error_login', 'Wrong credentials');
            return header("Location: /login");
        }
    }

    /**
     * Make user active after email confirmation
     */
    public function emailHasBeenConfirmedMakeUserActive()
    {
        $user = User::find(Session::get('auth_user_id'));
        if ($user) {
            $user->is_active = true;
            $user->save();

            Session::set('email_confirmed_successfully', 'Email has been confirmed successfully.');
            return header("Location: /home_page");
        }

        Session::set('email_confirmed_failed', 'Email confirmation failed.');
        return header("Location: /home_page");
    }

    /**
     * Hashing password
     *
     * @param $password
     * @return string
     */
    public function hashUserPassword($password): string
    {
        $adapter = new Pbkdf2(array (
            'iterationCount' => 15000
        ));
        $phpassHash = new Hash($adapter);
        return $phpassHash->hashPassword($password);
    }

    /**
     * Generate unique key for user
     *
     * @return number
     */
    public function generateRandomKeyForUser(): int
    {
        return rand(100000,999999);
    }

    /**
     * Get data registration
     *
     * @return false|string
     */
    public function setDateUserRegistration()
    {
        return date('Y-m-d');
    }

    public function test()
    {
        return 'Hello bla from infecter service';
    }
}