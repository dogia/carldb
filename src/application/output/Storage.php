<?php

namespace Dogia\Carldb\Application\Output;

interface Storage {
    public function putObject($object): bool;
    public function getAllObjects(): array;
    public function getObjectsByField($field, $operator, $needle): mixed;
    public function updateObject($field, $operator, $needle): bool;
    public function deleteObject($field, $operator, $needle): bool;
}
