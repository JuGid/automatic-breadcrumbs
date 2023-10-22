<?php

namespace Jugid\AutomaticBreadcrumbs\Strategy;

/**
 * @author Julien Gidel <gidjulien@gmail.com>
 */
class HierarchyStrategy implements StrategyInterface {

    public function decompose(string $path) : array
    {
        $exploded_path = explode('/', $path);
        $clean_path = $this->cleanPathArray($exploded_path);
        $hierarchical_uri = [];

        foreach($clean_path as $key=>$element) {
            $uri = '';

            for($i=0; $i <= $key; $i++){
                $uri.= '/' . $clean_path[$i];
            }

            $uri = str_replace('//', '/', $uri);
            array_unshift($hierarchical_uri, $uri);
        }

        return $hierarchical_uri;
    }

    private function cleanPathArray(array $path_array) : array 
    {
        if(empty($path_array[array_key_last($path_array)])) {
            unset($path_array[array_key_last($path_array)]);
        }

        return $path_array;
    }

}