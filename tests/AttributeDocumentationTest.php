<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\AttributeDocumentationStrategy;
use PHPUnit\Framework\TestCase;

class AttributeDocumentationTest extends TestCase
{
    public function test(): void
    {
        $documentation = new AttributeDocumentationStrategy();

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
                    'example' => 'john@example',

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
}