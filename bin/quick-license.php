<?php

use TylerSommer\QuickLicense\Console\Application;
use TylerSommer\QuickLicense\Handler\HandlerFactory;
use TylerSommer\QuickLicense\Handler\PhpHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$factory = new HandlerFactory(array(
    new PhpHandler()
));

$app = new Application($factory);
$app->run();
