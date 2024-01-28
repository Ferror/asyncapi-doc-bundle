<?php

declare(strict_types=1);

namespace App;

use Ferror\AsyncapiDocBundle\Tests\Integration\Service\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

class UserInterfaceControllerTest extends TestCase
{
    public function test(): void
    {
        $client = new KernelBrowser(new Kernel('test', true));

        $client->request(Request::METHOD_GET, '/asyncapi');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
