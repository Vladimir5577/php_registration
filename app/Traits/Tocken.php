<?php

namespace App\Traits;

use ReallySimpleJWT\Token;

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
	public function generateTocken($userId): string
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
}