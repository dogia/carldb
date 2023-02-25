<?php

namespace Dogia\Carldb\Application\Output;

interface Storage {
    public function __construct(string $dir);
    public function getFields(): array;
    public function putObject($object): bool;
    public function getAllObjects(): array;
    public function getObjectsByField($field, $operator, $needle): mixed;
    public function updateObject($field, $operator, $needle): bool;
    public function deleteObject($field, $operator, $needle): bool;
    public function setTable($table): void;
    public function listTables(): void;
}
