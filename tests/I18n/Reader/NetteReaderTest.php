<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n\Reader;
use I18n;

class NetteReaderTest extends I18n\Testcase
{
	private $app_path = 'callback://app/';
	private $callback_counters = array();
	private $i18n = array(
		'cs.php' => array(
			'test' => 'test',
			'locale' => 'locale (cs)',
			'section' => array(
				'test' => 'section test'
			),
		),
		'cs/cz.php' => array(
			'locale' => 'locale (cs-cz)',
			'exclusive' => 'only in cs-cz',
		),
	);

	/**
	 * @dataProvider  provide_get
	 */
	public function test_get($expected, $string, $lang, $default_lang)
	{
		$this->setup_get($default_lang);
		$actual = $this->object->get($string, $lang);
		$this->assertSame($expected, $actual);
		// Call the method again to make sure the translation table has been read from cache this time.
		$this->object->get($string, $lang);
		foreach ($this->callback_counters as $key => $counter)
		{
			if ($counter > 1)
			{
				$this->fail('load_file() called '.$counter.' times for '.$key.', expected 0 or 1.');
			}
		}
	}

	public function provide_get()
	{
		// [expected, string, lang, default_lang]
		return array(
			// Strings existing in multiple locales with only target locale specified.
			array('locale (cs-cz)', 'locale', 'cs-cz', NULL),
			array('locale (cs)', 'locale', 'cs', NULL),
			// Strings existing in multiple locales with only default locale specified.
			array('locale (cs-cz)', 'locale', NULL, 'cs-cz'),
			array('locale (cs)', 'locale', NULL, 'cs'),
			// Test strings existing in multiple locales with target and default locales specified.
			array('locale (cs-cz)', 'locale', 'cs-cz', 'cs'),
			array('locale (cs)', 'locale', 'cs', 'cs-cz'),
			// Fallback to less specific locale.
			array('test', 'test', 'cs-cz', NULL),
			array('test', 'test', 'cs', NULL),
			// Structured translations (dot-delimited).
			array('section test', 'section.test', 'cs-cz', NULL),
			array('section test', 'section.test', 'cs', NULL),
			// Strings existing in most specific locale only.
			array('only in cs-cz', 'exclusive', 'cs-cz', NULL),
			array(NULL, 'exclusive', 'cs', NULL),
		);
	}

	public function callback_load_file($path)
	{
		$file = preg_replace('#^'.preg_quote($this->app_path.'i18n/', '#').'#', '', str_replace(DIRECTORY_SEPARATOR, '/', $path));
		if (isset($this->i18n[$file]))
		{
			$this->callback_counters[$file]++;
			return $this->i18n[$file];
		}
		return array();
	}

	private function setup_get($default_lang)
	{
		$context = new \stdClass;
		$context->parameters = array(
			'appDir' => $this->app_path,
			'defaultLocale' => $default_lang,
		);
		$this->object = $this->getMock($this->class_name(), array('load_file'), array($context));
		$this->object->expects($this->any())
			->method('load_file')
			->will($this->returnCallback(array($this, 'callback_load_file')));
	}

	public function setUp()
	{
		foreach (array_keys($this->i18n) as $key)
		{
			$this->callback_counters[$key] = 0;
		}
	}
}