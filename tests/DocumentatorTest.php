<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class DocumentatorTest extends TestCase
{
    public function test(): void
    {
        $message = [];

        $reflection = new ReflectionClass(UserSignedUp::class);
        $properties = $reflection->getProperties();

        $message['name'] = $reflection->getShortName();

        foreach ($properties as $property) {
            $type = $property->getType();
            $name = $property->getName();

            $message['properties'][] = [
                'name' => $name,
                'type' => $type->getName(),
            ];
        }

        $expected = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                ],
                [
                    'name' => 'age',
                    'type' => 'int',
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'bool',
                ],
            ],
        ];

        $this->assertEquals($expected, $message);
    }
}