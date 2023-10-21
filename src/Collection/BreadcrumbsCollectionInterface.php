<?php

namespace Jugid\AutomaticBreadcrumbs\Collection;

use Jugid\AutomaticBreadcrumbs\Model\BreadcrumbInterface;

interface BreadcrumbsCollectionInterface {
    public function addBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): self;
    public function addItem(string $text, string $url) : self;
    public function addRouteItem(string $text, string $route, array $parameters = []): self;
    public function addItemNamespace(string $namespace, string $text, string $url) : self;
    public function addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
    public function prependItem(string $text, string $url) : self;
    public function prependRouteItem(string $text, string $route, array $parameters = []): self;
    public function prependItemNamespace(string $namespace, string $text, string $url) : self;
    public function prependRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
    public function add(string $namespace) : void;
    public function clear(string $namespace = 'default') : bool;
    public function removeItem(string $text, string $namespace = 'default') : bool;
    public function hasItem(string $text, string $namespace = 'default') : bool;
    public function hasNamespace(string $namespace = 'default') : bool;
    public function extract(string $namespace = 'default') : array;
    public function setIncludes(array $includes) : void;
    public function isIncluded(string $route) : bool;
    public function isEmpty(string $namespace = 'default') : bool;
}