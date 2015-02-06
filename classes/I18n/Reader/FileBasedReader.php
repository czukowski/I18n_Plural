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

abstract class FileBasedReader implements ReaderInterface
{
	/**
	 * @var  array  This property contains loaded translation tables.
	 */
	private $_cache = array();

	/**
	 * Return filename to load for the translations in the specified language.
	 * 
	 * @param   string  $lang
	 * @return  string
	 */
	abstract protected function filename($lang);

	/**
	 * Load, parse and return the associative array containing the translations in the specified file.
	 * 
	 * @param   string  $filename  Path to the translations file to load.
	 * @return  array
	 */
	abstract protected function load_file($filename);

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
		if ( ! isset($this->_cache[$lang]))
		{
			$filename = $this->filename($lang);
			$this->_cache[$lang] = $this->load_file($filename);
		}

		// Return the translated string if it exists.
		if (isset($this->_cache[$lang][$string]))
		{
			return $this->_cache[$lang][$string];
		}
		elseif (($translation = $this->_array_path($this->_cache[$lang], $string)) !== NULL)
		{
			return $translation;
		}
		// If no translation found, return NULL to give a chance to other Readers.
		return NULL;
	}

	/**
	 * Gets a value from an array using a dot separated path.
	 * 
	 * This array helper is based on Kohana Framework.
	 * 
	 * @author     Kohana Team
	 * @copyright  (c) 2007-2012 Kohana Team
	 * @license    http://kohanaframework.org/license
	 * 
	 * @param   array   $array  Array to search
	 * @param   mixed   $path   Key path string (delimiter separated) or array of keys
	 * @return  mixed
	 */
	private function _array_path($array, $path)
	{
		if ( ! $this->_is_array($array))
		{
			// This is not an array!
			return NULL;
		}

		if (is_array($path))
		{
			// The path has already been separated into keys
			$keys = $path;
		}
		else
		{
			if (array_key_exists($path, $array))
			{
				// No need to do extra processing
				return $array[$path];
			}

			$delimiter = '.';

			// Remove starting delimiters and spaces
			$path = ltrim($path, "{$delimiter} ");

			// Remove ending delimiters, spaces, and wildcards
			$path = rtrim($path, "{$delimiter} *");

			// Split the keys by delimiter
			$keys = explode($delimiter, $path);
		}

		do
		{
			$key = array_shift($keys);

			if (ctype_digit($key))
			{
				// Make the key an integer
				$key = (int) $key;
			}

			if (isset($array[$key]))
			{
				if ($keys)
				{
					if ($this->_is_array($array[$key]))
					{
						// Dig down into the next part of the path
						$array = $array[$key];
					}
					else
					{
						// Unable to dig deeper
						break;
					}
				}
				else
				{
					// Found the path requested
					return $array[$key];
				}
			}
			else
			{
				// Unable to dig deeper
				break;
			}
		}
		while ($keys);

		// Unable to find the value requested
		return NULL;
	}

	/**
	 * Test if a value is an array with an additional check for array-like objects.
	 * 
	 * This array helper is based on Kohana Framework.
	 * 
	 * @author     Kohana Team
	 * @copyright  (c) 2007-2012 Kohana Team
	 * @license    http://kohanaframework.org/license
	 * 
	 * @param   mixed   $value  Value to check
	 * @return  boolean
	 */
	private function _is_array($value)
	{
		if (is_array($value))
		{
			// Definitely an array
			return TRUE;
		}
		else
		{
			// Possibly a Traversable object, functionally the same as an array
			return (is_object($value) AND $value instanceof Traversable);
		}
	}
}
