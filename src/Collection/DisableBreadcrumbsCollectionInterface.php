<?php

namespace Jugid\AutomaticBreadcrumbs\Collection;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface DisableBreadcrumbsCollectionInterface extends BreadcrumbsCollectionInterface 
{
    /**
     * Add a BreadcrumbInterface object representing a future element to the default namespace.
     * @param string $text 
     * @param string $url 
     * @return static 
     */
    public function addDisableItem(string $text, string $url) : static;

    /**
     * Add a BreadcrumbInterface object representing a future element to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static 
     */
    public function addDisableRouteItem(string $text, string $route, array $parameters = []): static;

    /**
     * Add a BreadcrumbInterface object representing a future element to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return static 
     */
    public function addDisableItemNamespace(string $namespace, string $text, string $url) : static;

    /**
     * Add a BreadcrumbInterface object representing a future element to the specified namespace with the url generated
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static 
     */
    public function addDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the namespace
     * @param string $text 
     * @param string $url 
     * @return static 
     */
    public function prependDisableItem(string $text, string $url) : static;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static 
     */
    public function prependDisableRouteItem(string $text, string $route, array $parameters = []): static;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return static 
     */
    public function prependDisableItemNamespace(string $namespace, string $text, string $url) : static;

    /**
     * Prepend a BreadcrumbInterface object to the specified namespace with the url generated representing a future element
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return static 
     */
    public function prependDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): static;

}