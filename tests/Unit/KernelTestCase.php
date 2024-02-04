<?php

namespace Jugid\AutomaticBreadcrumbs\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelTestCase extends TestCase
{
    protected ContainerInterface $container;

    protected function setUpToSetup(): void
    {
        $kernel = new BundleTestingKernel('test', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }
}