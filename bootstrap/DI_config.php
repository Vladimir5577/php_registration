<?php

use function DI\create;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Gregwar\Captcha\CaptchaBuilder;


return [
    \App\Interfaces\AuthInterface::class => create(\App\Services\AuthService::class),
    \App\Interfaces\UserInterface::class => create(\App\Services\UserService::class),

    Environment::class => function () {
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
    },

    CaptchaBuilder::class => create(CaptchaBuilder::class),

];