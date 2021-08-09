<?php

use Josantonius\Session\Session;
use Symfony\Component\Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

//site name
define('SITE_NAME', 'php_registration');

//App Root
define('APP_ROOT', dirname(dirname(__FILE__)));

(new Dotenv())->load(APP_ROOT . '/.env');


define('URL_ROOT', 'http://localhost/');

//DB Params
define('APP_ENV', $_ENV['APP_ENV']);
define('DB_HOST', $_ENV['DB_CONNECTION']);
define('DB_USER', $_ENV['DB_USERNAME']);
define('DB_PASS', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_DATABASE']);

// gmail credentials
define('GMAIL_ADDRESS', $_ENV['GMAIL_ADDRESS']);
define('GMAIL_PASSWORD', $_ENV['GMAIL_PASSWORD']);


// connect to database
$capsule = new Capsule;
$capsule->addConnection([
   "driver" => DB_HOST,
   "host" =>"127.0.0.1",
   "database" => DB_NAME,
   "username" => DB_USER,
   "password" => DB_PASS,
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Start session
Session::init(3600);