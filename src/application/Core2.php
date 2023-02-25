<?php

namespace Dogia\Carldb\Application;

use Dogia\Carldb\Application\Input\InstructionPort;
use Dogia\Carldb\Application\Output\Storage;
use Dogia\Carldb\Domain\{Option, Error};

class Core2
{
    private bool $isTableSelected = false;
    public function __construct(
        private InstructionPort $instructionPort,
        private Storage $storage
    )
    {
        do
        {
            switch($instructionPort->getCommand())
            {
                case Option::OPTION_AUTOR:
                    Anotations::author();
                    break;
                case Option::OPTION_HELP:
                    Anotations::help();
                    break;
                case Option::OPTION_SELECT_TABLE:
                    $this->isTableSelected = true;
                    $storage->setTable($this->instructionPort->getArgs()[0]);
                    break;
                case Option::OPTION_LIST_TABLES:
                    $storage->listTables();
                    break;
                case Option::OPTION_INSERT:
                    //$storage->putObject();
                    break;
                case Option::OPTION_UPDATE:
                    break;
                case Option::OPTION_SELECT:
                    break;
                case Option::OPTION_DELETE:
                    break;
                case Option::OPTION_IMPORT:
                    break;
                case Option::OPTION_EXPORT:
                    break;

                default:
                    break;
                    
            }
        } while(true);
    }

    private function list()
    {

    }
}