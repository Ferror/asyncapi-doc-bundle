<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V3;

use Ferror\AsyncapiDocBundle\Schema\V3\ChannelRenderer;
use Ferror\AsyncapiDocBundle\Schema\V3\OperationRenderer;
use PHPUnit\Framework\TestCase;

final class OperationRendererTest extends TestCase
{
    public function testItRendersSendAction(): void
    {
        $renderer = new OperationRenderer();

        $document = [
            'name' => 'UserSignedUp',
            'properties' => [],
            'operations' => [
                [
                    'name' => 'UserSignedUpOperation',
                    'type' => 'send',
                    'channels' => [
                        [
                            'name' => 'UserSignedUpChannel',
                            'type' => 'subscribe',
                        ]
                    ],
                ]
            ],
        ];

        $actual = $renderer->render($document);

        $expected = [
            'UserSignedUpOperation' => [
                'action' => 'send',
                'channel' => [
                    '$ref' => '#/channels/UserSignedUpChannel',
                ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testItRendersReceiveAction(): void
    {
        $renderer = new OperationRenderer();

        $document = [
            'name' => 'UserSignedUp',
            'properties' => [],
            'operations' => [
                [
                    'name' => 'UserSignedUpOperation',
                    'type' => 'receive',
                    'channels' => [
                        [
                            'name' => 'UserSignedUpChannel',
                            'type' => 'subscribe',
                        ]
                    ],
                ]
            ],
        ];

        $actual = $renderer->render($document);

        $expected = [
            'UserSignedUpOperation' => [
                'action' => 'receive',
                'channel' => [
                    '$ref' => '#/channels/UserSignedUpChannel',
                ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}
