<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\NativeClassFinder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as SymfonyBundle;

class Bundle extends SymfonyBundle
{
    public function build(ContainerBuilder $container): void
    {
        $container
            ->register('ferror.asyncapi_doc_bundle.class_fetcher', NativeClassFinder::class)
        ;
    }
}
