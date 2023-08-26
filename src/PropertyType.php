<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

/**
 * AsyncAPI Types
 */
enum PropertyType
{
    case STRING;
    case BOOLEAN;
    case INTEGER;
    case FLOAT;
}
