<?php 

namespace App\Controllers;

use App\Traits\Tocken;
use App\Traits\Captcha;
use App\Services\AuthService;
use App\Services\MailService;
use Josantonius\Session\Session;
use App\Interfaces\AuthInterface;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends Controller
{
    use Tocken, Captcha;

    /**
     * Form registration
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function getForm(AuthInterface $authInterface)
	{
        $csrf = $this->generateCsrfAndSaveToSession(30);
        $this->saveNevCaptchaToFileAndSession();

        echo $this->twig->render('pages/auth/register.html.twig', [
            'csrf' => $csrf,
            'captcha' => $this->captcha,
        ]);
	}

    /**
     * Submitting the form registration
     */
    public function formRegister(AuthInterface $authInterface)
    {
        if (!$this->validateCsrf($_POST['csrf'])) {
            echo json_encode(['csrf' => 'Page has been expired!']);
            return;
        }

        $authInterface->saveUserToDatabase();
    }

    /**
     * Login Page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        echo $this->twig->render('pages/auth/login.html.twig', [
            'csrf' => $this->generateCsrfAndSaveToSession(),
            'email' => Session::pull('email'),
            'error_csrf' => Session::pull('error_csrf'),
            'error_login' => Session::pull('error_login'),
            'error_email' => Session::pull('error_email'),
            'error_password' => Session::pull('error_password'),
        ]);
    }

    /**
     * Login action
     */
    public function loginSubmit(AuthInterface $authInterface)
    {
        // validate csrf
        if (!$this->validateCsrf($_POST['csrf'])) {
            Session::set('error_csrf', '419 Page has been expired! Please refresh the page!');
            return header("Location: /login");
        }

        $authInterface->loginUser();
    }

    /**
     * Reset captcha (change picture and assign a new code)
     */
    public function resetCaptcha()
    {
        $this->saveNevCaptchaToFileAndSession();

        echo $this->captcha->inline();
    }

    /**
     * Email confirmation page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function confirmEmail()
    {
        echo $this->twig->render('pages/auth/code_verification.html.twig', [
            'csrf' => $this->generateCsrfAndSaveToSession(),
            'error_csrf' => Session::pull('error_csrf'),
            'email_sended_success' => Session::pull('email_sended_success'),
            'email_confirmed_failed' => Session::pull('email_confirmed_failed'),
        ]);
    }

    /**
     * Action to send email
     */
    public function sendEmail()
    {
        $mailService = new MailService;
        $mailService->sendEmailVerification();
    }

    /**
     * Email verification code
     */
    public function codeVerify(AuthInterface $authInterface)
    {
        // validate csrf
        if (!$this->validateCsrf($_POST['csrf'])) {
            Session::set('error_csrf', '419 Page has been expired! Please refresh the page!');
            return header("Location: /confirm_email");
        }

        if (Session::get('code_verification') == intval($_POST['code_verification'])) {
            // verification cod is correct
            $authInterface->emailHasBeenConfirmedMakeUserActive();
        } else {
            // wrond cod 
            Session::set('email_confirmed_failed', 'Wrond code. Try again.');
            return header("Location: /confirm_email");
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        Session::destroy();

        return header("Location: /login");
    }
}