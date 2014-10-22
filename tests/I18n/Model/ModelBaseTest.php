<?php
/**
 * Base model tests
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 * 
 * @group  models
 */
namespace I18n\Model;
use I18n;

class ModelBaseTest extends Testcase
{
	/**
	 * @dataProvider  provide_context
	 */
	public function test_context($preset, $arguments, $expected)
	{
		if ($preset)
		{
			// Set 'previous' context state, if needed.
			$this->object->context($preset);
		}
		// Invoke `context()` method with `$arguments`.
		$actual = $this->_object_method('context')
			->invokeArgs($this->object, $arguments);
		if ($arguments)
		{
			// For non-empty arguments, make sure the context has changed.
			$this->assertSame($this->object, $actual);
			$this->assertSame($expected, $this->object->context());
		}
		else
		{
			// For empty arguments, make sure the context remained unchanged.
			$this->assertSame($preset, $actual);
		}
	}

	public function provide_context()
	{
		// [previous context, method arguments, expected]
		return array(
			array(NULL, array(0), 0),
			array(1, array(3.14), 3.14),
			array('other', array('one'), 'one'),
			array(NULL, array(), NULL),
			array(10, array(), 10),
		);
	}

	/**
	 * Tests I18n Core object setter and getter.
	 */
	public function test_i18n()
	{
		// Try get the core object before it's been set.
		try
		{
			$this->object->i18n();
			$this->fail('LogicException expected, nothing thrown.');
		}
		catch (\Exception $e)
		{
			$this->assertInstanceOf('LogicException', $e);
		}
		// Set the core object and verify the return value.
		$i18n = new I18n\Core;
		$object = $this->object->i18n($i18n);
		$this->assertSame($this->object, $object);
		// Get (call without arguments) the previously set core object.
		$actual = $this->object->i18n();
		$this->assertSame($actual, $i18n);
	}

	/**
	 * @dataProvider  provide_lang
	 */
	public function test_lang($preset, $arguments, $expected)
	{
		if ($preset)
		{
			// Set 'previous' lang state, if needed.
			$this->object->lang($preset);
		}
		// Invoke `lang()` method with `$arguments`.
		$actual = $this->_object_method('lang')
			->invokeArgs($this->object, $arguments);
		if ($arguments)
		{
			// For non-empty arguments, make sure the language has changed.
			$this->assertSame($this->object, $actual);
			$this->assertSame($expected, $this->object->lang());
		}
		else
		{
			// For empty arguments, make sure the language remained unchanged.
			$this->assertSame($preset, $actual);
		}
	}

	public function provide_lang()
	{
		// [previous lang, method arguments, expected]
		return array(
			array(NULL, array('en'), 'en'),
			array('lt', array('en'), 'en'),
			array('lt', array(NULL), NULL),
			array('en', array(), 'en'),
		);
	}

	/**
	 * @dataProvider  provide_parameter
	 */
	public function test_parameter($preset, $arguments, $expected)
	{
		$parameter = $this->_object_method('parameter');
		if ($preset)
		{
			// Set 'previous' parameter value if needed.
			$parameter->invokeArgs($this->object, $preset);
		}
		// Set expected exception from `$expected` argument.
		$this->_set_expected_exception($expected);
		// Invoke `parameter()` method with `$arguments`.
		$actual = $parameter->invokeArgs($this->object, $arguments);
		// If still no exception thrown, verify set parameter value.
		if (count($arguments) === 2)
		{
			// Test setter method; `$actual` is the model instance itself.
			$this->assertSame($this->object, $actual);
			$key = reset($arguments);
			$this->assertSame($expected, $this->object->parameter($key));
		}
		else
		{
			// Test getter method; `$actual` is the return value.
			$this->assertSame($expected, $actual);
		}
	}

	public function provide_parameter()
	{
		// [previous method arguments, method arguments, expected]
		return array(
			array(array(), array('key1', 'value1'), 'value1'),
			array(array('key1', 'value0'), array('key1', 'value1'), 'value1'),
			array(array('key1', 'value1'), array('key1'), 'value1'),
			array(array(), array('key1'), new \InvalidArgumentException),
		);
	}

	/**
	 * @dataProvider  provide_parameters
	 */
	public function test_parameters($preset, $arguments, $expected)
	{
		if ($preset)
		{
			// Set 'previous' parameters if needed.
			$this->object->parameters($preset);
		}
		// Invoke `parameter()` method with `$arguments`.
		$actual = $this->_object_method('parameters')
			->invokeArgs($this->object, $arguments);
		if ($arguments)
		{
			// Test setter method; `$actual` is the model instance itself.
			$this->assertSame($this->object, $actual);
			$this->assertSame($expected, $this->object->parameters());
		}
		else
		{
			// Test getter method; `$actual` are the return values.
			$this->assertSame($expected, $actual);
		}
	}

	public function provide_parameters()
	{
		// [previously set parameters, method arguments, expected]
		return array(
			array(array(), array(), array()),
			array(array('key' => 'value'), array(), array('key' => 'value')),
			array(array('key' => 'value1'), array(array('key' => 'value2')), array('key' => 'value2')),
			array(array('key1' => 'value1'), array(array('key2' => 'value2')), array('key2' => 'value2')),
			array(array(), array(new \ArrayObject(array('key' => 'value'))), array('key' => 'value')),
		);
	}

	/**
	 * @dataProvider  provide_parameter_default
	 */
	public function test_parameter_default($parameters, $arguments, $expected)
	{
		$this->object->parameters($parameters);
		$parameter_default = $this->_object_method('_parameter_default');
		$parameter_default->setAccessible(TRUE);
		$actual = $parameter_default->invokeArgs($this->object, $arguments);
		$this->assertSame($expected, $actual);
	}

	public function provide_parameter_default()
	{
		$parameters = array(
			'key1' => 'value1',
			'nil' => NULL,
		);
		// [previously set parameters, requested key, default value, expected]
		return array(
			array($parameters, array('key1'), 'value1'),
			array($parameters, array('key2'), NULL),
			array($parameters, array('nil'), NULL),
			array($parameters, array('key1', 'value2'), 'value1'),
			array($parameters, array('key2', 'value2'), 'value2'),
			array($parameters, array('nil', 'value2'), NULL),
		);
	}

	/**
	 * @param   string  $name
	 * @return  \ReflectionMethod
	 */
	private function _object_method($name)
	{
		return new \ReflectionMethod($this->object, $name);
	}

	/**
	 * Tests `__toString()` magic method return values based on the mocked results from
	 * `translate()` method call.
	 * 
	 * @dataProvider  provide_to_string
	 */
	public function test_to_string($result, $expected)
	{
		$this->object->expects($this->any())
			->method('translate')
			->will($this->_invocation_stub($result));
		$actual = (string) $this->object;
		$this->assertSame($expected, $actual);
	}

	/**
	 * @param   mixed  $parameter
	 * @return  PHPUnit_Framework_MockObject_Stub
	 */
	private function _invocation_stub($parameter)
	{
		if ($parameter instanceof \Exception)
		{
			return $this->throwException($parameter);
		}
		return $this->returnValue($parameter);
	}

	public function provide_to_string()
	{
		return array(
			array('', ''),
			array('123', '123'),
			array(new \Exception, ''),
		);
	}

	/**
	 * Tests the model implements the correct interface.
	 */
	public function test_implements_interface()
	{
		$this->assertInstanceOf(__NAMESPACE__.'\ModelInterface', $this->object);
	}

	public function setup_object()
	{
		$this->object = $this->getMock($this->class_name(), array('translate'));
	}
}
