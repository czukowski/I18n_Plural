<?php
/**
 * Sample Model test.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class SampleCountableModelTest extends SampleTestcase
{
	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($count, $lang, $expected)
	{
		$this->object->lang($lang);
		$actual = $this->object->translate($count);
		$this->assertSame($expected, $actual);
	}

	public function provide_translate()
	{
		// [count, lang, expected]
		return array(
			// Translate with the pre-defined string.
			array(0, 'en', '0 countables'),
			array(1, 'en', '1 countable'),
			array(2, 'en', '2 countables'),
			array(3, 'en', '3 countables'),
			array(4, 'en', '4 countables'),
			array(5, 'en', '5 countables'),
			array(100, 'en', '100 countables'),
			array(NULL, 'en', '0 countables'),
			array(0, 'cs', '0 počítatelných'),
			array(1, 'cs', '1 počítatelná'),
			array(2, 'cs', '2 počítatelné'),
			array(3, 'cs', '3 počítatelné'),
			array(4, 'cs', '4 počítatelné'),
			array(5, 'cs', '5 počítatelných'),
			array(100, 'cs', '100 počítatelných'),
			array(NULL, 'cs', '0 počítatelných'),
		);
	}
}
