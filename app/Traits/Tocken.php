<?php

namespace App\Traits;

use ReallySimpleJWT\Token;

trait Tocken {

	private static $SECRET = 'sec!ReT423*&';
	private static $ISSUER = 'localhost';

	public function generateTocken($userId): string
	{
		// $userId = 'new_user';
        // $secret = self::SECRET;
        $expiration = time() + 3600;
        // $issuer = 'localhost';

        return Token::create($userId, self::$SECRET, $expiration, self::$ISSUER);
	}

	public function validateTocken($tocken)
	{
		if (Token::validate($tocken, self::$SECRET)) {     
            return true;
        } else {
        	return false;
        }
	}

}