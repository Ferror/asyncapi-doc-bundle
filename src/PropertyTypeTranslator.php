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

    public static function a(PropertyType $type): string
    {
        return match ($type) {
            PropertyType::STRING => 'string',
            PropertyType::BOOLEAN => 'boolean',
            PropertyType::INTEGER => 'integer',
            PropertyType::FLOAT => 'number',
        };
    }
}