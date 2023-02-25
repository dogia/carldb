<?php

require 'vendor/autoload.php';

use Dogia\Carldb\Application\{Core};
use Dogia\Carldb\Interface\CommandLineInterface;

$application = new Core(__DIR__."/data");

$cli = new CommandLineInterface;
$application->start();
