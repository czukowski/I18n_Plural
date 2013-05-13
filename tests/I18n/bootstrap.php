<?php
// Load Kohana bootstrap
require __DIR__.'/kohana.php';

// Initialize our own autoloader
require_once DOCROOT.'loader'.EXT;
spl_autoload_register(array(
	new I18n\Tests\Autoloader(array(DOCROOT.'../')),
	'load',
));

// Initialize helper classes
require_once DOCROOT.'helpers'.EXT;