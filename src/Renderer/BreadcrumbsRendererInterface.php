<?php

namespace Jugid\AutomaticBreadcrumbs\Renderer;

interface BreadcrumbsRendererInterface {
    public function render(array $breadcrumb_collection, array $options) : string;
    public function processOptions(array $options) : void;
    public function setSeparator(string $separator) : void;
    public function setTemplate(string $template) : void;
}