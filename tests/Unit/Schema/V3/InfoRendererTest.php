<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V3;

use Ferror\AsyncapiDocBundle\Schema\V3\InfoRenderer;
use PHPUnit\Framework\TestCase;

final class InfoRendererTest extends TestCase
{
    public function testItRenders(): void
    {
        $renderer = new InfoRenderer('Async API Title', 'Async API Description', '2.6.0');

        $actual = $renderer->render();

        $expected = [
            'version' => '2.6.0',
            'title' => 'Async API Title',
            'description' => 'Async API Description',
        ];

        $this->assertEquals($expected, $actual);
    }
}
