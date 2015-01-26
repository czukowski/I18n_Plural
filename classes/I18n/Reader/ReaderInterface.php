<?php
/**
 * I18n Reader Interface
 * 
 * If NULL is passed to the `get` method, it is up to implementation, whether to use some default language
 * or not doing the translation at all.
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
	 * No parameters are replaced.
	 * 
	 * @param   string   text to translate
	 * @param   string   target language
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL);
}