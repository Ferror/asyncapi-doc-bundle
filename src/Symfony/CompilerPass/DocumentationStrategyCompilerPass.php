<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\CompilerPass;

use Ferror\AsyncapiDocBundle\DocumentationEditor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final readonly class DocumentationStrategyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds('ferror.asyncapi_doc_bundle.documentation-strategy');

        $documentationEditorDefinition = $container->getDefinition(DocumentationEditor::class);

        $taggedServices = array_map(
            static fn ($serviceId) => new Reference($serviceId),
            array_keys($taggedServices)
        );

        $documentationEditorDefinition->addArgument($taggedServices);
    }
}
