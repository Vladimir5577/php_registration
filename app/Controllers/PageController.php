<?php 

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class PageController
 * @package App\Controllers
 */
class PageController
{
    // Homepage action
	public function indexAction()
	{
/*
		$code_verification = rand(1000, 9999);
		Session::set('code_verification', $code_verification):

		dd($code_verification);

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = "smtp";

		$mail->SMTPDebug  = 1;  
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port       = 587;
		$mail->Host       = "smtp.gmail.com";
		$mail->Username   = GMAIL_ADDRESS;
		$mail->Password   = GMAIL_PASSWORD;

		$mail->IsHTML(true);
		$mail->AddAddress("vladimir160933@gmail.com");
		$mail->SetFrom(GMAIL_ADDRESS, 'PHP-developer');

		$mail->Subject = "Confirm your registration with a code.";
		$content = "<b>Secret code: .</b>";

		$mail->MsgHTML($content); 
		if(!$mail->Send()) {
		  echo "Error while sending Email.";
		  // var_dump($mail);
		} else {
		  echo "Email sent successfully";
		}
*/
		dd('Finesh');
        require_once APP_ROOT . '/views/home.php';
	}
}