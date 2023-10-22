<?php

namespace Jugid\AutomaticBreadcrumbs\Strategy;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface StrategyInterface {

    /**
     * Decompose the path to tests.
     * 
     * The returned array of paths will be tested by the subscriber to get the routes from
     * the symfony route collection. 
     * You should return the paths in the order you want to
     * print them. 
     * If the path exists from the router, the subscriber will add it to the breadcrumb collection
     * default namespace.
     * 
     * @param string $path 
     * @return array 
     */
    public function decompose(string $path) : array;
}