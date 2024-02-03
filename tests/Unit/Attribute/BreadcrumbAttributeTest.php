<?php

namespace Jugid\AutomaticBreadcrumbs\Tests\Attribute;

use Jugid\AutomaticBreadcrumbs\Attribute\Breadcrumb;
use PHPUnit\Framework\TestCase;

class BreadcrumbAttributeTest extends TestCase 
{
    
    public function testShouldTestAttributeConstruction()
    {
        $this->expectNotToPerformAssertions();
        $breadcrumb = new Breadcrumb('Title');
        $breadcrumb = new Breadcrumb('Title', true);
        $breadcrumb = new Breadcrumb('Title', true, 'default');
    }

    public function testShouldGetTitle() {
        $breadcrumb = new Breadcrumb('Title');
        $this->assertEquals('Title', $breadcrumb->getTitle());
    }

    public function testShouldGetRoot() {
        $breadcrumb_false = new Breadcrumb('Title');
        $breadcrumb_true = new Breadcrumb('Title', true);
        $this->assertFalse($breadcrumb_false->isRoot());
        $this->assertTrue($breadcrumb_true->isRoot());
    }

    public function testShouldGetNamespace() {
        $breadcrumb_default = new Breadcrumb('Title');
        $breadcrumb_with_specific_namespace = new Breadcrumb('Title', false, 'my_namespace');
        $this->assertEquals('default', $breadcrumb_default->getNamespace());
        $this->assertEquals('my_namespace', $breadcrumb_with_specific_namespace->getNamespace());
    }
}