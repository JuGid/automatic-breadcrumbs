<?php

namespace Jugid\AutomaticBreadcrumbs\Tests\Strategy;

use Jugid\AutomaticBreadcrumbs\Strategy\HierarchyStrategy;
use PHPUnit\Framework\TestCase;

class HierarchyStrategyTest extends TestCase {

    public function testShouldConstruct() : void 
    {
        $this->expectNotToPerformAssertions();

        $strategy = new HierarchyStrategy();
    }

    /**
     * @dataProvider pathExpectedProvider
     */
    public function testShouldDecomposeWithHierarchyStrategy(string $path, array $expected) : void 
    {
        $strategy = new HierarchyStrategy();
        $this->assertEquals($expected, $strategy->decompose($path));
    }

    public static function pathExpectedProvider() : \Generator
    {
        yield ['path/to/page/', ['/path/to/page', '/path/to', '/path']];
        yield ['path/to/page', ['/path/to/page', '/path/to', '/path']];
        yield ['/path/to/page', ['/path/to/page', '/path/to', '/path', '/']];
        yield ['path/', ['/path']];
        yield ['/path/', ['/path', '/']];
        yield ['/path', ['/path', '/']];
        yield ['/', ['/']];
    }
}