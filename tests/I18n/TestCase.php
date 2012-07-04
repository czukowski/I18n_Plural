<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Testcase extends Kohana_Unittest_Testcase
{
	protected $object;
	protected static $initial_lang;

	public static function setUpBeforeClass()
	{
		self::$initial_lang = \I18n::lang();
	}

	public static function tearDownAfterClass()
	{
		\I18n::lang(self::$initial_lang);
	}

	public function setup_object()
	{
		$class = new \ReflectionClass(preg_replace('#_Test$#', '', get_class($this)));
		$this->object = $class->newInstanceArgs($this->_object_constructor_arguments());		
	}

	protected function _object_constructor_arguments()
	{
		return array();
	}
}