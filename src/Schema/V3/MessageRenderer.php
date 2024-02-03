<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

use Ferror\AsyncapiDocBundle\PropertyTypeTranslator;

final readonly class MessageRenderer
{
    public function render(array $document): array
    {
        $properties = [];
        $required = [];

        foreach ($document['properties'] as $property) {
            $properties[$property['name']]['type'] = PropertyTypeTranslator::translate($property['type']);

            if (!empty($property['description'])) {
                $properties[$property['name']]['description'] = $property['description'];
            }

            if (!empty($property['format'])) {
                $properties[$property['name']]['format'] = $property['format'];
            }

            if (!empty($property['example'])) {
                $properties[$property['name']]['example'] = $property['example'];
            }

            if (isset($property['required']) && $property['required']) {
                $required[] = $property['name'];
            }
        }

        $message[$document['name']] = [
            'payload' => [
                'type' => 'object',
                'properties' => $properties,
                'required' => $required,
            ],
        ];

        return $message;
    }
}
