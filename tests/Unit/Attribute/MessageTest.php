<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Attribute;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testEnrichAddsProperty(): void
    {
        $message = new Message('name');

        $message->enrich(new Message('name', [new Property('name')]));

        $this->assertCount(1, $message->properties);
    }

    public function testEnrichUpdatesProperty(): void
    {
        $message = new Message('name', [new Property('name')]);

        $message->enrich(new Message('name', [new Property('name', 'Nice Description')]));

        $this->assertEquals('Nice Description', $message->properties[0]->description);
    }
}
