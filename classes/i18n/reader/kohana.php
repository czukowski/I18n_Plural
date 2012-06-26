<?php
/**
 * Kohana I18n Reader
 * 
 * Uses Kohana i18n files, the code is a slightly modified version of `Kohana_I18n` class.
 * 
 * @package    I18n_Reader
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
class I18n_Reader_Kohana implements I18n_Reader_Interface {

	private $cache = array();
	private $directory;

	/**
	 * @param  string  $directory
	 */
	public function __construct($directory = 'i18n')
	{
		$this->directory = $directory;
	}

	/**
	 * Returns the translation(s) of a string or NULL if there's no translation for the string.
	 * No parameters are replaced.
	 * 
	 * @param   string   text to translate
	 * @param   string   target language
	 * @return  mixed
	 */
	public function get($string, $lang = NULL)
	{
		if ( ! $lang)
		{
			// Use the global target language
			$lang = \I18n::$lang;
		}

		// Load the translation table for this language
		$table = $this->load($lang);

		// Return the translated string if it exists
		if (isset($table[$string]))
		{
			return $table[$string];
		}
		elseif (($translation = \Arr::path($table, $string)) !== NULL)
		{
			return $translation;
		}
		return NULL;
	}

	/**
	 * Loads the translation table for a given language.
	 * 
	 *     // Get all defined Spanish messages
	 *     $messages = I18n::load('es-es');
	 * 
	 * @param   string  language to load
	 * @return  array
	 */
	private function load($lang)
	{
		if (isset($this->cache[$lang]))
		{
			return $this->cache[$lang];
		}

		// New translation table
		$table = array();

		// Split the language: language, region, locale, etc
		$parts = explode('-', $lang);

		do
		{
			// Create a path for this set of parts
			$path = implode(DIRECTORY_SEPARATOR, $parts);
			$files = \Kohana::find_file($this->directory, $path, NULL, TRUE);
			if ($files)
			{
				$tables = array();
				foreach ($files as $file)
				{
					// Merge the language strings into the sub table
					$tables = \Arr::merge($tables, Kohana::load($file));
				}

				// Append the sub table, preventing less specific language
				// files from overloading more specific files
				$table += $tables;
			}

			// Remove the last part
			array_pop($parts);
		}
		while ($parts);

		// Cache the translation table locally
		return $this->cache[$lang] = $table;	
	}
}