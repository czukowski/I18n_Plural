<?php
/**
 * I18n Reader Cache Wrapper
 * 
 * This is a wrapper for the Nette cache service. Experimental!
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use ArrayAccess,
	Nette\Caching\Cache;

class NetteCacheWrapper implements ArrayAccess
{
	const DIRECTORIES = 'directories';
	/**
	 * @var  Cache  Nette cache service.
	 */
	private $_cache;
	/**
	 * @var  array  Wrapper options
	 */
	private $_options;

	/**
	 * @param  Cache  $cache    Nette cache service
	 * @param  array  $options  Wrapper options
	 */
	public function __construct(Cache $cache, array $options = array())
	{
		$this->_cache = $cache;
		$this->_set_options($options);
	}

	/**
	 * @param  array  $options
	 */
	private function _set_options($options)
	{
		$this->_options = $options;
		if (isset($options[self::DIRECTORIES]) && is_array($options[self::DIRECTORIES]))
		{
			foreach ($options[self::DIRECTORIES] as $path => $file_mask)
			{
				$this->add_directory_option($path, $file_mask);
			}
			unset($this->_options['directories']);
		}
	}

	/**
	 * @param  string  $path
	 * @param  string  $file_mask
	 */
	public function add_directory_option($path, $file_mask)
	{
		$found = $this->_find_files($path, $file_mask);
		if ($found)
		{
			if ( ! array_key_exists(Cache::FILES, $this->_options))
			{
				$this->_options[Cache::FILES] = array();
			}
			elseif ( ! is_array($this->_options[Cache::FILES]))
			{
				$this->_options[Cache::FILES] = array($this->_options[Cache::FILES]);
			}
			$this->_options[Cache::FILES] = array_merge($this->_options[Cache::FILES], $found);
		}
	}

	/**
	 * Based on:
	 * 
	 * @see  http://php.net/manual/en/function.glob.php#106595
	 * 
	 * @param   string   $directory
	 * @param   string   $filename_mask
	 * @param   integer  $flags
	 * @return  array
	 */
	private function _find_files($directory, $filename_mask, $flags = 0)
	{
		$files = glob($directory.'/'.$filename_mask, $flags);
		foreach ( (array) glob($directory.'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $subdirectory)
		{
			$files = array_merge($files, $this->_find_files($subdirectory, $filename_mask, $flags));
		}
		return $files;
	}

	/**
	 * @param   string  $key
	 * @return  boolean
	 */
	public function offsetExists($key)
	{
		return $this->_cache->load($key) !== NULL;
	}

	/**
	 * @param   string  $key
	 * @return  mixed
	 */
	public function offsetGet($key)
	{
		return $this->_cache->load($key);
	}

	/**
	 * @param  string  $key
	 * @param  mixed   $value
	 */
	public function offsetSet($key, $value)
	{
		$this->_cache->save($key, $value, $this->_options);
	}

	/**
	 * @param  string  $key
	 */
	public function offsetUnset($key)
	{
		$this->_cache->save($key, NULL);
	}
}
