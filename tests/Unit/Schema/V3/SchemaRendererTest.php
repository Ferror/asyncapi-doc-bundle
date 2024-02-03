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
use Ferror\AsyncapiDocBundle\Schema\V3\OperationRenderer;
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
            new InfoRenderer(),
            new MessageRenderer(),
            new OperationRenderer(),
            new ChannelRenderer(),
            [],
            '3.0.0',
        );

        $actual = $renderer->generate();

        $expected = [
            'asyncapi' => '3.0.0',
            'info' => [
                'title' => 'Account Service',
                'version' => '1.0.0',
                'description' => 'This service is in charge of processing user signups',
            ],
            'channels' => [
                'userSignedUpChannel' => [
                    'messages' => [
                        'UserSignedUp' => [
                            '$ref' => '#/components/messages/UserSignedUp',
                        ],
                    ],
                ],
            ],
            'operations' => [
                'sendUserSignedUpOperation' => [
                    'action' => 'send',
                    'channel' => [
                        '$ref' => '#/channels/userSignedUpChannel',
                    ],
                ],
                'receiveUserSignedUpOperation' => [
                    'action' => 'receive',
                    'channel' => [
                        '$ref' => '#/channels/userSignedUpChannel',
                    ],
                ],
            ],
            'components' => [
                'messages' => [
                    'UserSignedUp' => [
                        'payload' => [
                            'type' => 'object',
                            'properties' => [
                                'displayName' => [
                                    'type' => 'string',
                                    'description' => 'Name of the user',
                                ],
                                'email' => [
                                    'type' => 'string',
                                    'format' => 'email',
                                    'description' => 'Email of the user',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
