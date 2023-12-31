<?php

namespace Jugid\AutomaticBreadcrumbs;

use Jugid\AutomaticBreadcrumbs\Collection\BreadcrumbsCollectionInterface;
use Jugid\AutomaticBreadcrumbs\Collection\DisableBreadcrumbsCollectionInterface;
use Jugid\AutomaticBreadcrumbs\Renderer\BreadcrumbsRendererInterface;
use Twig\Environment;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class Breadcrumbs
{
    private bool $automatic;
    private bool $detect_mode;

    public function __construct(
        private Environment $twig,
        private BreadcrumbsCollectionInterface|DisableBreadcrumbsCollectionInterface $collection,
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

    /**
     * @return BreadcrumbsCollectionInterface|DisableBreadcrumbsCollectionInterface 
     */
    public function getCollection() : BreadcrumbsCollectionInterface|DisableBreadcrumbsCollectionInterface {
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