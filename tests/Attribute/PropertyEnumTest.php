<?php

declare(strict_types=1);

namespace Attribute;

use Ferror\AsyncapiDocBundle\Attribute\PropertyEnum;
use Ferror\AsyncapiDocBundle\Tests\Examples\Week;
use PHPUnit\Framework\TestCase;

class PropertyEnumTest extends TestCase
{
    public function testToArray(): void
    {
        $property = new PropertyEnum('enum-name', Week::class);

        $expected = [
            'name' => 'enum-name',
            'description' => '',
            'type' => 'integer',
            'enum' => [1, 2, 3, 4, 5, 6, 7],
            'format' => null,
            'example' => null,
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }
}
