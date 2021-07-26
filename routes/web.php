<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


// Routes system
$routes = new RouteCollection();

// user home page
$routes->add('index', new Route('/', array('controller' => 'UserController', 'method' => 'index')));


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

// code verify
$routes->add('code_verify', new Route('/code_verify', array('controller' => 'AuthController', 'method' => 'codeVerify')));

// get users
$routes->add('get_users', new Route('/get_users', array('controller' => 'UserController', 'method' => 'getUsers')));

// get users by sort
$routes->add('get_users_by_sort', new Route('/get_users_by_sort', array('controller' => 'UserController', 'method' => 'getUsersBySort')));

// confirm email
$routes->add('logout', new Route('/logout', array('controller' => 'AuthController', 'method' => 'logout')));


// api login route
$routes->add('api/login', new Route('/api/login', array('controller' => 'Api\AuthApiController', 'method' => 'login')));

// api get users
$routes->add('api/get_users', new Route('/api/get_users', array('controller' => 'Api\AuthApiController', 'method' => 'getUsers')));

// api xml get users
$routes->add('api/get_users_xml', new Route('/api/get_users_xml', array('controller' => 'Api\AuthApiController', 'method' => 'getUsersXml')));