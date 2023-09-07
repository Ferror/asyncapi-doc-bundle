<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit;

use Ferror\AsyncapiDocBundle\ClassFinder\NativeClassFinder;
use Ferror\AsyncapiDocBundle\Tests\Examples\ProductCreated;
use Ferror\AsyncapiDocBundle\Tests\PaymentExecuted;
use Ferror\AsyncapiDocBundle\Tests\UserSignedUp;
use PHPUnit\Framework\TestCase;

class NativeClassFinderTest extends TestCase
{
    public function test(): void
    {
        $fetcher = new NativeClassFinder();

        $expected = [
            UserSignedUp::class,
            PaymentExecuted::class,
            ProductCreated::class,
        ];

        $this->assertEquals($expected, $fetcher->find());
    }
}
