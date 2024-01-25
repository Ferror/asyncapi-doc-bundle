<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V3;

use Ferror\AsyncapiDocBundle\Schema\V3\ChannelRenderer;
use PHPUnit\Framework\TestCase;

final class ChannelRendererTest extends TestCase
{
    public function testItRenders(): void
    {
        $renderer = new ChannelRenderer();

        $document = [];

        $actual = $renderer->render($document);

        $expected = [
            'UserSignedUpChannel' => [
                'messages' => [
                    'UserSignedUp' => [
                        '$ref' => '#/components/messages/UserSignedUp',
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}
