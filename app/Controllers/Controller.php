<?php 

namespace App\Controllers;

use App\Traits\Tocken;
use Twig\Environment;
use Josantonius\Session\Session;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    use Tocken;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var CaptchaBuilder
     */
    protected $captcha;

    /**
     * Controller constructor.
     */
    public function __construct(Environment $twigEnvironment, CaptchaBuilder $captchaBuilder) {
    	$this->twig = $twigEnvironment;
    	$this->captcha = $captchaBuilder->build();
    }

    public function checkUserAuth()
    {
        if (isset($_COOKIE['tocken']) && $this->validateTocken($_COOKIE['tocken'])) {
            return true;
        }

        return false;
    }
}