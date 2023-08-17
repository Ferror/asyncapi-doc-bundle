<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\ClassFetcher;
use PHPUnit\Framework\TestCase;

class ClassFetcherTest extends TestCase
{
    public function test(): void
    {
        $fetcher = new ClassFetcher();

        $expected = [
            UserSignedUp::class,
            PaymentExecuted::class,
        ];

        $this->assertEquals($expected, $fetcher->get());
    }
}