<?php

require 'vendor/autoload.php';

use Dogia\Carldb\Application\{Core};

$application = new Core(__DIR__."/data");

$application->start();
