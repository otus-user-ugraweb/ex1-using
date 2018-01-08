#!/usr/bin/env php

<?php

use Symfony\Component\Console\Application;
use user\ex1\using\Commands\ExecuteAppCommand;

require __DIR__ . '/../vendor/autoload.php';

$application = new Application();
$application->add(new ExecuteAppCommand());
$application->run();