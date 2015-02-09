<?php
/**
 * File Based Reader base class test.
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use I18n;

class FileBasedReaderTest extends I18n\Testcase
{
	/**
	 * @var  array
	 */
	private $translations = array(
		'en' => array(
			'hello' => 'Hello',
			'salute' => array(
				'm' => 'Hello dear Sir',
				'f' => 'Hello dear Madame',
			),
		),
		'en-us' => array(
			'hello' => 'Howdy',
		),
	);
	/**
	 * @var  integer
	 */
	private $load_file_counter;

	/**
	 * @dataProvider  provide_split_lang
	 */
	public function test_split_lang($expected, $lang)
	{
		$split_lang = new \ReflectionMethod($this->object, 'split_lang');
		$split_lang->setAccessible(TRUE);
		$actual = $split_lang->invoke($this->object, $lang);
		$this->assertSame($expected, $actual);
	}

	public function provide_split_lang()
	{
		return array(
			array(array('en'), 'en'),
			array(array('en', 'us'), 'en-us'),
			array(array('en', 'us'), 'en-US'),
			array(array('en', 'us', 'x', 'twain'), 'en-US-x-twain'),
		);
	}

	/**
	 * @dataProvider  provide_get
	 */
	public function test_get($expected, $string, $lang)
	{
		$actual = $this->object->get($string, $lang);
		$actual_repeated = $this->object->get($string, $lang);
		$this->assertSame(1, $this->load_file_counter);
		$this->assertSame($actual, $actual_repeated);
		$this->assertSame($expected, $actual);
	}

	public function provide_get()
	{
		// [expected, string, lang]
		return array(
			array('Hello', 'hello', 'en'),
			array('Howdy', 'hello', 'en-US'),
			array(NULL, 'howdy', 'en-US'),
			array(NULL, 'hello', 'zh'),
			array('Hello dear Madame', 'salute.f', 'en'),
			array(array('m' => 'Hello dear Sir', 'f' => 'Hello dear Madame'), 'salute', 'en'),
			array(NULL, 'salute', 'en-us'),
			array(NULL, 'salute.m', 'en-us'),
		);
	}

	public function setUp()
	{
		parent::setUp();
		$this->load_file_counter = 0;
		$this->object = $this->getMock($this->class_name(), array('load_translations'));
		$this->object->expects($this->any())
			->method('load_translations')
			->will($this->returnCallback(array($this, 'callback_load_translations')));
	}

	public function callback_load_translations($lang)
	{
		$this->load_file_counter++;
		$code = strtolower($lang);
		return isset($this->translations[$code]) ? $this->translations[$code] : array();
	}
}
