<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Generator\JsonGenerator;
use Ferror\AsyncapiDocBundle\Generator\YamlGenerator;
use Ferror\AsyncapiDocBundle\Schema;
use Ferror\AsyncapiDocBundle\Schema\InfoObject;
use Ferror\AsyncapiDocBundle\SchemaGenerator;
use Ferror\AsyncapiDocBundle\Symfony\Console\DumpSpecificationConsole;
use Ferror\AsyncapiDocBundle\Symfony\Controller\JsonSpecificationController;
use Ferror\AsyncapiDocBundle\Symfony\Controller\UserInterfaceController;
use Ferror\AsyncapiDocBundle\Symfony\Controller\YamlSpecificationController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as SymfonyExtension;

final class Extension extends SymfonyExtension
{
    public const BUNDLE_ALIAS = 'ferror_asyncapi_doc_bundle';

    public function getAlias(): string
    {
        return self::BUNDLE_ALIAS;
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container
            ->register('ferror.asyncapi_doc_bundle.class_finder.manual', ManualClassFinder::class)
            ->addArgument($config['events'])
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.documentation.attributes', AttributeDocumentationStrategy::class)
        ;

        $container
            ->register(Schema::class)
        ;

        $container
            ->register(InfoObject::class)
            ->addArgument($config['title'])
            ->addArgument($config['description'])
            ->addArgument($config['version'])
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.schema', SchemaGenerator::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.class_finder.manual'))
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.documentation.attributes'))
            ->addArgument(new Reference(Schema::class))
            ->addArgument($config['servers'])
            ->addArgument(new Reference(InfoObject::class))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.yaml', YamlGenerator::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.schema'))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.json', JsonGenerator::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.schema'))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.controller.yaml', YamlSpecificationController::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.yaml'))
            ->addTag('controller.service_arguments')
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.controller.json', JsonSpecificationController::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.json'))
            ->addTag('controller.service_arguments')
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.controller.ui', UserInterfaceController::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator.json'))
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
