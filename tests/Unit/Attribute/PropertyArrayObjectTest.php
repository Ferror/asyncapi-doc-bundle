<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Attribute;

use Ferror\AsyncapiDocBundle\Attribute\PropertyArrayObject;
use Ferror\AsyncapiDocBundle\Tests\Examples\Payment;
use PHPUnit\Framework\TestCase;

class PropertyArrayObjectTest extends TestCase
{
    public function testToArray(): void
    {
        $property = new PropertyArrayObject('object-name', Payment::class);

        $expected = [
            'name' => 'object-name',
            'description' => '',
            'type' => 'array',
            'format' => null,
            'example' => null,
            'required' => true,
        ];

        $actual = $property->toArray();

        $this->assertEquals($expected, $actual);
    }
}
