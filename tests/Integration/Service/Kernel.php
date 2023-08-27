<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Integration\Service;

use Ferror\AsyncapiDocBundle\Symfony\Bundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;

class Kernel extends SymfonyKernel
{
    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new Bundle();
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/framework.yaml');
    }
}
