<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

/**
 * AsyncAPI Format Types
 */
enum Format: string
{
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATETIME = 'date-time';
    case INTEGER = 'int32';
    case FLOAT = 'float';
    case EMAIL = 'email';
    case PASSWORD = 'password';
}
