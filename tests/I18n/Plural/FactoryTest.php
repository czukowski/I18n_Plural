<?php
/**
 * Pural rules factory test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 * 
 * @group  plurals
 * @group  plurals.rules
 */
namespace I18n\Plural;
class FactoryTest extends \I18n\Testcase
{
	private $create_rules;

	/**
	 * @dataProvider  provide_create_rules
	 */
	public function test_create_rules($lang, $expected)
	{
		$actual = $this->create_rules->invoke($this->object, $lang);
		$this->assertInstanceOf($expected, $actual);
	}

	public function provide_create_rules()
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
				'\I18n\Plural\One',
			),
			array(
				array('cs', 'sk'),
				'\I18n\Plural\Czech',
			),
			array(
				array('ff', 'fr', 'kab'),
				'\I18n\Plural\French',
			),
			array(
				array('hr', 'ru', 'sr', 'uk', 'be', 'bs', 'sh'),
				'\I18n\Plural\Balkan',
			),
			array(
				array('lv'),
				'\I18n\Plural\Latvian',
			),
			array(
				array('lt'),
				'\I18n\Plural\Lithuanian',
			),
			array(
				array('pl'),
				'\I18n\Plural\Polish',
			),
			array(
				array('ro', 'mo'),
				'\I18n\Plural\Romanian',
			),
			array(
				array('sl'),
				'\I18n\Plural\Slovenian',
			),
			array(
				array('ar'),
				'\I18n\Plural\Arabic',
			),
			array(
				array('mk'),
				'\I18n\Plural\Macedonian',
			),
			array(
				array('cy'),
				'\I18n\Plural\Welsh',
			),
			array(
				array('br'),
				'\I18n\Plural\Breton',
			),
			array(
				array('lag'),
				'\I18n\Plural\Langi',
			),
			array(
				array('shi'),
				'\I18n\Plural\Tachelhit',
			),
			array(
				array('mt'),
				'\I18n\Plural\Maltese',
			),
			array(
				array('he'),
				'\I18n\Plural\Hebrew',
			),
			array(
				array('ga'),
				'\I18n\Plural\Irish',
			),
			array(
				array('gd'),
				'\I18n\Plural\Gaelic',
			),
			array(
				array('gv'),
				'\I18n\Plural\Manx',
			),
			array(
				array('tzm'),
				'\I18n\Plural\Tamazight',
			),
			array(
				array('ksh'),
				'\I18n\Plural\Colognian',
			),
			array(
				array('se', 'sma', 'smi', 'smj', 'smn', 'sms'),
				'\I18n\Plural\Two',
			),
			array(
				array('ak', 'am', 'bh', 'fil', 'tl', 'guw', 'hi', 'ln', 'mg', 'nso', 'ti', 'wa'),
				'\I18n\Plural\Zero',
			),
			array(
				array(
					'az', 'bm', 'fa', 'ig', 'hu', 'ja', 'kde', 'kea', 'ko', 'my', 'ses', 'sg', 'to',
					'tr', 'vi', 'wo', 'yo', 'zh', 'bo', 'dz', 'id', 'jv', 'ka', 'km', 'kn', 'ms', 'th',
				),
				'\I18n\Plural\None',
			),
		);
	}

	/**
	 * @dataProvider  provide_invalid_plural_rules
	 */
	public function test_invalid_instance($lang)
	{
		$this->setExpectedException('\InvalidArgumentException');
		$this->create_rules->invoke($this->object, $lang);
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
		$classname = $this->class_name();
		$this->object = new $classname;
		$this->create_rules = new \ReflectionMethod($this->object, 'create_rules');
		$this->create_rules->setAccessible(TRUE);
	}
}