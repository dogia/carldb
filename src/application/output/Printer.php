<?php

namespace Dogia\Carldb\Application\Output;

interface Printer {
    public function println(...$args): void;
    public function printc($color, ...$args): void;
}