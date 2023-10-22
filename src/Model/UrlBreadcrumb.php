<?php

namespace Jugid\AutomaticBreadcrumbs\Model;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class UrlBreadcrumb implements BreadcrumbInterface {

    public function __construct(
        private string $text,
        private string $path
    ) {}

    /**
     * @inheritDoc
     */
    public function getText(): string { 
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string { 
        return $this->path;
    }
    
}