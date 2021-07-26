<?php

namespace App\Traits;

use Josantonius\Session\Session;

/**
 * Trait Captcha
 * @package App\Traits
 */
trait Captcha {

	public function saveNevCaptchaToFileAndSession(): void
	{
        $this->captcha->save('captcha.jpg');
        $captcha_phrase = $this->captcha->getPhrase();
        Session::set('captcha', $captcha_phrase);
	}
}