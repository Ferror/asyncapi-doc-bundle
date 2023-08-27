<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\ClassFinder\NativeClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Schema;
use Ferror\AsyncapiDocBundle\Symfony\Console\DumpSpecificationConsole;
use Ferror\AsyncapiDocBundle\Symfony\Controller\SpecificationController;
use Ferror\AsyncapiDocBundle\Symfony\Controller\UserInterfaceController;
use Ferror\AsyncapiDocBundle\YamlGenerator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle as SymfonyBundle;

class Bundle extends SymfonyBundle
{
    public function build(ContainerBuilder $container): void
    {
        $container
            ->register('ferror.asyncapi_doc_bundle.class_finder.native', NativeClassFinder::class)
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.documentation.attributes', AttributeDocumentationStrategy::class)
        ;

        $container
            ->register(Schema::class)
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.yaml', YamlGenerator::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.class_finder.native'))
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.documentation.attributes'))
            ->addArgument(new Reference(Schema::class))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.controller', SpecificationController::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.yaml'))
            ->addTag('controller.service_arguments')
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.controller.ui', UserInterfaceController::class)
            ->addTag('controller.service_arguments')
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.console', DumpSpecificationConsole::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.yaml'))
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.documentation.attributes'))
            ->addArgument(new Reference(Schema::class))
            ->addTag('console.command')
        ;
    }
}
