<?php
/**
 * Prefetching Reader class.
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Reader;
use I18n\Tests;

class PrefetchingReaderTest extends ReaderBaseTest
{
	/**
	 * @dataProvider  provide_attach
	 */
	public function test_attach($expected, $readers)
	{
		if ($expected instanceof \Exception)
		{
			$this->setExpectedException(get_class($expected));
		}
		foreach ($readers as $reader)
		{
			$actual = $this->object->attach($reader);
			$this->assertSame($this->object, $actual);
		}
		$object_readers = $this->get_reader_property('_readers');
		$actual = $object_readers->getValue($this->object);
		$this->assertSame($expected, $actual);
	}

	public function provide_attach()
	{
		$incompatible_reader = $this->getMock('I18n\Reader\ReaderInterface');
		$clean_reader = new Tests\CleanReader;
		$default_reader = new Tests\DefaultReader;
		// [expected, readers]
		return array(
			array(new \InvalidArgumentException, array($incompatible_reader)),
			array(new \InvalidArgumentException, array($clean_reader, $incompatible_reader)),
			array(array($clean_reader), array($clean_reader)),
			array(array($clean_reader, $default_reader), array($clean_reader, $default_reader)),
		);
	}

	/**
	 * @dataProvider  provide_get
	 */
	public function test_get($expected, $string, $lang)
	{
		$this->setup_get();
		parent::test_get($expected, $string, $lang);
		$actual_repeated = $this->object->get($string, $lang);
		$this->assertSame(1, $this->helper->load_file_counter);
		$this->assertSame($expected, $actual_repeated);
	}

	private function setup_get()
	{
		$this->helper = new LoadTranslationsCallback($this, $this->translations, 'collect_translations');
		$this->object = $this->helper->object;
	}

	/**
	 * @dataProvider  provide_load_to_cache
	 */
	public function test_load_to_cache($expected, $lang, $readers)
	{
		foreach ($readers as $reader)
		{
			$this->object->attach($reader);
		}
		$load_to_cache = new \ReflectionMethod($this->object, 'load_to_cache');
		$load_to_cache->setAccessible(TRUE);
		$load_to_cache->invoke($this->object, $lang);
		$actual = $this->get_reader_cache()->getValue($this->object);
		$this->assertEquals($expected, $actual);
	}

	public function provide_load_to_cache()
	{
		// [expected, lang, readers]
		return array(
			array(
				array(
					'en' => array('key1' => 'value1', 'key2' => 'valueB', 'key3' => 'valueC'),
				),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => 'value2'))),
					new Tests\CleanReader(array('en' => array('key2' => 'valueB', 'key3' => 'valueC'))),
				),
			),
			array(
				array(
					'en' => array('key1' => 'value1', 'key2' => array('subA' => 'valA', 'subB' => 'valB')),
				),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key1' => 'value2', 'key2' => array('subA' => 'valA')))),
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => array('subB' => 'valB')))),
				),
			),
			array(
				array(
					'en' => array('key1' => 'value1', 'key2' => array('valA', 'valB')),
				),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key2' => array('valA')))),
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => array('valB')))),
				),
			),
		);
	}

	/**
	 * @dataProvider  provide_reset_translations
	 */
	public function test_reset_translations($readers)
	{
		// Attach and prefetch initial readers.
		$this->setup_reset_translations($readers);
		// Check internal cache propertyies are not empty.
		$object_cache = $this->get_reader_property('_cache');
		$object_cache_keys = $this->get_reader_property('_cache_keys');
		$this->assertNotEmpty($object_cache->getValue($this->object));
		$this->assertEquals(array_keys($readers), $object_cache_keys->getValue($this->object));
		// Trigger reset translations by attaching another reader.
		$this->object->attach(new Tests\CleanReader);
		// Now check that internal cache property is empty.
		$this->assertEmpty($object_cache->getValue($this->object));
		$this->assertEmpty($object_cache_keys->getValue($this->object));
	}

	protected function setup_reset_translations($readers)
	{
		$langs = array_keys($readers);
		foreach ($readers as $lang_readers)
		{
			foreach ($lang_readers as $reader)
			{
				$this->object->attach($reader);
			}
		}
		foreach ($langs as $lang)
		{
			$this->object->get('anything', $lang);
		}
	}

	public function provide_reset_translations()
	{
		// [lang => readers array]
		return array(
			array(
				array(
					'en' => array(
						new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => 'value2'))),
						new Tests\CleanReader(array('en' => array('key2' => 'valueB', 'key3' => 'valueC'))),
					),
					'en-us' => array(
						new Tests\CleanReader(array('en' => array('key2' => array('valA')))),
					),
				),
			),
		);
	}

	/**
	 * @dataProvider  provide_construct
	 */
	public function test_construct($argument, $expected)
	{
		if ($expected instanceof \Exception)
		{
			$this->setExpectedException(get_class($expected));
		}
		$this->object = new PrefetchingReader($argument);
		$this->assertInstanceOf('I18n\Reader\PrefetchingReader', $this->object);
	}

	public function provide_construct()
	{
		return array(
			array(1, new \InvalidArgumentException),
			array(TRUE, new \InvalidArgumentException),
			array(array(), NULL),
			array(new \ArrayObject(array()), NULL),
		);
	}

	public function setUp()
	{
		$this->setup_object();
	}
}
