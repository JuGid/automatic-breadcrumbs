<?php

namespace Jugid\AutomaticBreadcrumbs\Attribute;

use Attribute;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
#[Attribute(\Attribute::TARGET_METHOD)]
class Breadcrumb {

    public function __construct(
        public readonly string $title,
        public readonly bool $root = false,
        public readonly string $namespace = 'default'
    ) {}

    public function getTitle() : string 
    {
        return $this->title;
    }

    public function isRoot() : bool
    {
        return $this->root;
    }

    public function getNamespace() : string 
    {
        return $this->namespace;
    }

}