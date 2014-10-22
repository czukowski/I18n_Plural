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

class NetteReader implements ReaderInterface
{
	private $cache = array();
	private $default_lang;
	private $i18n_dir;

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

		// Load the translation table for this language
		$table = $this->load($lang);

		// Return the translated string if it exists
		if (isset($table[$string]))
		{
			return $table[$string];
		}
		elseif (($translation = $this->array_path($table, $string)) !== NULL)
		{
			return $translation;
		}
		return NULL;
	}

	/**
	 * Loads the translation table for a given language.
	 * 
	 * @param   string  $lang  language to load
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
		$parts = explode('-', strtolower($lang));

		do
		{
			// Create a path for this set of parts
			$path = implode(DIRECTORY_SEPARATOR, $parts);
			$files = array(
				rtrim($this->i18n_dir, '/').'/'.$path.'.php',
			);
			if ($files)
			{
				$tables = array();
				foreach ($files as $file)
				{
					// Merge the language strings into the sub table
					$tables = $this->array_merge($tables, $this->load_file($file));
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
	 * Gets a value from an array using a dot separated path.
	 * 
	 * This array helper is based on Kohana Framework.
	 * 
	 * @author     Kohana Team
	 * @copyright  (c) 2007-2012 Kohana Team
	 * @license    http://kohanaframework.org/license
	 * 
	 * @param   array   $array  array to search
	 * @param   mixed   $path   key path string (delimiter separated) or array of keys
	 * @return  mixed
	 */
	private function array_path($array, $path)
	{
		if ( ! $this->is_array($array))
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
					if ($this->is_array($array[$key]))
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
	 * @param   mixed   $value  value to check
	 * @return  boolean
	 */
	private function is_array($value)
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
}