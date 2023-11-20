<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\PropertyExtractor;
use Ferror\AsyncapiDocBundle\Tests\Examples\ProductCreated;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

class AttributeDocumentationStrategyTest extends TestCase
{
    public function testUserSignedUp(): void
    {
        $documentation = new AttributeDocumentationStrategy(new PropertyExtractor());

        $expected = [
            'name' => 'UserSignedUp',
            'channel' => 'user_signed_up',
            'channelType' => 'subscribe',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                    'description' => 'Name of the user',
                    'example' => 'John',
                    'format' => 'string',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'description' => 'Email of the user',
                    'format' => 'email',
                    'example' => 'john@example.com',
                ],
                [
                    'name' => 'age',
                    'type' => 'integer',
                    'description' => 'Age of the user',
                    'format' => 'int32',
                    'example' => '18',
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                    'description' => 'Is user a citizen',
                    'format' => 'boolean',
                    'example' => 'true',
                ],
            ],
        ];

        $this->assertEquals($expected, $documentation->document(UserSignedUp::class));
    }

    public function testProductCreated(): void
    {
        $documentation = new AttributeDocumentationStrategy(new PropertyExtractor());

        $expected = [
            'name' => 'ProductCreated',
            'channel' => 'product.created',
            'channelType' => 'subscribe',
            'properties' => [
                [
                    'name' => 'id',
                    'description' => '',
                    'type' => 'integer',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'amount',
                    'description' => '',
                    'type' => 'number',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'currency',
                    'description' => '',
                    'type' => 'string',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'isPaid',
                    'description' => '',
                    'type' => 'boolean',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'createdAt',
                    'description' => '',
                    'type' => 'string',
                    'format' => 'date-time',
                    'example' => null,
                ],
                [
                    'name' => 'week',
                    'description' => '',
                    'type' => 'integer',
                    'enum' => [1, 2, 3, 4, 5, 6, 7],
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'payment',
                    'description' => '',
                    'type' => 'object',
                    'items' => [],
                ],
                [
                    'name' => 'products',
                    'description' => '',
                    'type' => 'array',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'tags',
                    'description' => '',
                    'type' => 'array',
                    'format' => null,
                    'example' => null,
                    'itemsType' => 'string',
                ],
            ],
        ];

        $this->assertEquals($expected, $documentation->document(ProductCreated::class));
    }
}
