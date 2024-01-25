<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V3;

use Ferror\AsyncapiDocBundle\Schema\V3\SchemaRenderer;
use PHPUnit\Framework\TestCase;

final class SchemaRendererTest extends TestCase
{
    public function testItRenders(): void
    {
        $renderer = new SchemaRenderer();

        $actual = $renderer->generate();

        $expected = [];

        $this->assertEquals($expected, $actual);
    }
}
