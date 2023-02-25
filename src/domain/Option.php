<?php

namespace Dogia\Carldb\Domain;

enum Option {
    case OPTION_AUTOR;
    case OPTION_HELP;
    case OPTION_SELECT_TABLE;
    case OPTION_LIST_TABLES;

    case OPTION_INSERT;
    case OPTION_UPDATE;
    case OPTION_SELECT;
    case OPTION_DELETE;

    case OPTION_IMPORT;
    case OPTION_EXPORT;

    public function get() {
        return $this->name;
    }
}