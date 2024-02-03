<?php

namespace Jugid\AutomaticBreadcrumbs\Tests\Model;

use Jugid\AutomaticBreadcrumbs\Model\UrlBreadcrumb;
use PHPUnit\Framework\TestCase;

class UrlBreadcrumbTest extends TestCase 
{
    
    public function testShouldTestBreadcrumbsModel() : void
    {
        $breadcrumb = new UrlBreadcrumb('My breadcrumb', '/my/breadcrumb/path');

        $this->assertEquals('My breadcrumb', $breadcrumb->getText());
        $this->assertEquals('/my/breadcrumb/path', $breadcrumb->getPath());
    }
}