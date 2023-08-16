<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

enum PropertyType: string
{
    case STRING = 'string';
    case BOOL = 'boolean';
    case DATETIME = 'date-time';
    case ENUM = 'enum';
}
