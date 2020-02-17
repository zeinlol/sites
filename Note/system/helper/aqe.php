<?php
if (!defined('JSON_UNESCAPED_SLASHES')) {
    define('JSON_UNESCAPED_SLASHES', 0xFFFF);
}

/**
  * Use our custom json_encode function in case of older PHP versions
  *
  **/
if (!function_exists("json_enc")) {
    function json_enc($value, $options = 0, $depth = 512) {
        if (version_compare(phpversion(), '5.5.0') >= 0) {
            return json_encode($value, $options, $depth);
        } elseif (version_compare(phpversion(), '5.4.0') >= 0) {
            return json_encode($value, $options);
        } else {
            return json_encode($value);
        }
    }
}

/**
  * Sort columns by index key
  *
  **/
if (!function_exists('column_sort')) {
    function column_sort($a, $b) {
        if ($a['index'] == $b['index']) {
            return 0;
        }
        return ($a['index'] < $b['index']) ? -1 : 1;
    }
}


/**
  * Filter columns by display value
  *
  **/
if (!function_exists('column_display')) {
    function column_display($a) {
        return (isset($a['display'])) ? (int)$a['display'] : false;
    }
}
