<?php
/**
 * Kohana I18n Reader
 * 
 * Uses Kohana i18n files, the code is a modified version of `Kohana_I18n` class.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;

class Kohana extends FileBasedReader
{
	/**
	 * @var  string  Base i18n directory.
	 */
	private $_directory;

	/**
	 * @param  string  $directory
	 */
	public function __construct($directory = 'i18n')
	{
		$this->_directory = $directory;
	}

	/**
	 * @param   string  $string  Text to translate.
	 * @param   string  $lang    Target language.
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL)
	{
		if ($lang === NULL)
		{
			// Use Kohana language from `I18n` class if not specified.
			$lang = \I18n::lang();
		}
		return parent::get($string, $lang);
	}

	/**
	 * @param   string  $lang  Target language translations to load.
	 * @return  array
	 */
	public function load_translations($lang)
	{
		// Split the language: language, region, locale, etc.
		$parts = $this->split_lang($lang);

		// Create a path for this set of parts.
		$path = implode(DIRECTORY_SEPARATOR, $parts);

		// New translation table
		$table = array();

		$files = \Kohana::find_file($this->_directory, $path, NULL, TRUE);
		foreach ($files as $file)
		{
			// Merge the language strings into the sub table
			$table = \Arr::merge($table, \Kohana::load($file));
		}

		return $table;
	}
}