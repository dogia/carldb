<?php

namespace Dogia\Carldb\Interface;

use Dogia\Carldb\Application\Input\InstructionPort;
use Dogia\Carldb\Domain\{Option, Error};

class CommandLineInterface implements InstructionPort {
    private string $command;
    private array  $args;

    public function getCommand(): Option|Error
    {
        $input      = readline();
        $input      = strtolower($input);
        $exploded   = explode(' ', $input);
        $this->command  = $exploded[0];
        $this->args     = array_slice($exploded, 1); 
        $required_args_counter = 0;  
        $option = '';

        switch ($this->command)
        {
            case 'author':
                $option = Option::OPTION_AUTOR;
            case 'help':
                $option = Option::OPTION_HELP;

            case 'seltable':
            case 'use':
            case 'usetab':
            case 'use_table':
                $required_args_counter = 1;
                $option = Option::OPTION_SELECT_TABLE;
            
            case 'list':
            case 'listtable':
            case 'listtables':
            case 'list_table':
            case 'list_tables':
                $option = Option::OPTION_LIST_TABLES;

            case 'insert':
                $option = Option::OPTION_INSERT;
            case 'select':
                $option = Option::OPTION_SELECT;
            case 'update':
                $option = Option::OPTION_UPDATE;
            case 'delete':
                $required_args_counter = 3;
                $option = Option::OPTION_DELETE;

            case 'import':
                $required_args_counter = 1;
                $option = Option::OPTION_IMPORT;
            case 'export':
                $option = Option::OPTION_EXPORT;
            
            default:
                $option = Error::UNKNOWN_COMMAND;
        }

        return $option;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

}