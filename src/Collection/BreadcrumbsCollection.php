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
    protected array $breadcrumbs = ['default' => []];

    protected array $includes = [];

    public function __construct(
        protected UrlGeneratorInterface $urlGenerator
    ) {}

    /**
     * @inheritDoc
     */
    public function addBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): static {
        if(!$this->isIncluded($breadcrumb->getPath(), $namespace)) {
            return $this;
        }
        
        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }

        $this->breadcrumbs[$namespace][] = $breadcrumb;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function prependBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): static {
        if(!$this->isIncluded($breadcrumb->getPath(), $namespace)) {
            return $this;
        }

        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }

        array_unshift($this->breadcrumbs[$namespace], $breadcrumb);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addItem(string $text, string $url): static { 
        return $this->addItemNamespace('default', $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function addRouteItem(string $text, string $route, array $parameters = []): static {
        return $this->addRouteItemNamespace('default', $text, $route, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function addItemNamespace(string $namespace, string $text, string $url): static { 
        if(!$this->isIncluded($url, $namespace)) {
            return $this;
        }

        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }

        $this->breadcrumbs[$namespace][] = new UrlBreadcrumb($text, $url);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static {
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->addItemNamespace($namespace, $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function prependItem(string $text, string $url) : static {
        return $this->prependItemNamespace('default', $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function prependRouteItem(string $text, string $route, array $parameters = []): static {
        return $this->prependRouteItemNamespace('default', $text, $route, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function prependItemNamespace(string $namespace, string $text, string $url) : static {
        if(!$this->isIncluded($url, $namespace)) {
            return $this;
        }
        
        if(!$this->hasNamespace($namespace)) {
            $this->add($namespace);
        }
        
        array_unshift($this->breadcrumbs[$namespace], new UrlBreadcrumb($text, $url));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function prependRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static {
        $url = $this->urlGenerator->generate($route, $parameters);
        return $this->prependItemNamespace($namespace, $text, $url);
    }

    /**
     * @inheritDoc
     */
    public function add(string $namespace) : void {
        if(!$this->hasNamespace($namespace)) {
            $this->breadcrumbs[$namespace] = [];
        }
    }

    /**
     * @inheritDoc
     */
    public function clear(string $namespace = 'default'): bool { 
        if(!$this->hasNamespace($namespace)) {
            return true;
        }

        $this->breadcrumbs[$namespace] = [];
        return true;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function hasItem(string $text, string $namespace = 'default'): bool { 
        $namespace_items = $this->extract($namespace);

        foreach($namespace_items as $item) {
            if($item->getText() === $text) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function hasNamespace(string $namespace = 'default'): bool { 
        return isset($this->breadcrumbs[$namespace]);
    }

    /**
     * @inheritDoc
     */
    public function extract(string $namespace = 'default'): array { 
        if(!$this->hasNamespace($namespace)) {
            throw new LogicException(sprintf('Namespace \'%s\' does not exists', $namespace));
        }

        return $this->breadcrumbs[$namespace];
    }

    /**
     * @inheritDoc
     */
    public function setIncludes(array $includes) : void {
        $this->includes = $includes;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function isEmpty(string $namespace = 'default') : bool {
        return empty($this->breadcrumbs[$namespace]);
    }
    
}