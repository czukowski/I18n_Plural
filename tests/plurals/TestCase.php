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
}