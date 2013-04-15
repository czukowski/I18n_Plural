<?php
/**
 * Integer rule test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 * 
 * @group  plurals
 * @group  plurals.rules
 */
namespace I18n\Plural;

class IntegerRuleTest extends \I18n\Testcase
{
	private $is_int;

	/**
	 * @dataProvider  provide_is_int
	 */
	public function test_is_int($value, $expected)
	{
		$actual = $this->is_int->invoke($this->object, $value);
		$this->assertSame($expected, $actual);
	}

	public function provide_is_int()
	{
		return array(
			'integer 0' => array(0, TRUE),
			'integer 1' => array(1, TRUE),
			'float 1.0' => array(1.0, TRUE),
			'string 1' => array('1', TRUE),
			'string 1.0' => array('1.0', TRUE),
			'float 1.1' => array(1.1, FALSE),
			'string 1.1' => array('1.1', FALSE),
			'string z' => array('z', FALSE),
		);
	}

	public function setUp()
	{
		parent::setUp();
		$this->object = $this->getMock($this->class_name(), array('plural_category'));
		$this->is_int = new \ReflectionMethod($this->object, 'is_int');
		$this->is_int->setAccessible(TRUE);
	}
}