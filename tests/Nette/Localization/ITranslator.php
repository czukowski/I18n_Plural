<?php
/**
 * Nette\Localization\ITranslator substitute for tests.
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace Nette\Localization;

// Only declare interface if used outside of Nette environment.
if (interface_exists('Nette\Localization\ITranslator')) {
	return;
}

/**
 * @author     David Grudl
 * @copyright  (c) 2004 David Grudl (http://davidgrudl.com) 
 */
interface ITranslator
{
	function translate($message, $count = NULL);
}
