<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\Symfony\CompilerPass\DocumentationStrategyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as SymfonyBundle;

class Bundle extends SymfonyBundle
{
    public function getContainerExtension(): Extension
    {
        return new Extension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DocumentationStrategyCompilerPass());
    }
}
