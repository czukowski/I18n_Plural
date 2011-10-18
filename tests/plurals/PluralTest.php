<?php
/**
 * I18n_Plural test
 *
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 * 
 * @group plurals
 */
class I18n_Plural_Test extends Kohana_Unittest_Testcase
{
	/**
	 * @return  array
	 */
	public function provider_locales()
	{
		return array(
			array(
				array(
					'bem', 'brx', 'da', 'de', 'el', 'en', 'eo', 'es', 'et', 'fi', 'fo', 'gl', 'he', 'iw', 'it', 'nb',
					'nl', 'nn', 'no', 'sv', 'af', 'bg', 'bn', 'ca', 'eu', 'fur', 'fy', 'gu', 'ha', 'is', 'ku',
					'lb', 'ml', 'mr', 'nah', 'ne', 'om', 'or', 'pa', 'pap', 'ps', 'so', 'sq', 'sw', 'ta', 'te',
					'tk', 'ur', 'zu', 'mn', 'gsw', 'chr', 'rm', 'pt',
				),
				'I18n_Plural_One',
			),
			array(
				array('cs', 'sk'),
				'I18n_Plural_Czech',
			),
			array(
				array('ff', 'fr', 'kab'),
				'I18n_Plural_French',
			),
			array(
				array('hr', 'ru', 'sr', 'uk', 'be', 'bs', 'sh'),
				'I18n_Plural_Balkan',
			),
			array(
				array('lv'),
				'I18n_Plural_Latvian',
			),
			array(
				array('lt'),
				'I18n_Plural_Lithuanian',
			),
			array(
				array('pl'),
				'I18n_Plural_Polish',
			),
			array(
				array('ro', 'mo'),
				'I18n_Plural_Romanian',
			),
			array(
				array('sl'),
				'I18n_Plural_Slovenian',
			),
			array(
				array('ar'),
				'I18n_Plural_Arabic',
			),
			array(
				array('mk'),
				'I18n_Plural_Macedonian',
			),
			array(
				array('cy'),
				'I18n_Plural_Welsh',
			),
			array(
				array('br'),
				'I18n_Plural_Breton',
			),
			array(
				array('lag'),
				'I18n_Plural_Langi',
			),
			array(
				array('shi'),
				'I18n_Plural_Tachelhit',
			),
			array(
				array('mt'),
				'I18n_Plural_Maltese',
			),
			array(
				array('ga', 'se', 'sma', 'smi', 'smj', 'smn', 'sms'),
				'I18n_Plural_Two',
			),
			array(
				array('ak', 'am', 'bh', 'fil', 'tl', 'guw', 'hi', 'ln', 'mg', 'nso', 'ti', 'wa'),
				'I18n_Plural_Zero',
			),
			array(
				array(
					'az', 'bm', 'fa', 'ig', 'hu', 'ja', 'kde', 'kea', 'ko', 'my', 'ses', 'sg', 'to',
					'tr', 'vi', 'wo', 'yo', 'zh', 'bo', 'dz', 'id', 'jv', 'ka', 'km', 'kn', 'ms', 'th',
				),
				'I18n_Plural_None',
			),
		);
	}

	/**
	 * @return  array
	 */
	public function provider_invalid_instance()
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
	 * @dataProvider  provider_invalid_instance
	 * @param  mixed  $lang
	 */
	public function test_invalid_instance($lang)
	{
		$this->setExpectedException('Kohana_Exception');
		I18n_Plural::instance($lang);
	}

	/**
	 * @return  array
	 */
	public function provider_valid_instance()
	{
		$provide = array();
		$locales = $this->provider_locales();
		foreach ($locales as $parameters)
		{
			foreach ($parameters[0] as $lang)
			{
				$provide[] = array($lang, $parameters[1]);
			}
		}
		return $provide;
	}

	/**
	 * @dataProvider   provider_valid_instance
	 * @param  string  $lang
	 * @param  string  $class_name 
	 */
	public function test_valid_instance($lang, $class_name)
	{
		// Test instance class name
		$instance1 = I18n_Plural::instance($lang);
		$this->assertInstanceOf($class_name, $instance1);

		// Test instance caching
		$instance2 = I18n_Plural::instance($lang);
		$this->assertSame($instance2, $instance1);		
	}
}