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

class FileBasedReaderTest extends ReaderBaseTest
{
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
		parent::test_get($expected, $string, $lang);
		$actual_repeated = $this->object->get($string, $lang);
		$this->assertSame(1, $this->load_file_counter);
		$this->assertSame($expected, $actual_repeated);
	}

	/**
	 * @dataProvider  provide_prefetch
	 */
	public function test_prefetch($expected, $lang)
	{
		$actual = $this->object->prefetch($lang);
		$actual_repeated = $this->object->prefetch($lang);
		$this->assertSame(1, $this->load_file_counter);
		$this->assertSame($actual, $actual_repeated);
		$this->assertSame($expected, $actual);
	}

	public function provide_prefetch()
	{
		return array(
			array($this->translations['en'], 'en'),
			array($this->translations['en-us'], 'en-us'),
		);
	}

	public function setUp()
	{
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
