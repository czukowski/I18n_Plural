<?php
/**
 * Test form the ___() function
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n;

class KohanaTest extends Testcase
{
	/**
	 * @dataProvider  provide_underscores
	 */
	public function test_underscores($expected, $arguments)
	{
		$function = new \ReflectionFunction('___');
		$actual = $function->invokeArgs($arguments);
		$this->assertEquals($expected, $actual);
	}

	public function provide_underscores()
	{
		// Note that the test environment doesn't have any i18n files defined, so it's not possible
		// to get any actual translations.
		return array(
			array('something :what', array('something :what')),
			array('something different', array('something :what', array(':what' => 'different'))),
			array('something different', array('something :what', array(':what' => 'different'), 'en')),
			array('something :what', array('something :what', 0)),
			array('something different', array('something :what', 0, array(':what' => 'different'))),
			array('something different', array('something :what', 0, array(':what' => 'different'), 'en')),
			array('something :what', array('something :what', 'context')),
			array('something different', array('something :what', 'context', array(':what' => 'different'))),
			array('something different', array('something :what', 'context', array(':what' => 'different'), 'en')),
		);
	}
}