<?php
/**
 * I18n Reader Interface
 * 
 * Any Reader must be able to return an associative array, if more than one translation option is available.
 * The 'other' key has a special meaning of a default translation.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;

interface ReaderInterface
{
	/**
	 * Returns the translation(s) of a string or NULL if there's no translation for the string.
	 * No parameters are replaced. If NULL is passed as `$lang` to the `get` method, it is up to
	 * the implementation whether to use some default language, or not doing the translation at all.
	 * 
	 * @param   string  $string  Text to translate.
	 * @param   string  $lang    Target language.
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL);
}