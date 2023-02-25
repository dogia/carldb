<?php

namespace Dogia\Carldb\Application\Input;

use Dogia\Carldb\Domain\{Option, Error};

interface InstructionPort {
    public function getCommand(): Option|Error;
    public function getArgs(): array;
}