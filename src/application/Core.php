<?php

namespace Dogia\Carldb\Application;

class Core
{
    const AUTHOR = '
UTP - Universidad Tecnológica de Pereira
Santiago Sepúlveda
Daniel Osorio O
--------------------
Ingeniería de Sistemas y Computación
Bases de Datos
2023
';
    const HELP = '
CarlDB
usage: <command> [args...]

The available commands are:
    author ................... Read autors information
    list_tables .............. List all available tables
    select_table $table_name . Selects the current table
    create_table ............. Interface for table creation

    With selected table:
        insert ............... Insert a touple
        update ............... Update a touple data
        delete ............... Remove someone touple
        select [$id] [$filter] Reads a registry, $id is an int corresponding array index of field, filter is a string to match
        export ............... Generates a CSV file

    exit ..................... Ends the program
';
    const MENU_SELECTED_TABLE = '';
    const MENU_NOT_SELECTED_TABLE = '';

    const LF = 1;
    const LV = 2;
    private string|null $mode = null;
    private TableLV|null $selectedTable = null;
    private string|null $dir = null;

    public function __construct(private string $dirdata)
    {
        $input = null;
        do {
            $this->println("Select the database mode:\n1.LF\n2.LV");
        } while (($input = readline()) && $input != '1' && $input != '2');

        if ($input === '1') $this->mode = self::LF;
        else $this->mode = self::LV;

        $this->load_from_disc();
    }

    public static final function println($output)
    {
        $output = str_replace("\t", '', $output);
        print("$output\n");
    }

    public function start()
    {
        $input = 'help';
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
        $this->println("\033[01;31m  .oooooo.                      oooo  oooooooooo.   oooooooooo.  \n d8P'  `Y8b                     `888  `888'   `Y8b  `888'   `Y8b \n888           .oooo.   oooo d8b  888   888      888  888     888 \n888          `P  )88b  `888\"\"8P  888   888      888  888oooo888' \n888           .oP\"888   888      888   888      888  888    `88b \n`88b    ooo  d8(  888   888      888   888     d88'  888    .88P \n` Y8bood8P'  `Y888\"\"8o d888b    o888o o888bood8P'   o888bood8P'  \n\033[0m________________________________________________________________\n\n");
        do {
            $t = microtime(true);
            switch ($input) {
                case 'author':
                    $this->println(self::AUTHOR);
                    break;
                case 'help':
                    $this->println(self::HELP);
                    break;
                case 'list_tables':
                    $this->listTables();
                    break;
                case 'insert':
                    $this->selectedTable ?
                        $this->selectedTable->insert() :
                        $this->println('Not table selected!');
                    break;
                case 'select':
                    $this->selectedTable ?
                        $this->selectedTable->select(true) :
                        $this->println('Not table selected!');
                    break;
                case 'export':
                    $this->selectedTable ?
                        $this->selectedTable->export(true) :
                        $this->println('Not table selected!');
                    break;

                default:
                    $args = explode(' ', $input);
                    if ($args[0] === 'select_table') {
                        if (isset($args[1]) && strlen($args[1]) > 0) {
                            if (is_file("$this->dir/$args[1]")) {
                                $this->selectTable("$this->dir/$args[1]");
                            } else $this->println('Table doesn\'t exists!');
                        } else $this->println('Invalid table name!');
                    } elseif ($args[0] === 'select') {
                        if (isset($args[1]) && strlen($args[1]) > 0) {
                            $this->selectedTable ?
                                $this->selectedTable->select(false, $args[1], $args[2], $args[3]) :
                                $this->println('Not table selected!');
                        } else $this->println('Invalid ID!');
                    } elseif ($args[0] === 'export') {
                        if (isset($args[1]) && strlen($args[1]) > 0) {
                            $this->selectedTable ?
                                $this->selectedTable->export(false, $args[1], $args[2], $args[3]) :
                                $this->println('Not table selected!');
                        } else $this->println('Invalid ID!');
                    } elseif($args[0] === 'import') {
                        if (isset($args[1]) && strlen($args[1]) > 0) {
                            $this->selectedTable ?
                                $this->selectedTable->import($args[1]) :
                                $this->println('Not table selected!');
                        } else $this->println('Not path provided');
                    } else $this->println('Unknown command!');
                    break;
            }
            echo "time: " . ((microtime(true) - $t) * 1000) . " ms\n";
        } while (($input = readline()) !== "exit");
    }

    private function selectTable($filename)
    {
        $this->selectedTable = new TableLV($filename);
    }

    private function listTables()
    {
        $tbl = new \Console_Table();
        $tbl->setHeaders(['#','Tables']);
        $scandir = scandir($this->dir);
        $i=1;
        foreach ($scandir as $name) {
            if ($name != '.' && $name != '..') {
                if (is_file("$this->dir/$name"))
                    $tbl->addRow([$i++, $name]);
            }
        }
        echo $tbl->getTable();
    }

    private function load_from_disc()
    {
        $this->mode === self::LF ?
            $this->dir = "$this->dirdata/LF" :
            $this->dir = "$this->dirdata/LV";
    }
}
