<?php

namespace Jugid\AutomaticBreadcrumbs\Resolver;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
interface ResolverInterface {
    public function resolve(string $str);
}