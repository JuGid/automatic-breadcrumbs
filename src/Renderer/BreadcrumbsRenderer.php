<?php

namespace Jugid\AutomaticBreadcrumbs\Renderer;

use Twig\Environment;

class BreadcrumbsRenderer implements BreadcrumbsRendererInterface {

    private string $template;
    private string $separator;

    public function __construct(
        private Environment $twig
    ) {}

    public function setSeparator(string $separator): void { 
        $this->separator = $separator;
    }

    public function setTemplate(string $template): void { 
        $this->template = $template;
    }

    public function render(array $breadcrumb_collection, array $options) : string { 
        $this->processOptions($options);
        
        return $this->twig->render(
            $this->template, 
            [
                'breadcrumb_collection' => $breadcrumb_collection, 
                'separator' => $this->separator
            ]
        );
    }

    public function processOptions(array $options): void { 
        if(isset($options['separator'])) {
            $this->separator = $options['separator'];
        }

        if(isset($options['template'])) {
            $this->template = $options['template'];
        }
    }

}