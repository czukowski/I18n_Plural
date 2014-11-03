<?php
// Initialize composer autoloader.
require_once __DIR__.'/../../vendor/autoload.php';

// Initialize own autoloader.
require_once __DIR__.'/loader.php';
spl_autoload_register(array(
	new I18n\Tests\Autoloader(array(__DIR__.'/../', __DIR__.'/../../classes/')),
	'load',
));

// Initialize helper classes.
require_once __DIR__.'/helpers.php';