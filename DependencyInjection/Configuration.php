<?php

namespace Ddeboer\GuzzleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $debug;

    /**
     * Constructor.
     *
     * @param Boolean $debug The kernel.debug value
     */
    public function __construct($debug)
    {
        $this->debug = (Boolean) $debug;
    }

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder
            ->root('guzzle')
                ->children()
                    ->arrayNode('service_builder')
                        ->children()
                            ->scalarNode('class')
                                ->defaultValue('Guzzle\Service\Builder\ServiceBuilder')
                            ->end()
                            ->scalarNode('configuration_file')
                                ->defaultValue('%kernel.root_dir%/config/webservices.xml')
                            ->end()

                            ->arrayNode('configuration')
                                ->useAttributeAsKey('name')
     
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('class')->end()
                                        ->scalarNode('extends')->end()
                                        ->arrayNode('params')
                                            ->children()
                                                ->scalarNode('base_url')->isRequired(true)->end()
                                                ->arrayNode('operations')
                                                    ->useAttributeAsKey('name')
                                                    ->prototype('array')
                                                        ->children()
                                                            ->scalarNode('httpMethod')->end()
                                                            ->scalarNode('uri')->end()
                                                            ->scalarNode('responseClass')->end()
                                                            ->arrayNode('parameters')
                                                                ->useAttributeAsKey('name')
                                                                ->prototype('array')
                                                                    ->children()
                                                                        ->scalarNode('location')->end()
                                                                        ->scalarNode('type')->end()
                                                                        ->scalarNode('required')->defaultValue(false)->end()
                                                                    ->end()
                                                                ->end()
                                                            ->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            
                        ->end()
                    ->end()
                    ->booleanNode('logging')->defaultValue($this->debug)->end()
                ->end()
            ->end();

        return $builder;
    }
}
