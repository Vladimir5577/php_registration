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

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = "smtp";

		$mail->SMTPDebug  = 1;  
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port       = 587;
		$mail->Host       = "smtp.gmail.com";
		$mail->Username   = "chesheva0312@gmail.com";
		$mail->Password   = "03127777";

		$mail->IsHTML(true);
		$mail->AddAddress("vladimir160933@gmail.com");
		$mail->SetFrom("chesheva0312@gmail.com", 'PHP-developer');
		// $mail->AddReplyTo("vladimir160933@gmail.com", "reply-to-name");
		// $mail->AddCC("vladimir160933@gmail.com", "cc-recipient-name");
		$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
		$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";


		$mail->MsgHTML($content); 
		if(!$mail->Send()) {
		  echo "Error while sending Email.";
		  // var_dump($mail);
		} else {
		  echo "Email sent successfully";
		}

		dd('Finesh');
        require_once APP_ROOT . '/views/home.php';
	}
}