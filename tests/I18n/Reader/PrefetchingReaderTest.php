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
		$object_readers = new \ReflectionProperty($this->object, '_readers');
		$object_readers->setAccessible(TRUE);
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
		$this->helper = new LoadTranslationsCallback($this, $this->translations);
		$this->object = $this->helper->object;
	}

	/**
	 * @dataProvider  provide_prefetch
	 */
	public function test_prefetch($expected, $lang, $readers)
	{
		foreach ($readers as $reader)
		{
			$this->object->attach($reader);
		}
		$actual = $this->object->prefetch($lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_prefetch()
	{
		// [expected, lang, readers]
		return array(
			array(
				array('key1' => 'value1', 'key2' => 'valueB', 'key3' => 'valueC'),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => 'value2'))),
					new Tests\CleanReader(array('en' => array('key2' => 'valueB', 'key3' => 'valueC'))),
				),
			),
			array(
				array('key1' => 'value1', 'key2' => array('subA' => 'valA', 'subB' => 'valB')),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key1' => 'value2', 'key2' => array('subA' => 'valA')))),
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => array('subB' => 'valB')))),
				),
			),
			array(
				array('key1' => 'value1', 'key2' => array('valA', 'valB')),
				'en',
				array(
					new Tests\CleanReader(array('en' => array('key2' => array('valA')))),
					new Tests\CleanReader(array('en' => array('key1' => 'value1', 'key2' => array('valB')))),
				),
			),
		);
	}

	public function test_reset_translations()
	{
		$object_cache = new \ReflectionProperty($this->object, '_cache');
		$object_cache->setAccessible(TRUE);
		$object_cache->setValue($this->object, array('x' => array()));
		$reset_translations = new \ReflectionMethod($this->object, 'reset_translations');
		$reset_translations->setAccessible(TRUE);
		$actual = $reset_translations->invoke($this->object);
		$this->assertSame($this->object, $actual);
		$actual_cache = $object_cache->getValue($this->object);
		$this->assertEmpty($actual_cache);
	}

	public function setUp()
	{
		$this->setup_object();
	}
}
