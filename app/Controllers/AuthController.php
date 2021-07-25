<?php 

namespace App\Controllers;

use Josantonius\Session\Session;
use Phpass\Hash;
use App\Models\User;
use App\Traits\Tocken;
use App\Traits\Captcha;
use App\Services\AuthService;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends Controller
{
    use Tocken, Captcha;

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function getForm()
	{
//        $package = new Package(new EmptyVersionStrategy());
        // dd(APP_ROOT);
        // $package->getUrl('uploads/images/ava_default.jpeg');
//        dd($package->getUrl('image.png'));

        // https://github.com/rchouinard/phpass
        // $adapter = new \Phpass\Hash\Adapter\Pbkdf2(array (
        //     'iterationCount' => 15000
        // ));
        // $phpassHash = new \Phpass\Hash($adapter);

//        $passwordHash = $phpassHash->hashPassword('123');

//        dd($passwordHash);

        // if ($phpassHash->checkPassword('123', '$p5v2$ARPPHWdg/$6XNdVvnvxOopGnu4WsmGTFeD82UWK7Hd')) {
        //     // Password matches...
        //     dump('Match');
        // } else {
        //     // Password doesn't match...
        //     dump('Not');
        // }

        $csrf = $this->generateTocken('new_user');
        $this->saveNevCaptchaToFileAndSession();

        echo $this->twig->render('pages/auth/register.html.twig', [
            'csrf' => $csrf,
            'captcha' => $this->captcha,
        ]);
	}

    public function formRegister()
    {
        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, POST');
        // header("Access-Control-Allow-Headers: *");
        // header('Access-Control-Allow-Credentials: true');

        if (!$this->validateTocken($_POST['csrf'])) {
            echo json_encode(['csrf' => 'Page has been expired!']);
            return;
        } 

        $auhtService = new AuthService;
        $auhtService->saveUserToDatabase();
    }

    public function login()
    {
        $csrf = $this->generateTocken('login');

        echo $this->twig->render('pages/auth/login.html.twig', [
            'csrf' => $csrf,
            'email' => Session::pull('email'),
            'error_csrf' => Session::pull('error_csrf'),
            'error_login' => Session::pull('error_login'),
            'error_email' => Session::pull('error_email'),
            'error_password' => Session::pull('error_password'),
        ]);
    }

    public function loginSubmit()
    {
        // validate csrf
        if (!$this->validateTocken($_POST['csrf'])) {
            Session::set('error_csrf', '419 Page has been expired! Please refresh the page!');
            return header("Location: /login");
        }

        $auhtService = new AuthService;
        $auhtService->loginUser();
    }

    public function resetCaptcha()
    {
        $this->saveNevCaptchaToFileAndSession();

        echo $this->captcha->inline();
    }
}