<?php
/**
 * I18n_Core test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n;
use I18n\Tests;

class CoreTest extends Testcase
{
	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($expected, $key, $context, $values, $lang)
	{
		$this->setup_mock_object();
		$actual = $this->object->translate($key, $context, $values, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_translate()
	{
		// [expected, key, context, values, lang]
		$provider = array_merge($this->provide_form_translation(), $this->provide_plural_translation(), $this->provide_unknown_translation());
		// Note: $three_arguments has intentionally skewed arguments to test translation without context
		$three_arguments = array(
			array('something different', 'something :what', NULL, array(':what' => 'different'), 'en'),
			array('něco jiného', 'something :what', NULL, array(':what' => 'jiného'), 'cs'),
		);
		return array_merge($three_arguments, array_map(array($this, 'map_translate_provider'), $provider));
	}

	public function map_translate_provider($item) {
		return array($item[1], $item[2], $item[3], $item[4], $item[5]);
	}

	public function provide_form_translation()
	{
		// [expectedForm, expectedTranslate, string, context, values, lang]
		return array(
			// 'mr' form
			array(':title man', 'This man', ':title person', 'mr', array(':title' => 'This'), 'en'),
			// 'ms' form
			array(':title woman', 'That woman', ':title person', 'ms', array(':title' => 'That'), 'en'),
			// 'some' form
			array(':title person', 'A person', ':title person', 'some', array(':title' => 'A'), 'en'),
			// 'other' doesn't exist, first form - 'some' - used
			array(':title person', 'Another person', ':title person', 'other', array(':title' => 'Another'), 'en'),
			// 'mr' form
			array(':title muž', 'Tamten muž', ':title person', 'mr', array(':title' => 'Tamten'), 'cs'),
			// assumed 'other'
			array(':title člověk', 'Tento člověk', ':title person', NULL, array(':title' => 'Tento'), 'cs'),
			// 'some' doesn't exist and there's 'other'
			array(':title člověk', 'Nějaký člověk', ':title person', 'some', array(':title' => 'Nějaký'), 'cs'),
		);
	}

	public function provide_plural_translation()
	{
		// [expectedPlural, expectedTranslate, string, context, values, lang]
		return array(
			array(':count countables', 'No countables', ':count countable', 0, array(':count' => 'No'), 'en'),
			array(':count countable', 'A countable', ':count countable', 1, array(':count' => 'A'), 'en'),
			array(':count countables', 'Two countables', ':count countable', 2, array(':count' => 'Two'), 'en'),
			array(':count countables', 'Three countables', ':count countable', 3, array(':count' => 'Three'), 'en'),
			array(':count countables', 'Four countables', ':count countable', 4, array(':count' => 'Four'), 'en'),
			array(':count countables', 'Many countables', ':count countable', 100, array(':count' => 'Many'), 'en'),
		);
	}

	public function provide_unknown_translation()
	{
		// [expectedPlural, expectedTranslate, string, context, values, lang]
		return array(
			// non-existing translation
			array('unknown', 'unknown', 'unknown', NULL, NULL, NULL),
			array('unknown', 'unknown', 'unknown', NULL, NULL, 'en'),
			array('unknown', 'unknown', 'unknown', NULL, NULL, 'cs'),
		);
	}

	/**
	 * @dataProvider  provide_form
	 */
	public function test_form($expected, $key, $form, $lang)
	{
		$actual = $this->object->form($key, $form, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_form()
	{
		// [expected, key, form, lang]
		$provider = array_merge($this->provide_form_translation(), $this->provide_unknown_translation());
		return array_map(array($this, 'map_context_provider'), $provider);
	}

	/**
	 * @dataProvider  provide_plural
	 */
	public function test_plural($expected, $key, $count, $lang)
	{
		$this->setup_mock_object();
		$actual = $this->object->plural($key, $count, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_plural()
	{
		// [expected, key, form, lang]
		$provider = array_merge($this->provide_plural_translation(), $this->provide_unknown_translation());
		return array_map(array($this, 'map_context_provider'), $provider);
	}

	public function map_context_provider($item) {
		return array($item[0], $item[2], $item[3], $item[5]);
	}

	public function test_plural_rules()
	{
		$plural_rules = new \ReflectionMethod($this->object, 'plural_rules');
		$plural_rules->setAccessible(TRUE);
		$instance1 = $plural_rules->invoke($this->object, 'en');
		$instance2 = $plural_rules->invoke($this->object, 'en');
		$this->assertSame($instance2, $instance1);
	}

	public function setUp()
	{
		parent::setUp();
		$this->setup_object();
		$this->object->attach($this->_reader_test_factory());
	}

	protected function setup_mock_object()
	{
		$this->object = $this->getMock($this->class_name(), array('plural_rules'));
		$this->object->expects($this->any())
			->method('plural_rules')
			->will($this->returnValue($this->_rules_test_factory()));
		$this->object->attach($this->_reader_test_factory());
	}

	private function _reader_test_factory()
	{
		return new Tests\Reader;
	}

	private function _rules_test_factory()
	{
		return new Tests\Rules;
	}
}