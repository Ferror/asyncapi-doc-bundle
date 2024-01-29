<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

class YamlSpecificationControllerTest extends TestCase
{
    public function test(): void
    {
        $client = new KernelBrowser(new Kernel('test', true));

        $client->request(Request::METHOD_GET, '/asyncapi.yaml');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
