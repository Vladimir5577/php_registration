<?php 

namespace App\Controllers;

use Twig\Environment;
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
     * Controller constructor.
     */
    public function __construct(Environment $twigEnvironment, CaptchaBuilder $captchaBuilder) {
    	$this->twig = $twigEnvironment;
    	$this->captcha = $captchaBuilder->build();
    }
}