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
	 * @dataProvider  provide_form
	 */
	public function test_form($expected, $key, $form, $lang)
	{
		$this->object = new \I18n_Core($this->reader_test_factory());
		$actual = $this->object->form($key, $form, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_form()
	{
		return array(
			// non-existing translation
			array('unknown', 'unknown', NULL, NULL),
			array('unknown', 'unknown', NULL, 'en'),
			array('unknown', 'unknown', NULL, 'cs'),
			// 'mr' form
			array('man', 'person', 'mr', 'en'),
			// 'ms' form
			array('woman', 'person', 'ms', 'en'),
			// 'some' form
			array('person', 'person', 'some', 'en'),
			// 'other' doesn't exist, first form - 'some' - used
			array('person', 'person', 'other', 'en'),
			// 'mr' form
			array('muž', 'person', 'mr', 'cs'),
			// assumed 'other'
			array('člověk', 'person', NULL, 'cs'),
			// 'some' doesn't exist and there's 'other'
			array('člověk', 'person', 'some', 'cs'),
		);
	}

	/**
	 * @dataProvider  provide_plural
	 */
	public function test_plural($expected, $key, $count, $lang)
	{
		$this->object = $this->getMock('\I18n_Core', array('plural_rules'), array($this->reader_test_factory()));
		$this->object->expects($this->any())
			->method('plural_rules')
			->will($this->returnValue($this->rules_test_factory()));
		$actual = $this->object->plural($key, $count, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_plural()
	{
		return array(
			// non-existing translation
			array('unknown', 'unknown', 1, NULL),
			array('unknown', 'unknown', 0, 'en'),
			array('unknown', 'unknown', 1.1, 'cs'),
			// non-existing translation
			array('No countables', 'countable', 0, 'en'),
			array('One countable', 'countable', 1, 'en'),
			array('Two countables', 'countable', 2, 'en'),
			array('Three countables', 'countable', 3, 'en'),
			array('Many countables', 'countable', 4, 'en'),
			array('Many countables', 'countable', 100, 'en'),
		);
	}

	/**
	 * @dataProvider  provide_plural_rules
	 */
	public function test_plural_rules($lang, $class_name)
	{
		$this->object = new \I18n_Core($this->reader_test_factory());
		$instance1 = $this->invoke_plural_rules($lang);
		$instance2 = $this->invoke_plural_rules($lang);
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
					'bem', 'brx', 'da', 'de', 'el', 'en', 'eo', 'es', 'et', 'fi', 'fo', 'gl', 'he', 'iw', 'it', 'nb',
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
				array('ga', 'se', 'sma', 'smi', 'smj', 'smn', 'sms'),
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
		$this->object = new \I18n_Core($this->reader_test_factory());
		$this->invoke_plural_rules($lang);
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

	/**
	 * @dataProvider  provide_instance
	 */
	public function test_instance($reader, $expected)
	{
		if ($reader !== NULL)
		{
			new \I18n_Core($reader);
		}
		if ($expected instanceof \Exception)
		{
			$this->setExpectedException(get_class($expected));
		}
		$this->object = \I18n_Core::instance();
		$this->assertInstanceOf($expected, $this->object);
	}

	public function provide_instance()
	{
		return array(
			array(NULL, new \RuntimeException('')),
			array($this->reader_mock_factory(), '\I18n_Core'),
		);
	}

	/**
	 * @dataProvider  provide_construct
	 */
	public function test_construct($reader)
	{
		$this->object = new \I18n_Core($reader);
		$this->assertSame(\I18n_Core::instance(), $this->object);
	}

	public function provide_construct()
	{
		return array(
			array($this->reader_mock_factory()),
		);
	}

	public function tearDown()
	{
		if ($this->object)
		{
			$this->object->__destruct();
		}
	}

	private function reader_mock_factory()
	{
		return $this->getMock('\I18n_Reader_Interface', array('get'));
	}

	private function reader_test_factory()
	{
		return new Tests\Reader;
	}

	private function rules_test_factory()
	{
		return new Tests\Rules;
	}

	private function invoke_plural_rules($lang)
	{
		$plural_rules = new \ReflectionMethod($this->object, 'plural_rules');
		$plural_rules->setAccessible(TRUE);
		return $plural_rules->invoke($this->object, $lang);
	}

}