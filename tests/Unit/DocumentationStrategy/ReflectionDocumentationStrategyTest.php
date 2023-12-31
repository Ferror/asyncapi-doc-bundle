<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\DocumentationStrategy\ReflectionDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

class ReflectionDocumentationStrategyTest extends TestCase
{
    public function test(): void
    {
        $documentation = new ReflectionDocumentationStrategy();

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
            'required' => [
                'name',
                'email',
                'age',
                'isCitizen',
            ]
        ];

        $this->assertEquals($expected, $documentation->document(UserSignedUp::class));
    }
}
