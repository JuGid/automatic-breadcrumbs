<?php

namespace Jugid\AutomaticBreadcrumbs\Strategy;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface StrategyInterface {
    public function decompose(string $path) : array;
}