<?php

namespace Jugid\AutomaticBreadcrumbs\Model;

class UrlBreadcrumb implements BreadcrumbInterface {

    public function __construct(
        private string $text,
        private string $path
    ) {}

    public function getText(): string { 
        return $this->text;
    }

    public function getPath(): string { 
        return $this->path;
    }
    
}