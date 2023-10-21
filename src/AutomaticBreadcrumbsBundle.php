<?php

namespace Jugid\AutomaticBreadcrumbs;

use Jugid\AutomaticBreadcrumbs\DependencyInjection\AutomaticBreadcrumbsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AutomaticBreadcrumbsBundle extends Bundle {

    /*
     * Personnaliser le séparateur de chaque jugid_automatic_render()
     */

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new AutomaticBreadcrumbsExtension();
        }

        return $this->extension;
    }
}