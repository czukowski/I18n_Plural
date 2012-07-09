<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;
use I18n;

abstract class Testcase extends I18n\Testcase
{
	public function setUp()
	{
		parent::setUp();
		$this->setup_object();
	}

	/**
	 * @dataProvider  provide_categories
	 */
	public function test_get_category($count, $expected)
	{
		$actual = $this->object->plural_category($count);
		$this->assertEquals($expected, $actual);
	}

	abstract public function provide_categories();
}