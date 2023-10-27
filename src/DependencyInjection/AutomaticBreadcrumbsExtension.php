<?php

namespace Jugid\AutomaticBreadcrumbs\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class AutomaticBreadcrumbsExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('twig.xml');
        $loader->load('collections.xml');
        $loader->load('strategies.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $collection_id = $this->findId($container, 'jugid.automatic_breadcrumbs.collection', $config['collection_class']);
        $strategy_id = $this->findId($container, 'jugid.automatic_breadcrumbs.strategy', $config['strategy_class']);

        $container
            ->getDefinition($collection_id)
            ->addMethodCall('setIncludes', [$config['includes']])
        ;

        $container
            ->getDefinition('jugid_automatic_breadcrumbs.renderer.default')
            ->setArguments([new Reference('twig')])
            ->addMethodCall('setSeparator', [$config['separator']])
            ->addMethodCall('setTemplate', [$config['template']])
        ;

        $container
            ->getDefinition('jugid_automatic_breadcrumbs.breadcrumbs')
            ->setArguments([new Reference('twig'), new Reference($collection_id), new Reference('jugid_automatic_breadcrumbs.renderer.default')])
            ->addMethodCall('setAutomatic', [$config['automatic']])
            ->addMethodCall('setDetectMode', [$config['detect_mode']])
        ;
        
        $container
            ->getDefinition('Jugid\AutomaticBreadcrumbs\Subscriber\BreadcrumbsSubscriber')
            ->setArguments([new Reference('jugid_automatic_breadcrumbs.breadcrumbs'), new Reference('router'), new Reference('monolog.logger')])
            ->addMethodCall('setStrategy', [new Reference($strategy_id)])
        ;
    }

    private function findId(ContainerBuilder $container, string $tag, string $class) : string 
    {
        $available_ids = $container->findTaggedServiceIds($tag);
        
        try {
            $alias = $container->getAlias($class);
            return $alias->__toString();
        } catch(InvalidArgumentException $e) {
            throw new InvalidConfigurationException(sprintf('Class %s does not exist or is not registered as %s', $class, $tag));
        }
    }

    public function getAlias(): string
    {
        return 'jugid_automatic_breadcrumbs';
    }
}