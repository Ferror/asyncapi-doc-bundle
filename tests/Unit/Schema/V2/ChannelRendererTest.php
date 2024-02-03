<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V2;

use Ferror\AsyncapiDocBundle\Schema\V2\ChannelRenderer;
use PHPUnit\Framework\TestCase;

class ChannelRendererTest extends TestCase
{
    public function testSingleChannel(): void
    {
        $document = [
            'name' => 'UserSignedUp',
            'channels' => [
                [
                    'name' => 'UserSignedUpChannel',
                    'type' => 'subscribe',
                ]
            ]
        ];

        $schema = new ChannelRenderer();

        $actual = $schema->render($document);

        $expected = [
            'UserSignedUpChannel' => [
                'subscribe' => [
                    'message' => [
                        '$ref' => '#/components/messages/UserSignedUp',
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}
