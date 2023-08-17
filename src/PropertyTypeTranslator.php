<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use InvalidArgumentException;

class PropertyTypeTranslator
{
    public static function translate(string $type): string
    {
        return match ($type) {
            'bool' => 'boolean',
            'int' => 'integer',
            default => $type,
        };
    }
}