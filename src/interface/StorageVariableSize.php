<?php

namespace Dogia\Carldb\Interface;

use Dogia\Carldb\Application\Output\Storage;
use Dogia\Carldb\Application\Input\InstructionPort;
use Dogia\Carldb\Interface\DefaultPrinter;

class StorageVariableSize implements Storage {
    private const FS = '|';
    private string $table;

    public function __construct(
        private string $dir,
        private InstructionPort $instructionPort
    ){}

    public function getFields(): array
    {
        $result = [];
        $file = fopen("$this->dir/$this->table", 'r');
        flock($file, LOCK_SH);
        $headers = fgets($file);
        $fields = explode(self::FS, $headers);

        foreach($fields as $field)
        {
            $fn = 0;
            $ln = strpos($field, '{');
            $fd = $ln;
            $ld = strpos($field, '}');
            $ft = strpos($field, '<');
            $lt = strpos($field, ':');
            $fl = $lt;
            $ll = strpos($field, '>');
            $fname = substr($field, $fn, $ln - $fn);
            $fdesc = substr($field, $fd, $ld - $fd);
            $ftype = substr($field, $ft, $lt - $ft);
            $fleng  = substr($field, $fl, $ll - $fl);
            $result[] = 
                [
                    'name' => $fname,
                    'desc' => $fdesc,
                    'type' => $ftype,
                    'leng' => $fleng
                ];
        }

        flock($file, LOCK_UN);
        fclose($file);
        return $result;
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
                $fleng = $this->instructionPort->getCommand();
                $fields[] = "$fname{$fdesc}<$ftype:$fleng>";
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
        $headers = implode(self::FS, $fields)."\n";
        $file = fopen("$this->dir/$tableName", 'w');
        flock($file, LOCK_EX);
        fputs($file, $headers);
        flock($file, LOCK_UN);
        fclose($file);
    }

    public function listTables(): void
    {
        $tbl = new \Console_Table();
        $tbl->setHeaders(['#','Tables']);
        $scandir = scandir($this->dir);
        $i=1;
        foreach ($scandir as $name) {
            if (!in_array($name, ['.', '..'])) {
                if (is_file("$this->dir/$name"))
                    $tbl->addRow([$i++, $name]);
            }
        }
        echo $tbl->getTable();
    }
}
