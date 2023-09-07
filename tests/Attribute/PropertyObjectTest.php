<?php

declare(strict_types=1);

namespace Attribute;

use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyObject;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;
use Ferror\AsyncapiDocBundle\Tests\Examples\Payment;
use PHPUnit\Framework\TestCase;

class PropertyObjectTest extends TestCase
{
    public function testToArray(): void
    {
        $property = new PropertyObject('object-name', Payment::class);

        $expected = [
            'name' => 'object-name',
            'description' => '',
            'type' => 'object',
            'items' => [],
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }

    public function testToArrayWithItems(): void
    {
        $property = new PropertyObject(
            name: 'object-name',
            class: Payment::class,
            items: [new Property(name: 'currency', type: PropertyType::STRING)]
        );

        $expected = [
            'name' => 'object-name',
            'description' => '',
            'type' => 'object',
            'items' => [
                [
                    'name' => 'currency',
                    'description' => '',
                    'type' => 'string',
                    'format' => null,
                    'example' => null,
                ]
            ],
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }
}
