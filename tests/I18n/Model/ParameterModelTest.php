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
		$translate_property = new \ReflectionProperty($this->object, '_translate');
		$translate_property->setAccessible(TRUE);
		$translate_property->setValue($this->object, $presets);
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
		);
	}
}
