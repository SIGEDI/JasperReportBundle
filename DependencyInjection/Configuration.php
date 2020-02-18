<?php

namespace Hboie\JasperReportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('jasperreport');
        $rootNode = \method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('hboie_jasper_report');

        $rootNode
            ->children()
            ->scalarNode('host')->end()
            ->scalarNode('username')->end()
            ->scalarNode('password')->end()
            ->scalarNode('org_id')->end()
            ->end();

        return $treeBuilder;
    }
}
