<?php
namespace YBC;

if (version_compare(PHP_VERSION, '5.3', '<')) {
	throw new Exception('The YBC package needs PHP 5.3.0 or higher. If you are using PHP 5.2 please use the YBC_Legacy package.');
}
if (!ini_get('allow_url_fopen')) {
	throw new Exception('The YBC package relies on the allow_url_fopen setting. Please turn it on in php.ini or with ini_set(\'allow_url_fopen\', \'1\');');
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