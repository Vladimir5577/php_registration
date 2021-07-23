<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route('/', array('controller' => 'PageController', 'method'=>'indexAction'), array()));
$routes->add('product', new Route('/product/{id}', array('controller' => 'ProductController', 'method'=>'showAction'), array('id' => '[0-9]+')));


// register page
$routes->add('register', new Route('/register', array('controller' => 'AuthController', 'method' => 'getForm')));

// form submit
$routes->add('form_submit', new Route('/form_submit', array('controller' => 'AuthController', 'method' => 'formRegister')));

// reset captcha
$routes->add('reset_captcha', new Route('/reset_captcha', array('controller' => 'AuthController', 'method' => 'resetCaptcha')));

// user home page
$routes->add('home_page', new Route('/home_page', array('controller' => 'UserController', 'method' => 'homePage')));