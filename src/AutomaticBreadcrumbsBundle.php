<?php

namespace Jugid\AutomaticBreadcrumbs;

use Jugid\AutomaticBreadcrumbs\DependencyInjection\AutomaticBreadcrumbsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class AutomaticBreadcrumbsBundle extends Bundle 
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new AutomaticBreadcrumbsExtension();
        }

        return $this->extension;
    }
}