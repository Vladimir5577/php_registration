<?php 

namespace App\Controllers;

use Josantonius\Session\Session;
use Gregwar\Captcha\CaptchaBuilder;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{
    protected $twig;

    protected $captcha;

    protected $session;

    public function __construct() {
        $this->sessionStart();
    	$this->twig = $this->twigTemplate();
    	$this->captcha = $this->createCaptcha();
    }

    public function twigTemplate()
    {
    	if (APP_ENV == 'prod') {
            // save cache in production mode
    		$cache = APP_ROOT . '/var/cache';
    	} else {
            // do not save cache in dev mode
    		$cache = false;
    	}

    	$loader = new FilesystemLoader(APP_ROOT . '/views');
		$twig = new Environment($loader, 
		    [
		   		'cache' => $cache,
			]
		);
        $twig->addGlobal('session', $_SESSION);
    	return $twig;
    }

   	public function createCaptcha()
   	{
        return (new CaptchaBuilder)->build();
   	}

    public function sessionStart(): void
    {
        Session::init(3600);
    }
}