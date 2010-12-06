<?php
function YBC_autoload($class)
{
	if (substr($class, 0, 4) === 'YBC_' && file_exists(dirname(__FILE__) . '/' . substr($class,4) . '.php')) {
		require dirname(__FILE__) . '/' . substr($class,4) . '.php';
	}
}
spl_autoload_register('YBC_autoload');