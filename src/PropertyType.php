<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

enum PropertyType: string
{
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATETIME = 'date-time';
    case INTEGER = 'integer';
    case ENUM = 'enum';
}
