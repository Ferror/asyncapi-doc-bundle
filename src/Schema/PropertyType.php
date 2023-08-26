<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

/**
 * AsyncAPI Types
 */
enum PropertyType: string
{
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case INTEGER = 'integer';
    case FLOAT = 'number';
}
