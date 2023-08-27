<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\ClassFinder\NativeClassFinder;
use PHPUnit\Framework\TestCase;

class NativeClassFinderTest extends TestCase
{
    public function test(): void
    {
        $fetcher = new NativeClassFinder();

        $expected = [
            UserSignedUp::class,
            PaymentExecuted::class,
        ];

        $this->assertEquals($expected, $fetcher->find());
    }
}
