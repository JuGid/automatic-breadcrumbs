<?php

namespace Jugid\AutomaticBreadcrumbs\Subscriber;

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;
use Jugid\AutomaticBreadcrumbs\Resolver\BreadcrumbAttributeResolver;
use Jugid\AutomaticBreadcrumbs\Exception\UnresolvedException;
use Jugid\AutomaticBreadcrumbs\Resolver\ResolverInterface;
use Jugid\AutomaticBreadcrumbs\Strategy\HierarchyStrategy;
use Jugid\AutomaticBreadcrumbs\Strategy\StrategyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;

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
        $controller = $event->getController();

        if($controller instanceof ErrorController) {
            return;
        }

        //Deactivate this subscriber if the bundle is in manual
        if(!$this->breadcrumbs->isAutomatic()) {
            return;
        }

        //Exclude paths from profiler calls
        if(str_starts_with($event->getRequest()->getPathInfo(), '/_')) {
            return;
        }

        $paths = $this->strategy->decompose($event->getRequest()->getPathInfo());
        $do_not_add_more = false;
        
        foreach($paths as $path) {
            try {
                if(!$this->breadcrumbs->getCollection()->isIncluded($path)) {
                    continue;
                }

                if($do_not_add_more) {
                    continue;
                }

                $match = $this->router->match($path);
                $route = $this->router->getRouteCollection()->get($match['_route']);
                $breadcrumb_attribute = $this->resolver->resolve($route->getDefaults()['_controller']);

                if(null !== $breadcrumb_attribute) {
                    $this->breadcrumbs
                        ->getCollection()
                        ->prependItemNamespace(
                            $breadcrumb_attribute->getNamespace(), 
                            $breadcrumb_attribute->getTitle(), 
                            $path
                        );
                    
                    if($breadcrumb_attribute->isRoot()) {
                        $do_not_add_more = true;
                    }
                }
            } catch(ResourceNotFoundException $e) {
                continue;
            } catch(UnresolvedException $e) {
                if($this->breadcrumbs->isDetectMode() && $_ENV['APP_ENV'] === 'dev') {
                    throw $e;
                }
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