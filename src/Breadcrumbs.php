<?php

namespace Jugid\AutomaticBreadcrumbs;

use Jugid\AutomaticBreadcrumbs\Collection\BreadcrumbsCollectionInterface;
use Jugid\AutomaticBreadcrumbs\Renderer\BreadcrumbsRendererInterface;
use Twig\Environment;

class Breadcrumbs
{
    private bool $automatic;
    private bool $detect_mode;

    public function __construct(
        private Environment $twig,
        private BreadcrumbsCollectionInterface $collection,
        private BreadcrumbsRendererInterface $renderer
    ) {}

    /**
     * Alias of $this::getCollection::extract
     * @param string $namespace 
     * @return array 
     */
    public function extract(string $namespace = 'default') : array 
    {
        return $this->getCollection()->extract($namespace);
    }

    /**
     * Alias of $this::getRenderer::render
     * @param array $breadcrumb_collection 
     * @return string 
     */
    public function render(array $breadcrumb_collection, array $options = []) : string
    {
        return $this->getRenderer()->render($breadcrumb_collection, $options);
    }

    public function getCollection() : BreadcrumbsCollectionInterface {
        return $this->collection;
    }

    public function getRenderer() : BreadcrumbsRendererInterface {
        return $this->renderer;
    }

    public function setAutomatic(bool $automatic) {
        $this->automatic = $automatic;
    }

    public function isAutomatic() : bool {
        return $this->automatic;
    }

    public function setDetectMode(bool $detect_mode) {
        $this->detect_mode = $detect_mode;
    }

    public function isDetectMode() : bool {
        return $this->detect_mode;
    }

}