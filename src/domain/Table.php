<?php

namespace Dogia\Carldb\Domain;

interface Table {
    public function insert();
    public function select(bool $all, int $field_id = null, string $operator = null, string $needle = null);
    public function update();
    public function delete();
}