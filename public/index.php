<?php

#define('DEBUG_MODE', true);

use App\Config\BootLoader;
use Minute\App\App;

require_once('../vendor/autoload.php');

$bootLoader = new BootLoader();
$injector   = $bootLoader->getInjector();

/** @var App $app */
$app = $injector->make('Minute\App\App');
$app->run();
