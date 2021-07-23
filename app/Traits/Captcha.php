<?php

namespace App\Traits;

use Josantonius\Session\Session;

trait Captcha {

	public function saveNevCaptchaToFileAndSession(): void
	{
		// dd($this->captcha);
        $this->captcha->save('captcha.jpg');
        $captcha_phrase = $this->captcha->getPhrase();
        Session::set('captcha', $captcha_phrase);
	}

}