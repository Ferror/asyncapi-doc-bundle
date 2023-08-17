<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Symfony\Component\Yaml\Yaml;

class YamlSchema
{
    public function render(array $document): string
    {
        $properties = [];

        foreach ($document['properties'] as $property) {
            $properties[$property['name']] = [
                'type' => PropertyTypeTranslator::translate($property['type']),
            ];
        }

        $message[$document['name']] = [
            'payload' => [
                'type' => 'object',
                'properties' => $properties,
            ],
        ];

        return Yaml::dump($message, 10, 2);
    }
}