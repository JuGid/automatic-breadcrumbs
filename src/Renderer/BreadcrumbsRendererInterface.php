<?php

namespace Jugid\AutomaticBreadcrumbs\Renderer;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface BreadcrumbsRendererInterface {
    public function render(array $breadcrumb_collection, array $options) : string;
    public function processOptions(array $options) : void;
    public function setSeparator(string $separator) : void;
    public function setTemplate(string $template) : void;
}