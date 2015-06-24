<?php
/**
 * Prefetching Reader class.
 * 
 * This is a base 'wrapper' reader class that may contain multiple other readers which implement
 * `PrefetchInterface`. The intention is to merge the translations across all the readers into one
 * table (per lang code) and have a possibility to cache these tables.
 * 
 * This 'combined' reader is then to be attached to a Core object as a single reader.
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use ArrayAccess;

class PrefetchingReader extends ReaderBase
{
	/**
	 * @var  array  Attached readers instances.
	 */
	private $_readers = array();
	/**
	 * @var  array  Language keys that have been prefetched.
	 */
	private $_cache_keys = array();

	/**
	 * @param   array  $cache  Optional cache service that must implement ArrayAccess.
	 * @throws  InvalidArgumentException
	 */
	public function __construct($cache = array())
	{
		if ( ! is_array($cache) && ! ($cache instanceof ArrayAccess))
		{
			throw new \InvalidArgumentException('Argument 1 expected to be array or an object implementing ArrayAccess!');
		}
		$this->_cache = $cache;
	}

	/**
	 * Attach an i18n reader, same as you would to the Core object.
	 * 
	 * @param   ReaderInterface   $reader
	 * @return  $this
	 * @throws  \InvalidArgumentException
	 */
	public function attach(ReaderInterface $reader)
	{
		if ( ! $reader instanceof PrefetchInterface)
		{
			throw new \InvalidArgumentException('The reader '.get_class($reader).' must implement PrefetchInterface');
		}
		$this->_readers[] = $reader;
		$this->reset_translations();
		return $this;
	}

	/**
	 * @param   string  $string  Text to translate.
	 * @param   string  $lang    Target language.
	 * @return  string|array|NULL
	 */
	public function get($string, $lang = NULL)
	{
		// Make sure the translations are loaded.
		$this->load_to_cache($lang);

		// Look up the translation.
		return parent::get($string, $lang);
	}

	/**
	 * Collect all translations in the target language from all attached readers.
	 * 
	 * @param   string  $lang  Target language.
	 */
	protected function load_to_cache($lang)
	{
		// Convert lang code to lower case.
		$lang_key = strtolower($lang);

		if ( ! isset($this->_cache[$lang_key]))
		{
			$this->_cache_keys[] = $lang_key;
			$this->_cache[$lang_key] = $this->collect_translations($lang_key);
		}
	}

	/**
	 * Load all translations from all attached readers in the target language.
	 * 
	 * @param  string  $lang_key  Target language key (already lowercased).
	 */
	protected function collect_translations($lang_key)
	{
		// Create empty combined translations table for the language.
		$table = array();

		foreach ($this->_readers as $reader)
		{
			// Get translations from the reader.
			$translations = $reader->load_translations($lang_key);

			// Add translations from the reader into combined table.
			$table = $this->_array_merge($table, $translations);
		}

		return $table;
	}

	/**
	 * Reset loaded translations. This is used after a new reader is attached.
	 * 
	 * @param   string  $lang  Target language.
	 * @return  $this
	 */
	protected function reset_translations()
	{
		for ($i = count($this->_cache_keys) - 1; $i >= 0; $i--)
		{
			unset($this->_cache[$this->_cache_keys[$i]]);
			unset($this->_cache_keys[$i]);
		}
		return $this;
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
	private function _array_merge($array1, $array2)
	{
		if ($this->_is_assoc($array2))
		{
			foreach ($array2 as $key => $value)
			{
				if (is_array($value)
					AND isset($array1[$key])
					AND is_array($array1[$key])
				)
				{
					$array1[$key] = $this->_array_merge($array1[$key], $value);
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
	private function _is_assoc(array $array)
	{
		// Keys of the array
		$keys = array_keys($array);

		// If the array keys of the keys match the keys, then the array must
		// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
		return array_keys($keys) !== $keys;
	}
}
