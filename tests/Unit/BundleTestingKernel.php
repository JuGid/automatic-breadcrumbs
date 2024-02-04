<?php

namespace Jugid\AutomaticBreadcrumbs\Tests\Unit;

use Jugid\AutomaticBreadcrumbs\AutomaticBreadcrumbsBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class BundleTestingKernel extends Kernel
{

    public function registerBundles(): iterable { 
        return [
            new AutomaticBreadcrumbsBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader) : void 
    { 
        
    }
    
}