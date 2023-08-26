<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

class PropertyTypeTranslator
{
    public static function translate(string $type): string
    {
        return match ($type) {
            'bool', 'boolean' => 'boolean',
            'int', 'integer' => 'integer',
            'float', 'number' => 'number',
            default => 'string',
        };
    }
}