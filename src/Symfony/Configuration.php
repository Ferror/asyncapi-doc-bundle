<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final readonly class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder(Extension::BUNDLE_ALIAS);
        $root = $builder->getRootNode();
        $root
            ->children()
                ->scalarNode('asyncapi_version')->defaultValue('2.6.0')->end()
                ->scalarNode('title')->end()
                ->scalarNode('version')->end()
                ->scalarNode('description')->defaultValue('')->end()
                ->arrayNode('servers')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('url')->end()
                            ->scalarNode('protocol')->end()
                            ->scalarNode('description')->end()
                            ->arrayNode('security')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('events')
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
