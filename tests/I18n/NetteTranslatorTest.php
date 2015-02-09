<?php
/**
 * NetteTranslatorTest test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n;

class NetteTranslatorTest extends Testcase
{
	/**
	 * @var  array
	 */
	private $_constructor_arguments = array();

	/**
	 * @dataProvider  provide_construct
	 */
	public function test_construct($arguments, $expected)
	{
		$this->_constructor_arguments = $arguments;
		$this->setup_object();
		$default_lang = new \ReflectionProperty($this->object, 'default_lang');
		$default_lang->setAccessible(TRUE);
		$actual = $default_lang->getValue($this->object);
		$this->assertSame($expected, $actual);
	}

	public function provide_construct()
	{
		// [constructor arguments, expcted default lang]
		return array(
			array(array(), 'x'),
			array(array('cs'), 'cs'),
			array(array('cs-cz'), 'cs-cz'),
			array(array($this->_create_context(NULL)), 'x'),
			array(array($this->_create_context('cs')), 'cs'),
		);
	}

	private function _create_context($default_locale)
	{
		$context = new \stdClass;
		$context->parameters['defaultLocale'] = $default_locale;
		return $context;
	}

	/**
	 * @dataProvider  provide_attach
	 */
	public function test_attach($reader)
	{
		$this->setup_object();
		$this->object->attach($reader);
		$core = $this->object->getService();
		$readers = new \ReflectionProperty($core, '_readers');
		$readers->setAccessible(TRUE);
		$actual = $readers->getValue($core);
		$this->assertSame(1, count($actual));
		$this->assertSame($reader, reset($actual));
	}

	public function provide_attach()
	{
		// [reader object]
		return array(
			array(
				$this->getMock('I18n\Reader\ReaderInterface', array('get')),
			),
			array(
				new Tests\DefaultReader,
			),
			array(
				new Reader\NetteReader('app://'),
			),
			array(
				new Reader\NeonReader('app://'),
			),
		);
	}

	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($arguments, $default_lang, $expected)
	{
		$this->_constructor_arguments = array($default_lang);
		$this->setup_object();
		$this->object->attach(new Tests\DefaultReader);
		$translate = new \ReflectionMethod($this->object, 'translate');
		$actual = $translate->invokeArgs($this->object, $arguments);
		$this->assertSame($expected, $actual);
	}

	public function provide_translate()
	{
		// [arguments, default lang, expected]
		return array(
			// 'Normal' usage.
			array(array('Spanish'), 'x', 'Spanish'),
			array(array('Spanish'), 'es', 'Español'),
			array(array(':title person', 'mr'), 'cs', ':title muž'),
			array(array(':title person', 'ms', array(':title' => 'tato')), 'cs', 'tato žena'),
			array(array(':count things', 1), 'en', ':count thing'),
			array(array(':count things', 1, array(':count' => 1)), 'en', '1 thing'),
			array(array(':count things', 1, array(':count' => 1), 'cs'), 'en', '1 věc'),
			array(array(':count things', 2, array(':count' => 2), 'en'), 'cs', '2 things'),
			array(array(':count things', 3, array(':count' => 3), 'cs'), 'cs', '3 věci'),
			array(array(':count things', 10, array(':count' => 'ten')), 'en', 'ten things'),
			array(array(':count things', 10, array(':count' => 'deset'), 'cs'), 'en', 'deset věcí'),
			array(array(':title person', 'ms', array(':title' => 'some')), 'zh', 'some person'),
			// Context parameter may be missing and arguments shifted.
			array(array(':title person', NULL, array(':title' => 'some')), 'zh', 'some person'),
			array(array(':title person', array(':title' => 'some')), 'zh', 'some person'),
			array(array(':title person', array(':title' => 'nějaký'), 'cs'), 'zh', 'nějaký člověk'),
		);
	}

	protected function _object_constructor_arguments()
	{
		return $this->_constructor_arguments;
	}
}
