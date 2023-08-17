<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\AttributeDocumentation;
use PHPUnit\Framework\TestCase;

class AttributeDocumentationTest extends TestCase
{
    public function test(): void
    {
        $documentation = new AttributeDocumentation();

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
                    'type' => 'integer',
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                ],
            ],
        ];

        $this->assertEquals($expected, $documentation->document());
    }
}