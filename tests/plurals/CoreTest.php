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
use Plurals\Tests;

class I18n_Core_Test extends I18n_Testcase {

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
			array('something different', 'something :what', array(':what' => 'different'), 'en', NULL),
			array('něco jiného', 'something :what', array(':what' => 'jiného'), 'cs', NULL),
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

	/**
	 * @dataProvider  provide_plural_rules
	 */
	public function test_plural_rules($lang, $class_name)
	{
		$instance1 = $this->_invoke_plural_rules($lang);
		$instance2 = $this->_invoke_plural_rules($lang);
		$this->assertInstanceOf($class_name, $instance1);
		$this->assertSame($instance2, $instance1);		

	}

	public function provide_plural_rules()
	{
		$provide = array();
		$locales = $this->provide_locales();
		foreach ($locales as $parameters)
		{
			foreach ($parameters[0] as $lang)
			{
				$provide[] = array($lang, $parameters[1]);
			}
		}
		return $provide;
	}

	public function provide_locales()
	{
		return array(
			array(
				array(
					'bem', 'brx', 'da', 'de', 'el', 'en', 'eo', 'es', 'et', 'fi', 'fo', 'gl', 'it', 'nb',
					'nl', 'nn', 'no', 'sv', 'af', 'bg', 'bn', 'ca', 'eu', 'fur', 'fy', 'gu', 'ha', 'is', 'ku',
					'lb', 'ml', 'mr', 'nah', 'ne', 'om', 'or', 'pa', 'pap', 'ps', 'so', 'sq', 'sw', 'ta', 'te',
					'tk', 'ur', 'zu', 'mn', 'gsw', 'chr', 'rm', 'pt',
				),
				'\I18n_Plural_One',
			),
			array(
				array('cs', 'sk'),
				'\I18n_Plural_Czech',
			),
			array(
				array('ff', 'fr', 'kab'),
				'\I18n_Plural_French',
			),
			array(
				array('hr', 'ru', 'sr', 'uk', 'be', 'bs', 'sh'),
				'\I18n_Plural_Balkan',
			),
			array(
				array('lv'),
				'\I18n_Plural_Latvian',
			),
			array(
				array('lt'),
				'\I18n_Plural_Lithuanian',
			),
			array(
				array('pl'),
				'\I18n_Plural_Polish',
			),
			array(
				array('ro', 'mo'),
				'\I18n_Plural_Romanian',
			),
			array(
				array('sl'),
				'\I18n_Plural_Slovenian',
			),
			array(
				array('ar'),
				'\I18n_Plural_Arabic',
			),
			array(
				array('mk'),
				'\I18n_Plural_Macedonian',
			),
			array(
				array('cy'),
				'\I18n_Plural_Welsh',
			),
			array(
				array('br'),
				'\I18n_Plural_Breton',
			),
			array(
				array('lag'),
				'\I18n_Plural_Langi',
			),
			array(
				array('shi'),
				'\I18n_Plural_Tachelhit',
			),
			array(
				array('mt'),
				'\I18n_Plural_Maltese',
			),
			array(
				array('he'),
				'\I18n_Plural_Hebrew',
			),
			array(
				array('ga'),
				'\I18n_Plural_Irish',
			),
			array(
				array('gd'),
				'\I18n_Plural_Gaelic',
			),
			array(
				array('gv'),
				'\I18n_Plural_Manx',
			),
			array(
				array('tzm'),
				'\I18n_Plural_Tamazight',
			),
			array(
				array('ksh'),
				'\I18n_Plural_Colognian',
			),
			array(
				array('se', 'sma', 'smi', 'smj', 'smn', 'sms'),
				'\I18n_Plural_Two',
			),
			array(
				array('ak', 'am', 'bh', 'fil', 'tl', 'guw', 'hi', 'ln', 'mg', 'nso', 'ti', 'wa'),
				'\I18n_Plural_Zero',
			),
			array(
				array(
					'az', 'bm', 'fa', 'ig', 'hu', 'ja', 'kde', 'kea', 'ko', 'my', 'ses', 'sg', 'to',
					'tr', 'vi', 'wo', 'yo', 'zh', 'bo', 'dz', 'id', 'jv', 'ka', 'km', 'kn', 'ms', 'th',
				),
				'\I18n_Plural_None',
			),
		);
	}

	/**
	 * @dataProvider  provide_invalid_plural_rules
	 */
	public function test_invalid_instance($lang)
	{
		$this->setExpectedException('\InvalidArgumentException');
		$this->object = new \I18n_Core($this->_reader_test_factory());
		$this->_invoke_plural_rules($lang);
	}

	public function provide_invalid_plural_rules()
	{
		return array(
			array('xx'),
			array(NULL),
			array(TRUE),
			array(FALSE),
			array(0),
			array(100),
			array(-3.14),
		);
	}

	public function setUp()
	{
		parent::setUp();
		$this->setup_object();
		$this->object->attach($this->_reader_test_factory());
	}

	protected function setup_mock_object()
	{
		$this->object = $this->getMock('\I18n_Core', array('plural_rules'));
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

	private function _invoke_plural_rules($lang)
	{
		$plural_rules = new \ReflectionMethod($this->object, 'plural_rules');
		$plural_rules->setAccessible(TRUE);
		return $plural_rules->invoke($this->object, $lang);
	}
}