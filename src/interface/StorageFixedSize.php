<?php

namespace Dogia\Carldb\Interface;

use Dogia\Carldb\Application\Output\Storage;
use Dogia\Carldb\Application\Input\InstructionPort;

class StorageFixedSize implements Storage {
    private $table;

    public function __construct(
        private string $dir,
        private InstructionPort $instructionPort
    ){}

    public function getFields(): array
    {
        return [];
    }

    public function putObject($object): bool
    {
        return true;
    }

    public function getAllObjects(): array
    {
        return [];
    }

    public function getObjectsByField($field, $operator, $needle): mixed
    {
        return null;
    }

    public function updateObject($field, $operator, $needle): bool
    {
        return true;
    }

    public function deleteObject($field, $operator, $needle): bool
    {
        return true;
    }

    public function setTable($table): void
    {
        if(!file_exists("$this->dir/$table"))
        {
            $printer = new DefaultPrinter();
            $printer->printc('default', "Nombre de la tabla:");
            $tableName = $this->instructionPort->getCommand();
            $printer->printc('default', "Cantidad de campos:");
            $fieldsQuantity = (int) $this->instructionPort->getCommand();
            $fields = [];
            
            for($i=1; $i<=$fieldsQuantity; $i++)
            {
                $printer->printc('default', "---------- Campo $i ----------");
                $printer->printc('default', "Nombre:");
                $fname = $this->instructionPort->getCommand();
                $printer->printc('default', "Descripcion:");
                $fdesc = $this->instructionPort->getCommand();
                $printer->printc('default', "Tipo de dato (char,int,double):");
                $ftype = $this->instructionPort->getCommand();
                $printer->printc('default', "Longitud:");
                $flen = $this->instructionPort->getCommand();
                $fields[] = "$fname{$fdesc}<$ftype:$flen>";
            }

            if($fields > 0)
            {
                while(true)
                {
                    $printer->printc('orange', "¿Desea crear la tabla $tableName? [y/n]");
                    $confirm = $this->instructionPort->getCommand();
                    if($confirm === 'y')
                        $this->createTable($tableName, $fields);
                    else if($confirm === 'n')
                        break;
                }
            }
        }

        $this->table = $table;
    }

    private function createTable($tableName, $fields)
    {
        $headers = implode('|', $fields)."\n";
        $file = fopen("$this->dir/$tableName", 'w');
        flock($file, LOCK_EX);
        fputs($file, $headers);
        flock($file, LOCK_UN);
        fclose($file);
    }

    public function listTables(): void
    {
        
    }
}
