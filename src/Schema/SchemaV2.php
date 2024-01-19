<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

use Ferror\AsyncapiDocBundle\PropertyTypeTranslator;
use Ferror\AsyncapiDocBundle\SchemaInterface;

class SchemaV2 implements SchemaInterface
{
    public function supports(string $version): bool
    {
        [$major, $minor, $patch] = explode('.', $version);

        return $major === '2';
    }

    public function renderMessage(array $document): array
    {
        $properties = [];
        $required = [];

        foreach ($document['properties'] as $property) {
            $properties[$property['name']]['type'] = PropertyTypeTranslator::translate($property['type']);

            if (isset($property['description'])) {
                $properties[$property['name']]['description'] = $property['description'];
            }

            if (isset($property['format'])) {
                $properties[$property['name']]['format'] = $property['format'];
            }

            if (isset($property['example'])) {
                $properties[$property['name']]['example'] = $property['example'];
            }

            if (isset($property['required'])) {
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

    public function renderChannel(array $document): array
    {
        $channel[$document['channel']] = [
            $document['channelType'] => [
                'message' => [
                    '$ref' => '#/components/messages/' . $document['name'],
                ],
            ],
        ];

        return $channel;
    }
}
