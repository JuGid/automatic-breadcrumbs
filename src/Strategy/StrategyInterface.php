<?php

namespace Jugid\AutomaticBreadcrumbs\Strategy;

interface StrategyInterface {
    public function decompose(string $path) : array;
}