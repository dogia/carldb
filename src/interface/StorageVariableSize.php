<?php

namespace Dogia\Carldb\Interface;

use Dogia\Carldb\Application\Output\Storage;

class StorageVariableSize implements Storage {
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
}
