<?php

require 'vendor/autoload.php';

use Dogia\Carldb\Application\{Core2};
use Dogia\Carldb\Interface\CommandLineInterface;
use Dogia\Carldb\Interface\StorageFixedSize;
use Dogia\Carldb\Interface\StorageVariableSize;


$cli = new CommandLineInterface;
$storage = new StorageVariableSize(__DIR__."/data/LV", $cli);
// $storage = new StorageFixedSize(__DIR__."/data/LF");
$application = new Core2($cli, $storage);
