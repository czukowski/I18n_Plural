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
use I18n;

class ReaderBaseTest extends I18n\Testcase
{
	/**
	 * @var  array
	 */
	protected $translations = array(
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
	 * @dataProvider  provide_get
	 */
	public function test_get($expected, $string, $lang)
	{
		$actual = $this->object->get($string, $lang);
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

	/**
	 * @return  \ReflectionProperty
	 */
	protected function get_reader_cache()
	{
		return $this->get_reader_property('_cache');
	}

	/**
	 * @return  \ReflectionMethod
	 */
	protected function get_reader_method($method_name)
	{
		$method = new \ReflectionMethod($this->object, $method_name);
		$method->setAccessible(TRUE);
		return $method;
	}

	/**
	 * @return  \ReflectionProperty
	 */
	protected function get_reader_property($property_name)
	{
		$property = new \ReflectionProperty($this->object, $property_name);
		$property->setAccessible(TRUE);
		return $property;
	}

	public function setUp()
	{
		parent::setUp();
		$this->object = $this->getMock($this->class_name(), array('none'));
		$this->get_reader_cache()->setValue($this->object, $this->translations);
	}
}
