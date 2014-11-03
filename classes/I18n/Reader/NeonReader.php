<?php
/**
 * Neon Reader
 * 
 * Reads translations from the parsed neon files.
 * For more about neon see http://ne-on.org/
 * 
 * @package    I18n
 * @category   Readers
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use Nette\Neon\Neon;

class NeonReader extends NetteReader
{
	protected $extension = 'neon';

	/**
	 * Loads and parse neon file.
	 * 
	 * @param   string  $file
	 * @return  mixed
	 */
	protected function load_file($file)
	{
		if (is_file($file))
		{
			return $this->decode(file_get_contents($file));
		}
		return array();
	}

	/**
	 * Parse neon file cotent.
	 * 
	 * @param   string  $neon
	 * @return  mixed
	 */
	protected function decode($neon)
	{
		return Neon::decode($neon);
	}
}
