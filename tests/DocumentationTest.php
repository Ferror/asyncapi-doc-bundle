<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\Documentation;
use PHPUnit\Framework\TestCase;

class DocumentationTest extends TestCase
{
    public function test(): void
    {
        $documentation = new Documentation();

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

        $this->assertEquals($expected, $documentation->document());
    }
}