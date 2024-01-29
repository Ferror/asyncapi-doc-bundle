<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\DocumentationStrategy\ReflectionDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Tests\Examples\ProductCreated;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

class ReflectionDocumentationStrategyTest extends TestCase
{
    public function test(): void
    {
        $documentation = new ReflectionDocumentationStrategy();

        $expected = [
            'name' => 'UserSignedUp',
            'channel' => 'user_signed_up',
            'channelType' => 'subscribe',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                    'required' => true,
                    'description' => '',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'required' => true,
                    'description' => '',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'age',
                    'type' => 'integer',
                    'required' => true,
                    'description' => '',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                    'required' => true,
                    'description' => '',
                    'format' => null,
                    'example' => null,
                ],
            ],
        ];

        $this->assertEquals($expected, $documentation->document(UserSignedUp::class)->toArray());
    }

    public function testEnum(): void
    {
        $documentation = new ReflectionDocumentationStrategy();

        $expected = [
            'name' => 'ProductCreated',
            'channel' => 'product.created',
            'channelType' => 'subscribe',
            'properties' => [
                [
                    'name' => 'id',
                    'description' => '',
                    'required' => true,
                    'type' => 'integer',
                    'format' => null,
                    'example' => null
                ],
                [
                    'name' => 'amount',
                    'description' => '',
                    'required' => true,
                    'type' => 'number',
                    'format' => null,
                    'example' => null
                ],
                [
                    'name' => 'currency',
                    'description' => '',
                    'required' => true,
                    'type' => 'string',
                    'format' => null,
                    'example' => null
                ],
                [
                    'name' => 'isPaid',
                    'description' => '',
                    'required' => true,
                    'type' => 'boolean',
                    'format' => null,
                    'example' => null
                ],
            ],
        ];


        $actual = $documentation->document(ProductCreated::class)->toArray();

        $this->assertEquals($expected, $actual);
    }
}
