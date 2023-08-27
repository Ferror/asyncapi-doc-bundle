<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Integration;

use Ferror\AsyncapiDocBundle\Tests\Integration\Service\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class SpecificationControllerTest extends TestCase
{
    public function test(): void
    {
        $client = new KernelBrowser(new Kernel('test', true));

        $client->request('GET', '/asyncapi');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
