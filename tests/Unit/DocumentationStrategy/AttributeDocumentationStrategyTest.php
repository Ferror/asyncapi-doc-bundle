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

        $actual = $documentation->document(UserSignedUp::class)->toArray();

        $expected = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                    'description' => 'Name of the user',
                    'example' => 'John',
                    'format' => 'string',
                    'required' => true,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'description' => 'Email of the user',
                    'format' => 'email',
                    'example' => 'john@example.com',
                    'required' => true,
                ],
                [
                    'name' => 'age',
                    'type' => 'integer',
                    'description' => 'Age of the user',
                    'format' => 'int32',
                    'example' => '18',
                    'required' => true,
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                    'description' => 'Is user a citizen',
                    'format' => 'boolean',
                    'example' => 'true',
                    'required' => true,
                ],
            ],
            'channels' => [
                [
                    'name' => 'user_signed_up',
                    'type' => 'subscribe',
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testProductCreated(): void
    {
        $documentation = new AttributeDocumentationStrategy(new PropertyExtractor());

        $actual = $documentation->document(ProductCreated::class)->toArray();

        $expected = [
            'name' => 'ProductCreated',
            'properties' => [
                [
                    'name' => 'id',
                    'description' => '',
                    'type' => 'integer',
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'amount',
                    'description' => '',
                    'type' => 'number',
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'currency',
                    'description' => '',
                    'type' => 'string',
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'isPaid',
                    'description' => '',
                    'type' => 'boolean',
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'createdAt',
                    'description' => '',
                    'type' => 'string',
                    'format' => 'date-time',
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'week',
                    'description' => '',
                    'type' => 'integer',
                    'enum' => [1, 2, 3, 4, 5, 6, 7],
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'payment',
                    'description' => '',
                    'type' => 'object',
                    'items' => [],
                    'required' => true,
                ],
                [
                    'name' => 'products',
                    'description' => '',
                    'type' => 'array',
                    'format' => null,
                    'example' => null,
                    'required' => true,
                ],
                [
                    'name' => 'tags',
                    'description' => '',
                    'type' => 'array',
                    'format' => null,
                    'example' => null,
                    'itemsType' => 'string',
                    'required' => true,
                ],
            ],
            'channels' => [
                [
                    'name' => 'product.created',
                    'type' => 'subscribe',
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
