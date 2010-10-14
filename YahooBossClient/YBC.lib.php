<?php
namespace YBC;

if (version_compare(PHP_VERSION, '5.3', '<')) {
	throw new Exception('The YBC package needs PHP 5.3.0 or higher. If you are using PHP 5.2 please use the YBC_Legacy package.');
}

/**
 * Autoload function
 */
function autoload($className) {
    $filename = dirname(__FILE__) . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
        return true;
    }
    return false;
}

spl_autoload_register('YBC\\autoload');