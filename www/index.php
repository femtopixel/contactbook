<?php
define('ROOT_DIR', realpath(dirname(__FILE__)).'/../');
define('ENVIRONMENT', 'prod');

set_include_path ( ROOT_DIR . '/library' 
				. PATH_SEPARATOR . get_include_path () );
require_once('Zend/Loader/Autoloader.php');
$loader = Zend_Loader_Autoloader::getInstance()
			->registerNamespace('Annuaire_')
			->registerNamespace('Gears_');

// Create application, bootstrap, and run
$application = new Zend_Application(
    ENVIRONMENT, 
    ROOT_DIR . '/application/application.ini'
);

$application->bootstrap()
            ->run();
