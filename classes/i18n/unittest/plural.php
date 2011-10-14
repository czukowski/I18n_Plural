<?php
/**
 * Base class for some I18n_Plurals unit tests
 * 
 * @package    I18n_Plural
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Unittest_Plural extends Kohana_Unittest_Testcase
{
	/**
	 * @var  I18n_Plural_Rules
	 */
	public $instance;

	/**
	 * Creates plural rules instance
	 */
	public function setUp()
	{
		$class_name = preg_replace('#_Test$#', '', get_class($this));
		$this->instance = new $class_name;
		parent::setUp();
	}

	/**
	 * @return  array
	 */
	abstract public function provider_counts();

	/**
	 * Test plural rules instance returns correct translation forms
	 * 
	 * @dataProvider   provider_counts
	 * @param  mixed   $count
	 * @param  string  $category
	 */
	public function test_counts($count, $category)
	{
		$this->assertEquals($category, $this->instance->get_category($count));
	}
}