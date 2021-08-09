<?php 

namespace App\Controllers;

use Twig\Environment;
use Josantonius\Session\Session;
use Twig\Loader\FilesystemLoader;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var CaptchaBuilder
     */
    protected $captcha;

    /**
     * session
     */
    protected $session;

    /**
     * Controller constructor.
     */
    public function __construct(CaptchaBuilder $captchaBuilder) {
        $this->sessionStart();
    	$this->twig = $this->twigTemplate();
    	$this->captcha = $captchaBuilder->build();
    }

    /**
     * @return Environment
     */
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
		$twig = new Environment($loader, ['cache' => $cache]);
        $twig->addGlobal('session', $_SESSION);
    	return $twig;
    }

    /**
     * Start session for 1 hour
     */
    public function sessionStart(): void
    {
        Session::init(3600);
    }
}