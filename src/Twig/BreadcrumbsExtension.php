<?php

namespace Jugid\AutomaticBreadcrumbs\Twig;

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

class BreadcrumbsExtension extends AbstractExtension {
    public function __construct(
        private Breadcrumbs $breadcrumbs
    ) {}

    public function getFunctions() : array
    {
        return [
            new TwigFunction('jugid_breadcrumbs_render', [$this, 'render']),
        ];
    }

    public function render(string $namespace = 'default', array $options = [])
    {
        $collection = $this->breadcrumbs->extract($namespace);
        return new Markup($this->breadcrumbs->render($collection, $options), 'UTF-8');
    }
}