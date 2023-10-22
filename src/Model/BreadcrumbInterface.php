<?php

namespace Jugid\AutomaticBreadcrumbs\Model;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface BreadcrumbInterface {
    public function getText() : string;
    public function getPath() : string;
}