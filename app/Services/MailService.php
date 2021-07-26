<?php

namespace App\Services;

use App\Models\User;
use Josantonius\Session\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class MailService
 * @package App\Services
 */
class MailService
{
	public function sendEmailVerification()
	{
		$auth_user_id = Session::get('auth_user_id');
		$user = User::find($auth_user_id);

		if ($user) {
			$this->dispatchEmailIfUserAuth($user);
		}
	}

	public function dispatchEmailIfUserAuth($user)
	{
		$code_verification = rand(1000, 9999);
		Session::set('code_verification', $code_verification);

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = 'smtp';

		$mail->SMTPDebug  = 1;  
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port       = 587;
		$mail->Host       = 'smtp.gmail.com';
		$mail->Username   = GMAIL_ADDRESS;
		$mail->Password   = GMAIL_PASSWORD;

		$mail->IsHTML(true);
		$mail->AddAddress($user->email);
		$mail->SetFrom(GMAIL_ADDRESS, 'PHP-developer');

		$mail->Subject = 'Confirm your registration with a code.';
		$content = '<b>Secret code: <h1>' . $code_verification . '</h1></b>';

		$mail->MsgHTML($content); 
		if(!$mail->Send()) {
		  // error
		  Session::set('email_sended_failed', 'Email was not send to you. Try again.');
			return header("Location: /confirm_email");
		} else {
		  // success
			Session::set('email_sended_success', 'Email was send. Check your email box.');
			return header("Location: /confirm_email");
		}
	}
}