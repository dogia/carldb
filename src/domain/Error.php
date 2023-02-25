<?php

namespace Dogia\Carldb\Domain;

enum Error: string {
    case NO_TABLE_SELECTED  = "Debe seleccionar una tabla antes de realizar operaciones.";
    case INVALID_TABLE_NAME = "El nombre de la tabla es inválido o no existe.";
    case UNKNOWN_COMMAND    = "Comando desconocido.";
    case INVALID_EXPRESION  = "Expresión inválida.";
}