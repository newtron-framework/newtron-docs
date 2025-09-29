<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Newtron\App\Launcher;
use Newtron\Core\Application\App;

App::create(dirname(__DIR__));

Launcher::setup();

App::run();
