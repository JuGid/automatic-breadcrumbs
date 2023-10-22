<?php

namespace Jugid\AutomaticBreadcrumbs\Subscriber;

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;
use Jugid\AutomaticBreadcrumbs\Resolver\BreadcrumbAttributeResolver;
use Jugid\AutomaticBreadcrumbs\Exception\UnresolvedException;
use Jugid\AutomaticBreadcrumbs\Resolver\ResolverInterface;
use Jugid\AutomaticBreadcrumbs\Strategy\StrategyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;

/**
 * This subscriber is used to create automatic breadcrumbs
 * using the strategy define in the configuration
 * 
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class BreadcrumbsSubscriber implements EventSubscriberInterface 
{
    private ResolverInterface $resolver;
    private StrategyInterface $strategy;

    public function __construct(
        private Breadcrumbs $breadcrumbs,
        private RouterInterface $router,
        private LoggerInterface $logger
    ){
        $this->resolver = new BreadcrumbAttributeResolver();
    }

    public function onKernelController(ControllerEvent $event): void
    {
        //Deactivate this subscriber if the bundle is in manual
        if(!$this->breadcrumbs->isAutomatic()) {
            return;
        }

        //Exclude paths from profiler calls
        if(str_starts_with($event->getRequest()->getPathInfo(), '/_')) {
            return;
        }

        $controller = $event->getController();

        if($controller instanceof ErrorController) {
            return;
        }

        $paths = $this->strategy->decompose($event->getRequest()->getPathInfo());
        $breadcrumb_collection = $this->breadcrumbs->getCollection();

        foreach($paths as $path) {
            try {
                if(!$this->breadcrumbs->getCollection()->isIncluded($path)) {
                    continue;
                }

                $match = $this->router->match($path);
                $breadcrumb_attribute = $this->resolver->resolve($match['_controller']);

                if(null !== $breadcrumb_attribute) {
                    $breadcrumb_collection->prependItemNamespace(
                        $breadcrumb_attribute->getNamespace(), 
                        $breadcrumb_attribute->getTitle(), 
                        $path
                    );
                    
                    if($breadcrumb_attribute->isRoot()) {
                        return;
                    }
                }
            } catch(ResourceNotFoundException | UnresolvedException $e) {
                if($this->breadcrumbs->isDetectMode()) { throw $e; }
                continue;
            }
        }
    }

    public function setStrategy(StrategyInterface $strategy) : void
    {
        $this->strategy = $strategy;
    }

    public static function getSubscribedEvents() { 
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
    
}