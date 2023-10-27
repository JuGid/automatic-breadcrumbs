<?php

namespace Jugid\AutomaticBreadcrumbs\Collection;

use Jugid\AutomaticBreadcrumbs\Model\UrlBreadcrumb;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class DisableBreadcrumbsCollection extends BreadcrumbsCollection implements DisableBreadcrumbsCollectionInterface
{
    /**
     * @inheritDoc
     */
    public function addDisableItem(string $text, string $url): self { 
        return $this->addDisableItemNamespace('default', $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function addDisableRouteItem(string $text, string $route, array $parameters = []): self { 
        return $this->addDisableRouteItemNamespace('default', $text, $route, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function addDisableItemNamespace(string $namespace, string $text, string $url): self { 
        return $this->addBreadcrumb(new UrlBreadcrumb($text, $url, true), $namespace);
    }

    /**
     * @inheritDoc
     */
    public function addDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self { 
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->addDisableItemNamespace($namespace, $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function prependDisableItem(string $text, string $url): self { 
        return $this->prependDisableItemNamespace('default', $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function prependDisableRouteItem(string $text, string $route, array $parameters = []): self {
        return $this->prependDisableRouteItemNamespace('default', $text, $route, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function prependDisableItemNamespace(string $namespace, string $text, string $url): self { 
        return $this->prependBreadcrumb(new UrlBreadcrumb($text, $url, true), $namespace);
    }

    /**
     * @inheritDoc
     */
    public function prependDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self { 
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->prependDisableItemNamespace($namespace, $text, $url);
    }
    
}