<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Attribute;

use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    public function testToArray(): void
    {
        $property = new Property(
            name: 'name',
            description: '',
            type: PropertyType::STRING,
        );

        $expected = [
            'name' => 'name',
            'description' => '',
            'type' => 'string',
            'format' => null,
            'example' => null,
            'required' => true,
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }
}
