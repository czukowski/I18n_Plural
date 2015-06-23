<?php
/**
 * Nette\Caching\Cache substitute for tests as interface.
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace Nette\Caching;

// Only declare interface if used outside of Nette environment.
if (interface_exists('Nette\Caching\Cache')) {
	return;
}

/**
 * @author     David Grudl
 * @copyright  (c) 2004 David Grudl (http://davidgrudl.com) 
 */
interface Cache
{
	const FILES = 'files';

	function load($key);
	function save($key, $value);
}
