<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;




// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route('/', array('controller' => 'PageController', 'method'=>'indexAction'), array('id' => '[0-9]+')));

$routes->add('product', new Route('/product/{id}', array('controller' => 'ProductController', 'method'=>'showAction'), array('id' => '[0-9]+')));


// register page
$routes->add('register', new Route('/register', array('controller' => 'AuthController', 'method' => 'getForm')));

// login page
$routes->add('login', new Route('/login', array('controller' => 'AuthController', 'method' => 'login')));

// submit login page
$routes->add('login_submit', new Route('/login_submit', array('controller' => 'AuthController', 'method' => 'loginSubmit')));

// register form submit
$routes->add('form_submit', new Route('/form_submit', array('controller' => 'AuthController', 'method' => 'formRegister')));

// reset captcha
$routes->add('reset_captcha', new Route('/reset_captcha', array('controller' => 'AuthController', 'method' => 'resetCaptcha')));

// user home page
$routes->add('home_page', new Route('/home_page', array('controller' => 'UserController', 'method' => 'homePage')));

// edit profile
$routes->add('edit_profile', new Route('/edit_profile', array('controller' => 'UserController', 'method' => 'editProfile')));

// save personal user data
$routes->add('save_user_data', new Route('/save_user_data', array('controller' => 'UserController', 'method' => 'saveUserData')));

// send email
$routes->add('send_email', new Route('/send_email', array('controller' => 'AuthController', 'method' => 'sendEmail')));

// confirm email
$routes->add('confirm_email', new Route('/confirm_email', array('controller' => 'AuthController', 'method' => 'confirmEmail')));

// confirm email
$routes->add('logout', new Route('/logout', array('controller' => 'AuthController', 'method' => 'logout')));