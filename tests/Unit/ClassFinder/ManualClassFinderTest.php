<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\ClassFinder;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\Tests\Examples\PaymentExecuted;
use Ferror\AsyncapiDocBundle\Tests\Examples\ProductCreated;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

class ManualClassFinderTest extends TestCase
{
    public function testItFindsClasses(): void
    {
        $classes = [
            UserSignedUp::class,
            PaymentExecuted::class,
            ProductCreated::class,
        ];

        $fetcher = new ManualClassFinder($classes);

        $actual = $fetcher->find();

        $this->assertEquals($classes, $actual);
    }

    public function testItFiltersClasses(): void
    {
        $classes = [
            UserSignedUp::class,
            PaymentExecuted::class,
            ProductCreated::class,
        ];

        $fetcher = new ManualClassFinder($classes);

        $expected = [
            UserSignedUp::class,
        ];

        $actual = $fetcher->filter(fn (string $class) => $class === UserSignedUp::class);

        $this->assertEquals($expected, $actual);
    }
}
