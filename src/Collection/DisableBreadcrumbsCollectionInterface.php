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
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function addDisableItem(string $text, string $url) : self;

    /**
     * Add a BreadcrumbInterface object representing a future element to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function addDisableRouteItem(string $text, string $route, array $parameters = []): self;

    /**
     * Add a BreadcrumbInterface object representing a future element to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function addDisableItemNamespace(string $namespace, string $text, string $url) : self;

    /**
     * Add a BreadcrumbInterface object representing a future element to the specified namespace with the url generated
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function addDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the namespace
     * @param string $text 
     * @param string $url 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function prependDisableItem(string $text, string $url) : self;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the default namespace with the url generated
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function prependDisableRouteItem(string $text, string $route, array $parameters = []): self;

    /**
     * Prepend a BreadcrumbInterface object representing a future element to the specfied namespace
     * @param string $namespace 
     * @param string $text 
     * @param string $url 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function prependDisableItemNamespace(string $namespace, string $text, string $url) : self;

    /**
     * Prepend a BreadcrumbInterface object to the specified namespace with the url generated representing a future element
     * @param string $namespace 
     * @param string $text 
     * @param string $route 
     * @param array $parameters 
     * @return DisableBreadcrumbsCollectionInterface 
     */
    public function prependDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;

}