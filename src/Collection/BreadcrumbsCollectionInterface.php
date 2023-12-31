<?php

namespace Jugid\AutomaticBreadcrumbs\Collection;

use Jugid\AutomaticBreadcrumbs\Model\BreadcrumbInterface;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface BreadcrumbsCollectionInterface {
    /**
     * Add(append) a BreadcrumbInterface object to the namespace
     * @param BreadcrumbInterface $breadcrumb 
     * @param string $namespace 
     * @return static
     */
    public function addBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): static;

    /**
     * Prepend a BreadcrumbInterface object to the namespace
     * @param BreadcrumbInterface $breadcrumb 
     * @param string $namespace 
     * @return static
     */
    public function prependBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): static;

    /**
     * Add(append) a BreadcrumbInterface object to the default namespace.
     * @param string $text 
     * @param string $url 
     * @return static
     */
    public function addItem(string $text, string $url) : static;

    /**
     * Add(append) a BreadcrumbInterface object to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static
     */
    public function addRouteItem(string $text, string $route, array $parameters = []): static;

    /**
     * Add(append) a BreadcrumbInterface object to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return static
     */
    public function addItemNamespace(string $namespace, string $text, string $url) : static;

    /**
     * Add(append) a BreadcrumbInterface object to the specified namespace with the url generated
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static
     */
    public function addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static;

    /**
     * Prepend a BreadcrumbInterface object to the namespace
     * @param string $text 
     * @param string $url 
     * @return static
     */
    public function prependItem(string $text, string $url) : static;

    /**
     * Prepend a BreadcrumbInterface object to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static
     */
    public function prependRouteItem(string $text, string $route, array $parameters = []): static;

    /**
     * Prepend a BreadcrumbInterface object to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return static
     */
    public function prependItemNamespace(string $namespace, string $text, string $url) : static;

    /**
     * Prepend a BreadcrumbInterface object to the specified namespace with the url generated
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static
     */
    public function prependRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static;

    /**
     * Add(append) a specified namespace
     * @param string $namespace 
     * @return void 
     */
    public function add(string $namespace) : void;

    /**
     * Clear the values in the specified namespace
     * @param string $namespace 
     * @return bool 
     */
    public function clear(string $namespace = 'default') : bool;

    /**
     * Remove an item from its text in the specified namespace
     * @param string $text 
     * @param string $namespace 
     * @return bool 
     */
    public function removeItem(string $text, string $namespace = 'default') : bool;

    /**
     * Returns the existence of an item from its text in the specified namespace
     * @param string $text 
     * @param string $namespace 
     * @return bool 
     */
    public function hasItem(string $text, string $namespace = 'default') : bool;

    /**
     * Returns the existence of a namespace
     * @param string $namespace 
     * @return bool 
     */
    public function hasNamespace(string $namespace = 'default') : bool;

    /**
     * Extract the values from the specified namespace
     * @param string $namespace 
     * @return array 
     */
    public function extract(string $namespace = 'default') : array;

    /**
     * Set the values whose can be accepted in this collection
     * @param array $includes 
     * @return void 
     */
    public function setIncludes(array $includes) : void;

    /**
     * Return if the path is included in this collection
     * @param string $path 
     * @return bool 
     */
    public function isIncluded(string $path) : bool;

    /**
     * Returns if the namespace is empty
     * @param string $namespace 
     * @return bool 
     */
    public function isEmpty(string $namespace = 'default') : bool;
}