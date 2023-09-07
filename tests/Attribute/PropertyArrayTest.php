<?php

declare(strict_types=1);

namespace Attribute;

use Ferror\AsyncapiDocBundle\Attribute\PropertyArray;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;
use PHPUnit\Framework\TestCase;

class PropertyArrayTest extends TestCase
{
    public function testToArray(): void
    {
        $property = new PropertyArray(
            name: 'object-name',
            itemsType: PropertyType::STRING,
        );

        $expected = [
            'name' => 'object-name',
            'description' => '',
            'type' => 'array',
            'itemsType' => 'string',
            'format' => null,
            'example' => null,
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }
}
