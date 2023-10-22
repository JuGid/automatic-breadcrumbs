<?php

namespace Jugid\AutomaticBreadcrumbs\Renderer;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface BreadcrumbsRendererInterface {
    /**
     * Uses twig to render the breadcrumbs collection thanks to the view
     * @param array $breadcrumb_collection 
     * @param array $options 
     * @return string 
     */
    public function render(array $breadcrumb_collection, array $options) : string;

    /**
     * Process the options passed in paramaters
     * @param array $options 
     * @return void 
     */
    public function processOptions(array $options) : void;

    /**
     * Set the separator to use while rendering the breadcrumbs collection
     * @param string $separator 
     * @return void 
     */
    public function setSeparator(string $separator) : void;

    /**
     * Set the template to use to render the breadcrumbs collection
     * @param string $template 
     * @return void 
     */
    public function setTemplate(string $template) : void;
}