<?php

namespace Jugid\AutomaticBreadcrumbs\Resolver;

use Jugid\AutomaticBreadcrumbs\Attribute\Breadcrumb;
use Jugid\AutomaticBreadcrumbs\Exception\UnresolvedException;
use Exception;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class BreadcrumbAttributeResolver implements ResolverInterface {

    /**
     * Resolve the breadcrumb attribute on the controller action.
     * @param string $_controller 
     * @return null|Breadcrumb 
     * @throws UnresolvedException 
     */
    public function resolve(string $_controller)
    { 
        [$controller, $action] = explode('::', $_controller);

        try {
            $reflection_controller = new \ReflectionClass($controller);
            $action = $reflection_controller->getMethod($action);
            $attributes = $action->getAttributes(Breadcrumb::class);
        } catch(Exception $e) {
            return null;
        }
        
        if(empty($attributes)) {
            throw new UnresolvedException(sprintf('Impossible to resolve %s nor does not have an attribute of class %s attached', $_controller, Breadcrumb::class));
        }

        return $attributes[0]->newInstance();
        
        
    }

}