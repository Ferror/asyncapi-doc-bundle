<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V3;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationEditor;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\PropertyExtractor;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\ReflectionDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Schema\V3\ChannelRenderer;
use Ferror\AsyncapiDocBundle\Schema\V3\InfoRenderer;
use Ferror\AsyncapiDocBundle\Schema\V3\MessageRenderer;
use Ferror\AsyncapiDocBundle\Schema\V3\SchemaRenderer;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

final class SchemaRendererTest extends TestCase
{
    public function testItRenders(): void
    {
        $renderer = new SchemaRenderer(
            new ManualClassFinder([
                UserSignedUp::class,
            ]),
            new DocumentationEditor([
                new AttributeDocumentationStrategy(new PropertyExtractor()),
                new ReflectionDocumentationStrategy(),
            ]),
            new InfoRenderer('Service Example API', 'This service is in charge of processing user signups', '1.0.0'),
            new MessageRenderer(),
            new ChannelRenderer(),
            [],
            '3.0.0',
        );

        $actual = $renderer->generate();

        $expected = [
            'asyncapi' => '3.0.0',
            'info' => [
                'title' => 'Service Example API',
                'version' => '1.0.0',
                'description' => 'This service is in charge of processing user signups',
            ],
            'channels' => [
                'user_signed_up' => [
                    'messages' => [
                        'UserSignedUp' => [
                            '$ref' => '#/components/messages/UserSignedUp',
                        ],
                    ],
                ],
            ],
            'components' => [
                'messages' => [
                    'UserSignedUp' => [
                        'payload' => [
                            'type' => 'object',
                            'properties' => [
                                'name' => [
                                    'type' => 'string',
                                    'description' => 'Name of the user',
                                    'format' => 'string',
                                    'example' => 'John',
                                ],
                                'email' => [
                                    'type' => 'string',
                                    'description' => 'Email of the user',
                                    'format' => 'email',
                                    'example' => 'john@example.com',
                                ],
                                'age' => [
                                    'type' => 'integer',
                                    'description' => 'Age of the user',
                                    'format' => 'int32',
                                    'example' => 18,
                                ],
                                'isCitizen' => [
                                    'type' => 'boolean',
                                    'description' => 'Is user a citizen',
                                    'format' => 'boolean',
                                    'example' => true,
                                ],
                            ],
                            'required' => ['name', 'email', 'age', 'isCitizen'],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
