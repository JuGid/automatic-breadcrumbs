<?php

namespace Jugid\AutomaticBreadcrumbs\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder(): TreeBuilder { 
        $treeBuilder = new TreeBuilder("jugid_automatic_breadcrumbs");

        $rootNode = $treeBuilder->getRootNode();

        $rootNode->
            children()
                ->booleanNode('automatic')->defaultTrue()->end()
                ->booleanNode('detect_mode')->defaultFalse()->end()
                ->scalarNode('separator')->defaultValue('/')->end()
                ->scalarNode('template')->defaultValue('@AutomaticBreadcrumbs/view.html.twig')->end()
                ->scalarNode('collection_class')->defaultValue('Jugid\AutomaticBreadcrumbs\Collection\BreadcrumbsCollection')->end()
                ->scalarNode('strategy_class')->defaultValue('Jugid\AutomaticBreadcrumbs\Strategy\HierarchyStrategy')->end()
                ->arrayNode('includes')->scalarPrototype()->end()->end()
            ->end()
        ;

        return $treeBuilder;
    }

}