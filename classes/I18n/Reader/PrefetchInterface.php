<?php
/**
 * Prefetch Interface
 * 
 * Readers that are able to load all the translations may implement this interface in order to use
 * translations loading optimization and caching.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;

interface PrefetchInterface
{
	/**
	 * Load and return all translations in the target language. At the very least an empty array
	 * must be returned.
	 * 
	 * @param   string  $lang  Target language.
	 * @return  array
	 */
	public function load_translations($lang);
}
