<?php

namespace Jugid\AutomaticBreadcrumbs\Model;

interface BreadcrumbInterface {
    public function getText() : string;
    public function getPath() : string;
}