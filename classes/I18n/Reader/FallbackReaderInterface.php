<?php
/**
 * I18n Fallback Reader Interface
 * 
 * The difference from `ReaderInterface` is that this interface requires the reader to accept multiple
 * target languages and try the each language in the array until the translation is found. If translation
 * is not found in any language it must return NULL, same as `ReaderInterface`.
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

interface FallbackReaderInterface
{
	/**
	 * Returns the translation(s) of a string or NULL if there's no translation for the string.
	 * No parameters are replaced.
	 * 
	 * @param   string         text to translate
	 * @param   string|array   target language or languages
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL);
}
