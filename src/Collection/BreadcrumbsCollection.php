<?php

namespace Jugid\AutomaticBreadcrumbs\Collection;

use Jugid\AutomaticBreadcrumbs\Model\BreadcrumbInterface;
use Jugid\AutomaticBreadcrumbs\Model\UrlBreadcrumb;
use LogicException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class BreadcrumbsCollection implements BreadcrumbsCollectionInterface 
{
    private array $breadcrumbs = ['default' => []];

    private array $includes = [];

    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {}

    public function addBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): BreadcrumbsCollectionInterface {
        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }

        $this->breadcrumbs[$namespace][] = $breadcrumb;

        return $this;
    }

    public function addItem(string $text, string $url): BreadcrumbsCollectionInterface { 
        return $this->addItemNamespace('default', $text, $url);
    }

    public function addRouteItem(string $text, string $route, array $parameters = []): BreadcrumbsCollectionInterface {
        return $this->addRouteItemNamespace('default', $text, $route, $parameters);
    }

    public function addItemNamespace(string $namespace, string $text, string $url): BreadcrumbsCollectionInterface { 
        if(!$this->isIncluded($url, $namespace)) {
            return $this;
        }

        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }

        $this->breadcrumbs[$namespace][] = new UrlBreadcrumb($text, $url);

        return $this;
    }

    public function addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): BreadcrumbsCollectionInterface {
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->addItemNamespace($namespace, $text, $url);
    }

    public function prependItem(string $text, string $url) : BreadcrumbsCollectionInterface {
        return $this->prependItemNamespace('default', $text, $url);
    }

    public function prependRouteItem(string $text, string $route, array $parameters = []): BreadcrumbsCollectionInterface {
        return $this->prependRouteItemNamespace('default', $text, $route, $parameters);
    }

    public function prependItemNamespace(string $namespace, string $text, string $url) : BreadcrumbsCollectionInterface {
        if(!$this->isIncluded($url, $namespace)) {
            return $this;
        }
        
        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }
        
        array_unshift($this->breadcrumbs[$namespace], new UrlBreadcrumb($text, $url));

        return $this;
    }

    public function prependRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): BreadcrumbsCollectionInterface {
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->prependItemNamespace($namespace, $text, $url);
    }

    public function add(string $namespace) : void {
        if(!$this->hasNamespace($namespace)) {
            $this->breadcrumbs[$namespace] = [];
        }
    }

    public function clear(string $namespace = 'default'): bool { 
        if(!$this->hasNamespace($namespace)) {
            return true;
        }

        $this->breadcrumbs[$namespace] = [];
        return true;
    }

    public function removeItem(string $text, string $namespace = 'default'): bool { 
        if(!$this->hasItem($text, $namespace)) {
            return false;
        }

        $namespace_items = $this->extract($namespace);

        foreach($namespace_items as $key => $item) {
            if($item->getText() === $text) {
                unset($this->breadcrumbs[$namespace][$key]);
                return true;
            }
        }

        return false;
    }

    public function hasItem(string $text, string $namespace = 'default'): bool { 
        $namespace_items = $this->extract($namespace);

        foreach($namespace_items as $item) {
            if($item->getText() === $text) {
                return true;
            }
        }

        return false;
    }

    public function hasNamespace(string $namespace = 'default'): bool { 
        return isset($this->breadcrumbs[$namespace]);
    }

    public function extract(string $namespace = 'default'): array { 
        if(!$this->hasNamespace($namespace)) {
            throw new LogicException(sprintf('Namespace \'%s\' does not exists', $namespace));
        }

        return $this->breadcrumbs[$namespace];
    }

    public function setIncludes(array $includes) : void {
        $this->includes = $includes;
    }

    public function isIncluded(string $url, string $namespace = 'default') : bool {

        if(empty($this->includes)) {
            return true;
        }
        
        foreach($this->includes as $include) {
            $include_tmp = $include;
            $exclude_same = false;

            if(substr($include_tmp, 0, 1) === '!') {
                $include_tmp = str_replace('!', '', $include_tmp);
                $exclude_same = true;
            }

            $route_length = strlen($url);
            $include_length = strlen($include_tmp);

            if($route_length < $include_length) {
                continue;
            }

            if(($url === $include_tmp || $url === ($include_tmp.'/')) && $exclude_same && count($this->breadcrumbs[$namespace]) === 0) {
                continue;
            }

            if(substr($url, 0, $include_length) === $include_tmp) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty(string $namespace = 'default') : bool {
        return empty($this->breadcrumbs[$namespace]);
    }
    
}