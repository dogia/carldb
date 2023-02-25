<?php

namespace Dogia\Carldb\Interface;

use Dogia\Carldb\Application\Output\Printer;

class DefaultPrinter implements Printer {
    public function println(...$args): void
    {

    }

    public function printc($color, ...$args): void
    {
        $color = strtolower($color);
        $start = '';
        $end = '';

        switch($color)
        {
            case 'black':
                $start  = "\033[30m";
                $end    = "\033[40m";
            break;
            case 'dark red':
                $start  = "\033[31m";
                $end    = "\033[41m";
            break;
            case 'dark green':
                $start  = "\033[32m";
                $end    = "\033[42m";
            break;
            case 'dark yellow':
                $start  = "\033[33m";
                $end    = "\033[43m";
            break;
            case 'dark blue':
                $start  = "\033[34m";
                $end    = "\033[44m";
            break;
            case 'dark magenta':
                $start  = "\033[35m";
                $end    = "\033[45m";
            break;
            case 'dark cyan':
                $start  = "\033[36m";
                $end    = "\033[46m";
            break;
            case 'light gray':
                $start  = "\033[37m";
                $end    = "\033[47m";
            break;
            case 'dark gray':
                $start  = "\033[90m";
                $end    = "\033[100m";
            break;
            case 'red':
                $start  = "\033[91m";
                $end    = "\033[101m";
            break;
            case 'green':
                $start  = "\033[92m";
                $end    = "\033[102m";
            break;
            case 'orange';
                $start  = "\033[93m";
                $end    = "\033[103m";
            break;
            case 'blue':
                $start  = "\033[94m";
                $end    = "\033[104m";
            break;
            case 'magenta':
                $start  = "\033[95m";
                $end    = "\033[105m";
            break;
            case 'cyan':
                $start  = "\033[96m";
                $end    = "\033[106m";
            break;
            case 'white':
                $start  = "\033[97m";
                $end    = "\033[107m";
            break;
            default:
                $start  = "\033[39m";
                $end    = "\033[49m";
        }

        foreach($args as $arg)
        {
            $this->println("$start$arg$end");
        }
    }
}
