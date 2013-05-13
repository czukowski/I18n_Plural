<?php
/**
 * Testcase for Kohana-dependent classes
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 */
namespace I18n;

class KohanaTestcase extends Testcase
{
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