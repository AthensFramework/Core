<?php

namespace UWDOEM\Framework\Filter;


class FilterControls {

    static public function getControl($handle, $key, $default = null) {
        return array_key_exists("$handle-$key", $_GET) ? $_GET["$handle-$key"] : $default;
    }
}