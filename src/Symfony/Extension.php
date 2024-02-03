<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationEditor;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\ReflectionDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Generator\GeneratorFactory;
use Ferror\AsyncapiDocBundle\Generator\JsonGenerator;
use Ferror\AsyncapiDocBundle\Generator\YamlGenerator;
use Ferror\AsyncapiDocBundle\Schema\SchemaGeneratorFactory;
use Ferror\AsyncapiDocBundle\Schema\V2\ChannelRenderer as ChannelV2Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\ChannelRenderer as ChannelV3Renderer;
use Ferror\AsyncapiDocBundle\Schema\V2\InfoRenderer as InfoV2Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\InfoRenderer as InfoV3Renderer;
use Ferror\AsyncapiDocBundle\Schema\V2\MessageRenderer as MessageV2Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\MessageRenderer as MessageV3Renderer;
use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer as SchemaV2Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\SchemaRenderer as SchemaV3Renderer;
use Ferror\AsyncapiDocBundle\Schema\V3\ServerRenderer as ServerV3Renderer;
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
            ->addTag('ferror.asyncapi_doc_bundle.documentation-strategy')
        ;

        $container
            ->register('ferror.asyncapi_doc_bundle.documentation.reflection', ReflectionDocumentationStrategy::class)
            ->addTag('ferror.asyncapi_doc_bundle.documentation-strategy')
        ;

        $container
            ->register(DocumentationEditor::class)
        ;

        // Async API v2
        $container->register(ChannelV2Renderer::class);
        $container->register(MessageV2Renderer::class);
        $container
            ->register(InfoV2Renderer::class)
            ->addArgument($config['title'])
            ->addArgument($config['description'])
            ->addArgument($config['version'])
        ;

        $container
            ->register(SchemaV2Renderer::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.class_finder.manual'))
            ->addArgument(new Reference(DocumentationEditor::class))
            ->addArgument(new Reference(ChannelV2Renderer::class))
            ->addArgument(new Reference(MessageV2Renderer::class))
            ->addArgument(new Reference(InfoV2Renderer::class))
            ->addArgument($config['servers'])
            ->addArgument($config['asyncapi_version'])
        ;

        // Async API v3
        $container->register(ChannelV3Renderer::class);
        $container->register(MessageV3Renderer::class);
        $container
            ->register(ServerV3Renderer::class)
            ->addArgument($config['servers'])
        ;
        $container
            ->register(InfoV3Renderer::class)
            ->addArgument($config['title'])
            ->addArgument($config['description'])
            ->addArgument($config['version'])
        ;

        $container
            ->register(SchemaV3Renderer::class)
            ->addArgument(new Reference('ferror.asyncapi_doc_bundle.class_finder.manual'))
            ->addArgument(new Reference(DocumentationEditor::class))
            ->addArgument(new Reference(InfoV3Renderer::class))
            ->addArgument(new Reference(MessageV3Renderer::class))
            ->addArgument(new Reference(ChannelV3Renderer::class))
            ->addArgument(new Reference(ServerV3Renderer::class))
            ->addArgument($config['asyncapi_version'])
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
            ->addArgument(new Reference(MessageV2Renderer::class))
            ->addTag('console.command')
        ;
    }
}
