<?php

declare(strict_types=1);

namespace Sigedi\JasperReportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sigedi_jasper_report');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('host')->end()
            ->scalarNode('username')->end()
            ->scalarNode('password')->end()
            ->scalarNode('org_id')->end()
            ->integerNode('timeout')->min(1)->end()
            ->end();

        return $treeBuilder;
    }
}
