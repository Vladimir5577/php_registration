<?php

namespace App\Traits;

use ReallySimpleJWT\Token;
use Josantonius\Session\Session;

/**
 * Trait Tocken
 * @package App\Traits
 */
trait Tocken {

	private static $SECRET = 'sec!ReT423*&';
	private static $ISSUER = 'localhost';

    /**
     * Generate new token and with lifetime 1 hour
     *
     * @param $userId
     * @return string
     */
	public function generateTocken(int $userId): string
	{
        $expiration = time() + 3600;

        return Token::create($userId, self::$SECRET, $expiration, self::$ISSUER);
	}

    /**
     * Token validation
     *
     * @param $tocken
     * @return bool
     */
	public function validateTocken($tocken)
	{
		if (Token::validate($tocken, self::$SECRET)) {     
            return true;
        } else {
        	return false;
        }
	}

	public function generateCsrfAndSaveToSession(int $strLength = 30): string
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < $strLength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        Session::set('csrf', $random_string);

        return $random_string;
    }

    public function validateCsrf(string $csrf): bool
    {
        if (Session::get('csrf') == $csrf) {
            return true;
        }

        return false;
    }
}