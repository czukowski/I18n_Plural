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

class FileBasedReaderTest extends ReaderBaseTest
{
	/**
	 * @var  LoadTranslationsCallback
	 */
	private $helper;

	/**
	 * @dataProvider  provide_split_lang
	 */
	public function test_split_lang($expected, $lang)
	{
		$split_lang = $this->get_reader_method('split_lang');
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
		$this->assertSame(1, $this->helper->load_file_counter);
		$this->assertSame($expected, $actual_repeated);
	}

	/**
	 * @dataProvider  provide_load_to_cache
	 */
	public function test_load_to_cache($expected, $lang)
	{
		$load_to_cache = $this->get_reader_method('load_to_cache');
		$load_to_cache->invoke($this->object, $lang);
		$load_to_cache->invoke($this->object, $lang);
		$this->assertSame(1, $this->helper->load_file_counter);
		$actual = $this->get_reader_cache()->getValue($this->object);
		$this->assertSame($expected, $actual[$lang]);
	}

	public function provide_load_to_cache()
	{
		return array(
			array($this->translations['en'], 'en'),
			array($this->translations['en-us'], 'en-us'),
		);
	}

	public function setUp()
	{
		$this->helper = new LoadTranslationsCallback($this, $this->translations);
		$this->object = $this->helper->object;
	}
}
