<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Generator\GeneratorFactory;
use Ferror\AsyncapiDocBundle\Generator\JsonGenerator;
use Ferror\AsyncapiDocBundle\Generator\YamlGenerator;
use Ferror\AsyncapiDocBundle\Schema\SchemaGeneratorFactory;
use Ferror\AsyncapiDocBundle\Schema\V2\ChannelRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\InfoRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\MessageRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer as SchemaV2Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\SchemaRenderer as SchemaV3Renderer;
use Ferror\AsyncapiDocBundle\SchemaRendererInterface;
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

        // Async API v2
        $container->register(ChannelRenderer::class);
        $container->register(MessageRenderer::class);
        $container
            ->register(InfoRenderer::class)
            ->addArgument($config['title'])
            ->addArgument($config['description'])
            ->addArgument($config['version'])
        ;

        $container
            ->register(SchemaV2Renderer::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.class_finder.manual'))
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.documentation.attributes'))
            ->addArgument(new Reference(ChannelRenderer::class))
            ->addArgument(new Reference(MessageRenderer::class))
            ->addArgument(new Reference(InfoRenderer::class))
            ->addArgument($config['servers'])
            ->addArgument($config['asyncapi_version'])
        ;

        // Async API v3
        $container
            ->register(SchemaV3Renderer::class)
        ;

        // Version Agnostic
        $container
            ->register(SchemaGeneratorFactory::class)
            ->addArgument(new Reference(SchemaV2Renderer::class))
            ->addArgument(new Reference(SchemaV3Renderer::class))
        ;

        $container
            ->register(SchemaRendererInterface::class)
            ->setFactory(new Reference(SchemaGeneratorFactory::class))
            ->addArgument($config['asyncapi_version'])
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator-factory', GeneratorFactory::class)
            ->addArgument(new Reference(SchemaRendererInterface::class))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.yaml', YamlGenerator::class)
            ->addArgument(new Reference(SchemaRendererInterface::class))
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.generator.json', JsonGenerator::class)
            ->addArgument(new Reference(SchemaRendererInterface::class))
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
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.generator-factory'))
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.documentation.attributes'))
            ->addArgument(new Reference(MessageRenderer::class))
            ->addTag('console.command')
        ;
    }
}
