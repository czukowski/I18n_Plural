<?php
/**
 * I18n_Core test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
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
	public function test_translate($expected, $key, $context, $values, $lang, $use_fallback)
	{
		$this->setup_mock_object();
		$this->object->use_fallback($use_fallback);
		$actual = $this->object->translate($key, $context, $values, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_translate()
	{
		// [expected, translation key, context, replace values, target language(s), use fallback?]
		// Merge data from other translation test providers into one combined data set.
		// The `map_translate_provider` method will also set 'use fallback' flag to FALSE.
		$provider = array_map(array($this, 'map_translate_provider'), array_merge(
			$this->provide_form_translation(),
			$this->provide_plural_translation(),
			$this->provide_unknown_translation()
		));
		// Add items with reduced arguments count to data set to test translation without context.
		$three_arguments = array(
			array('something different', 'something :what', NULL, array(':what' => 'different'), 'en', FALSE),
			array('něco jiného', 'something :what', NULL, array(':what' => 'jiného'), 'cs', FALSE),
		);
		// Combine providers to get all test cases for translation by reader without using fallback.
		$merged_provider = array_merge($three_arguments, $provider);
		// Turn `lang` parameters from the merged provider to arrays in order to test translations with fallback.
		$fallback_provider = array_map(array($this, 'map_translate_with_fallback_provider'), $merged_provider);
		// Return both default and 'with fallback' items in data set. Note that this is just a simple test
		// of checking the translation string with only one reader used. The translations 'with fallback'
		// only make sense where multiple translation readers are used. That is verified in another test.
		return array_merge($merged_provider, $fallback_provider);
	}

	public function map_translate_provider($item)
	{
		// Return item without expected context value from data provider.
		return array($item[1], $item[2], $item[3], $item[4], $item[5], FALSE);
	}

	public function map_translate_with_fallback_provider($item)
	{
		$item[5] = TRUE;  // Set the 6th argument (use fallback flag) to TRUE.
		return $item;
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

	public function map_context_provider($item)
	{
		return array($item[0], $item[2], $item[3], $item[5]);
	}

	/**
	 * @dataProvider  povide_get_with_fallback
	 */
	public function test_get_with_fallback($expected, $key, $lang, $translations)
	{
		$this->setup_get_with_fallback($translations);
		$get = new \ReflectionMethod($this->object, 'get');
		$get->setAccessible(TRUE);
		$actual = $get->invoke($this->object, $key, $lang);
		$this->assertSame($expected, $actual);
	}

	protected function setup_get_with_fallback($translations)
	{
		$this->setup_mock_object(FALSE);
		foreach ($translations as $translation_table)
		{
			$reader = $this->_reader_test_factory($translation_table);
			$this->object->attach($reader);
		}
	}

	public function povide_get_with_fallback()
	{
		// [expected, key, lang, translation sets]
		$translation_table_1 = array(
			'en' => array('hello' => 'Hello there!', 'i am :name' => 'I am :name'),
			'en-us' => array(),
		);
		$translation_table_2 = array(
			'en' => array('hello' => 'Hi there!', 'i am :name' => 'I be :name'),
			'en-us' => array('hello' => 'Howdy!'),
		);
		// The expected result depends on the readers order and locale code.
		return array(
			array('Hello there!', 'hello', 'en', array($translation_table_1, $translation_table_2)),
			array('Hi there!', 'hello', 'en', array($translation_table_2, $translation_table_1)),
			array('Howdy!', 'hello', 'en-us', array($translation_table_1, $translation_table_2)),
			array('Howdy!', 'hello', 'en-us', array($translation_table_2, $translation_table_1)),
			array('I am :name', 'i am :name', 'en', array($translation_table_1, $translation_table_2)),
			array('I be :name', 'i am :name', 'en', array($translation_table_2, $translation_table_1)),
			array('I am :name', 'i am :name', 'en-us', array($translation_table_1, $translation_table_2)),
			array('I be :name', 'i am :name', 'en-us', array($translation_table_2, $translation_table_1)),
		);
	}

	/**
	 * @dataProvider  provide_split_lang
	 */
	public function test_split_lang($lang, $expected)
	{
		$split_lang = new \ReflectionMethod($this->object, 'split_lang');
		$split_lang->setAccessible(TRUE);
		$actual = $split_lang->invoke($this->object, $lang);
		$this->assertSame($expected, $actual);
		$langs_splits = new \ReflectionProperty($this->object, '_fallback_paths');
		$langs_splits->setAccessible(TRUE);
		$cached_actual = $langs_splits->getValue($this->object);
		$this->assertTrue(array_key_exists($lang, $cached_actual));
		$this->assertSame($expected, $cached_actual[$lang]);
	}

	public function provide_split_lang()
	{
		// [lang code, expected fallback]
		return array(
			array('en', array('en')),
			array('en-us', array('en-us', 'en')),
		);
	}

	/**
	 * @dataProvider  provide_use_fallback
	 */
	public function test_use_fallback_setter($value)
	{
		$actual = $this->object->use_fallback($value);
		$this->assertSame($this->object, $actual);
		$use_fallback = new \ReflectionProperty($this->object, '_use_fallback');
		$use_fallback->setAccessible(TRUE);
		$this->assertSame($value, $use_fallback->getValue($this->object));
	}

	/**
	 * @dataProvider  provide_use_fallback
	 */
	public function test_use_fallback_getter($value)
	{
		$use_fallback = new \ReflectionProperty($this->object, '_use_fallback');
		$use_fallback->setAccessible(TRUE);
		$use_fallback->setValue($this->object, $value);
		$actual = $this->object->use_fallback();
		$this->assertSame($value, $actual);
	}

	public function provide_use_fallback()
	{
		return array(
			array(TRUE),
			array(FALSE),
		);
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

	protected function setup_mock_object($attach_default_reader = TRUE)
	{
		$this->object = $this->getMock($this->class_name(), array('plural_rules'));
		$this->object->expects($this->any())
			->method('plural_rules')
			->will($this->returnValue($this->_rules_test_factory()));
		if ($attach_default_reader)
		{
			$this->object->attach($this->_reader_test_factory());
		}
	}

	private function _reader_test_factory($additional_translations = array())
	{
		return $additional_translations
			? new Tests\CleanReader($additional_translations)
			: new Tests\DefaultReader;
	}

	private function _rules_test_factory()
	{
		return new Tests\Rules;
	}
}