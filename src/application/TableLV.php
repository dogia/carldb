<?php

namespace Dogia\Carldb\Application;

use Console_Table;

class TableLV implements \Dogia\Carldb\Domain\Table
{
    const EX_FIELD_SEPARATOR = ",";
    const EX_REGISTER_SEPARATOR = "\n";

    const FIELD_SEPARATOR = "|";
    const REGISTER_SEPARATOR = "\n";

    private array $fields;
    public function __construct(private string $filename)
    {
        $file = fopen($this->filename, 'r');
        flock($file, LOCK_SH);
        $headers = fgets($file);
        $columns = explode('|', $headers);
        foreach ($columns as $field) {
            $name = substr($field, 0, strpos($field, "<"));
            $type = substr($field, strpos($field, "<") + 1, strpos($field, ">") - (strpos($field, "<") + 1));
            $length = null;
            if (strpos($type, ':')) {
                $tmp = explode(':', $type);
                $type = $tmp[0];
                $length = (int)$tmp[1];
            }
            $current = [
                'name' => $name,
                'type' => $type,
                'length' => $length
            ];
            $this->fields[] = $current;
        }
        flock($file, LOCK_UN);
        fclose($file);
    }
    public function insert()
    {
        $touple = "\n";
        foreach ($this->fields as $field) {
            $value = readline("$field[name]: ");
            $touple .= "$value|";
        }
        $touple = substr($touple, 0, -1);
        $file = fopen($this->filename, 'c');
        flock($file, LOCK_EX);
        fseek($file, 0, SEEK_END);
        fwrite($file, $touple);
        flock($file, LOCK_UN);
        fclose($file);
    }

    public function extract_from_storage(bool $all, int|string $field_id = null, string $operator = null, string $needle = null)
    {
        $data = [];
        $tbl = $this->getTableContext();
        $file = fopen($this->filename, 'r');
        flock($file, LOCK_SH);
        $headers = explode(self::FIELD_SEPARATOR, fgets($file));
        $data[] = $headers;

        if(!is_numeric($field_id))
            $field_id = array_search($field_id, $tbl->_headers);

        while (($line = fgets($file))) {
            if (strlen($line)) {
                $fields = explode('|', $line);
                if (!$all) {
                    switch ($operator) {
                        case '%':
                            if (strpos(strtolower($fields[$field_id]), strtolower($needle)) !== false)
                                $data[] = ($fields);
                            break;
                        case '=':
                            if ($fields[$field_id] == $needle)
                                $data[] = ($fields);
                            break;
                        case '>=':
                            if ((float)$fields[$field_id] >= (float)$needle)
                                $data[] = ($fields);
                            break;
                        case '<=':
                            if ((float)$fields[$field_id] >= (float)$needle)
                                $data[] = ($fields);
                            break;
                        case '>':
                            if ((float)$fields[$field_id] > (float)$needle)
                                $data[] = ($fields);
                            break;
                        case '<':
                            if ((float)$fields[$field_id] > (float)$needle)
                                $data[] = ($fields);
                            break;
                    }
                } else $data[] = ($fields);
            }
        }
        flock($file, LOCK_UN);
        fclose($file);
        return $data;
    }

    public function select(bool $all, int|string $field_id = null, string $operator = null, string $needle = null)
    {
        $tbl = $this->getTableContext();
        $data = $this->extract_from_storage($all, $field_id, $operator, $needle);
        $len = count($data);
        for($i=1;$i<$len;$i++) {
            $tbl->addRow($data[$i]);
        }
        echo $tbl->getTable();
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    private function getTableContext()
    {
        $tbl = new Console_Table();
        $headers = [];
        $hlen = count($this->fields);
        for ($i = 0; $i < $hlen; $i++)
            $headers[] = $this->fields[$i]['name'];
        $tbl->setHeaders($headers);
        return $tbl;
    }

    public function import()
    {

    }

    public function export(bool $all, int|string $field_id = null, string $operator = null, string $needle = null)
    {
        $data = $this->extract_from_storage($all, $field_id, $operator, $needle);
        $len = count($data);
        $file = fopen('./exported_'.date('Y-m-d_H:i:s').'.csv', 'w+');
        flock($file, LOCK_EX);
        for($i=0;$i<$len;$i++) {
            fputcsv($file, $data[$i], self::EX_FIELD_SEPARATOR);
        }
        flock($file, LOCK_UN);
        fclose($file);
    }
}
