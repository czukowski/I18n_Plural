<?php
/**
 * File Based Reader base class.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;

abstract class FileBasedReader extends ReaderBase implements PrefetchInterface
{
	/**
	 * Load, parse and return the associative array containing the translations for the specified
	 * language.
	 * 
	 * @param   string  $lang  Target language.
	 * @return  array
	 */
	abstract protected function load_translations($lang);

	/**
	 * This is a convenience function to split the lang code into parts: language, region, locale, etc.
	 * It's intended for the use in the `filename()` method to determine the translation file path.
	 * Note the difference from the Core's method with the same name.
	 * 
	 * @param   string  $lang
	 * @return  array
	 */
	protected function split_lang($lang)
	{
		return explode('-', strtolower($lang));
	}

	/**
	 * @param   string  $string  Text to translate.
	 * @param   string  $lang    Target language.
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL)
	{
		// Load the translations from file if not done yet.
		$this->prefetch($lang);

		return parent::get($string, $lang);
	}

	/**
	 * Load and return all translations in the target language. At the very least an empty array
	 * must be returned.
	 * 
	 * @param   string  $lang  Target language.
	 * @return  array
	 */
	public function prefetch($lang)
	{
		// Convert lang code to lower case.
		$lang_key = strtolower($lang);

		if ( ! isset($this->_cache[$lang_key]))
		{
			$this->_cache[$lang_key] = $this->load_translations($lang_key);
		}
		return $this->_cache[$lang_key];
	}
}
