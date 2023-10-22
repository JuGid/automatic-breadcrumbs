<?php

namespace Jugid\AutomaticBreadcrumbs\Model;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface BreadcrumbInterface {
    /**
     * Returns the text representing the breadcrumb
     * @return string 
     */
    public function getText() : string;

    /**
     * Return the path (or url) of the breadcrumb to redirect the user
     * @return string 
     */
    public function getPath() : string;
}