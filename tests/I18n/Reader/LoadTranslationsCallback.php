<?php
/**
 * Class helper for readers tests where `load_translations` method needs to be mocked.
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use I18n;

class LoadTranslationsCallback
{
	/**
	 * @var  integer
	 */
	public $load_file_counter;
	/**
	 * @var  object
	 */
	public $object;
	/**
	 * @var  array
	 */
	public $translations;
	/**
	 * @var  \ReflectionProperty
	 */
	private $reader_cache_property;

	/**
	 * 
	 * @param  I18n\Testcase  $testcase
	 * @param  array          $translations
	 */
	public function __construct(I18n\Testcase $testcase, $translations, $method_name = 'load_translations')
	{
		$this->translations = $translations;
		$this->load_file_counter = 0;
		$this->object = $testcase->getMock($testcase->class_name(), array($method_name));
		$this->object->expects($testcase->any())
			->method($method_name)
			->will($testcase->returnCallback(array($this, 'callback_load_translations')));
	}

	/**
	 * @param   string   $lang
	 * @return  string|array
	 */
	public function callback_load_translations($lang)
	{
		$this->load_file_counter++;
		$code = strtolower($lang);
		return isset($this->translations[$code]) ? $this->translations[$code] : array();
	}
}
