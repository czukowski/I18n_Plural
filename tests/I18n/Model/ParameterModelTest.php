<?php
/**
 * Parametrized translation model tests.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class ParameterModelTest extends SampleTestcase
{
	/**
	 * @dataProvider  provide_initialize
	 */
	public function test_initialize($argument, $expected = NULL)
	{
		$this->_set_expected_exception($expected);
		$actual = $this->object->initialize($argument);
		$this->assertSame($this->object, $actual);
		$translate = new \ReflectionProperty($this->object, '_translate');
		$translate->setAccessible(TRUE);
		$this->assertEquals($argument, $translate->getValue($this->object));
	}

	public function provide_initialize()
	{
		// [initialize argument, expected exception]
		return array(
			// Ok arguments.
			array(
				array(),
			),
			array(
				array(
					array('context', 2),
					array('lang', 'en'),
					array('string', ':count :things'),
					array('parameter', ':count'),
					array('parameter', ':things', 'models'),
				),
			),
			// Invalid definition type.
			array(
				array(
					array('parameters', ':count', 1),
				),
				new \InvalidArgumentException
			),
			// Too much definition arguments.
			array(
				array(
					array('context', 2, TRUE),
				),
				new \InvalidArgumentException
			),
			array(
				array(
					array('parameter', ':person', 'Unknown', 'extra parameter'),
				),
				new \InvalidArgumentException
			),
			// Too few definition arguments.
			array(
				array(
					array('parameter', ':count', 1),
					array('string'),
				),
				new \InvalidArgumentException,
			),
		);
	}

	/**
	 * Tests `string()` setter and getter.
	 */
	public function test_string()
	{
		$predefined_string = new \ReflectionProperty($this->object, '_string');
		$predefined_string->setAccessible(TRUE);
		$this->assertSame($predefined_string->getValue($this->object), $this->object->string());
		$this->assertSame($this->object, $this->object->string('string set'));
		$this->assertSame('string set', $this->object->string());
	}

	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($presets, $methods, $arguments, $expected)
	{
		// Setup translate definitions.
		$this->object->initialize($presets);
		// Setup object state (context, lang, parameters, string).
		foreach ($methods as $name => $argument)
		{
			$method = new \ReflectionMethod($this->object, $name);
			$method->invoke($this->object, $argument);
		}
		// Test translations.
		$translate_method = new \ReflectionMethod($this->object, 'translate');
		$actual = $translate_method->invokeArgs($this->object, $arguments);
		$this->assertSame($expected, $actual);
	}

	public function provide_translate()
	{
		// [translate presets, invoke methods, arguments, expected]
		return array(
			// Initializing model using `_translate` property, testing various fallbacks.
			array(
				array(
					array('context', 2),
					array('lang', 'en'),
					array('string', ':count things'),
					array('parameter', ':count'),
				),
				array(),
				array(),
				'2 things',
			),
			array(
				array(
					array('context', 2),
					array('lang', 'en'),
					array('string', ':count things'),
					array('parameter', ':count'),
				),
				array('context' => 3),
				array(),
				'3 things',
			),
			array(
				array(
					array('context', 2),
					array('lang', 'en'),
					array('string', ':count things'),
					array('parameter', ':count'),
				),
				array('context' => 3, 'lang' => 'cs'),
				array(2, 'cs'),
				'2 věci',
			),
			array(
				array(
					array('context', 2),
					array('lang', 'en'),
					array('string', 'undefined'),
					array('parameter', ':count'),
				),
				array(),
				array(5, 'cs', ':count things', 10),
				'5 věcí',
			),
			array(
				array(
					array('context', 'some'),
					array('parameter', ':title', 'Any'),
				),
				array('string' => ':title person'),
				array('mr', 'Mr'),
				'Mr person',
			),
			array(
				array(
					array('context', 'something'),
					array('parameter', ':item'),
					array('parameter', ':item'),
					array('parameter', ':item'),
					array('parameter', ':item'),
					array('parameter', ':item'),
					array('lang', 'en'),
				),
				array('string' => ':item-:item-:item-:item-:item'),
				array('Do'),
				'Do-Do-Do-Do-Do',
			),
			// Initializing model using model states only.
			array(
				array(),
				array(
					'string' => ':count things',
					'lang' => 'en',
					'context' => 10,
					'parameters' => array(':count' => 10),
				),
				array('any', 'arguments'),
				'10 things',
			),
		);
	}
}
