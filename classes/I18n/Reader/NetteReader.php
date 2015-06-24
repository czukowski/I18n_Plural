<?php
/**
 * Nette Reader
 * 
 * This is actually the adaption of the Kohana reader for Nette application.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;

class NetteReader extends FileBasedReader
{
	private $default_lang;
	private $i18n_dir;
	protected $extension = 'php';

	/**
	 * @param  string  $i18n_dir      root directory to look for i18n files
	 * @param  string  $default_lang  default language to use when none specified
	 */
	public function __construct($i18n_dir, $default_lang = 'x')
	{
		$this->i18n_dir = $i18n_dir;
		$this->default_lang = $default_lang;
	}

	/**
	 * Returns the translation(s) of a string or NULL if there's no translation for the string.
	 * No parameters are replaced.
	 * 
	 * @param   string  $string  text to translate
	 * @param   string  $lang    target language
	 * @return  mixed
	 */
	public function get($string, $lang = NULL)
	{
		if ( ! $lang)
		{
			// Use the default language from nette config
			$lang = $this->default_lang;
		}
		return parent::get($string, $lang);
	}

	/**
	 * Loads the translation table for a given language.
	 * 
	 * @param   string  $lang  language to load
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

		// Possible translations file paths.
		$files = array(
			rtrim($this->i18n_dir, '/').'/'.$path.'.'.$this->extension,
		);
		foreach ($files as $file)
		{
			// Merge the language strings into the sub table
			$table = $this->array_merge($table, $this->load_file($file));
		}

		return $table;
	}

	/**
	 * Loads a file within an empty scope and returns the output.
	 * 
	 * @param   string  $file
	 * @return  mixed
	 */
	protected function load_file($file)
	{
		if (is_file($file))
		{
			return include $file;
		}
		return array();
	}

	/**
	 * Recursively merge two arrays. Values in an associative array
	 * overwrite previous values with the same key. Values in an indexed array
	 * are appended, but only when they do not already exist in the result.
	 * 
	 * Note that this does not work the same as [array_merge_recursive](http://php.net/array_merge_recursive)!
	 * 
	 * This array helper is based on Kohana Framework.
	 * 
	 * @author     Kohana Team
	 * @copyright  (c) 2007-2012 Kohana Team
	 * @license    http://kohanaframework.org/license
	 * 
	 * @param   array  $array1  initial array
	 * @param   array  $array2  array to merge
	 * @return  array
	 */
	private function array_merge($array1, $array2)
	{
		if ($this->is_assoc($array2))
		{
			foreach ($array2 as $key => $value)
			{
				if (is_array($value)
					AND isset($array1[$key])
					AND is_array($array1[$key])
				)
				{
					$array1[$key] = $this->array_merge($array1[$key], $value);
				}
				else
				{
					$array1[$key] = $value;
				}
			}
		}
		else
		{
			foreach ($array2 as $value)
			{
				if ( ! in_array($value, $array1, TRUE))
				{
					$array1[] = $value;
				}
			}
		}

		return $array1;
	}

	/**
	 * Tests if an array is associative or not.
	 * 
	 * This array helper is based on Kohana Framework.
	 * 
	 * @author     Kohana Team
	 * @copyright  (c) 2007-2012 Kohana Team
	 * @license    http://kohanaframework.org/license
	 * 
	 * @param   array   array to check
	 * @return  boolean
	 */
	private function is_assoc(array $array)
	{
		// Keys of the array
		$keys = array_keys($array);

		// If the array keys of the keys match the keys, then the array must
		// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
		return array_keys($keys) !== $keys;
	}
}