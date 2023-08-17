<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

enum PropertyType: string
{
    case STRING = 'string';
    case BOOL = 'boolean';
    case DATE = 'date';
    case DATETIME = 'date-time';
    case INT = 'integer';
    case ENUM = 'enum';
}
