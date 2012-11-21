<?php
// Initialize paths
define('EXT', '.php');
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);
define('APPPATH', realpath(DOCROOT.'application').DIRECTORY_SEPARATOR);
define('MODPATH', realpath(DOCROOT.'../../../../modules').DIRECTORY_SEPARATOR);
define('SYSPATH', realpath(DOCROOT.'../../../../system').DIRECTORY_SEPARATOR);

// Load some core Kohana classes
require SYSPATH.'classes/Kohana/Core'.EXT;
require SYSPATH.'classes/Kohana/I18n'.EXT;
require SYSPATH.'classes/Kohana'.EXT;

// Bootstrap the application
spl_autoload_register(array('Kohana', 'auto_load'));
ini_set('unserialize_callback_func', 'spl_autoload_call');

// Initialize Kohana
Kohana::init(array(
	'base_url' => '/',
	'index_file' => FALSE,
	'caching' => FALSE,
	'cache_dir' => __DIR__,
	'errors' => FALSE,
));

// Initialize the config and modules
Kohana::$config->attach(new Kohana_Config_File);
Kohana::modules(array(
	'plurals' => MODPATH.'plurals',
	'unittest' => MODPATH.'unittest',
));