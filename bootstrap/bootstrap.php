<?php


use App\Controllers\AuthController;

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(APP_ROOT . '/bootstrap/DI_config.php');

return $containerBuilder->build();
