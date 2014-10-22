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

class SamplePersonModelTest extends SampleTestcase
{
	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($person, $lang, $expected)
	{
		$actual = $this->object->lang($lang)
			->context($person)
			->translate();
		$this->assertSame($expected, $actual);
	}

	public function provide_translate()
	{
		// [person, lang, expected]
		return array(
			array($this->_create_person_object('mr'), 'en', 'mr man'),
			array($this->_create_person_object('ms'), 'en', 'ms woman'),
			array($this->_create_person_object('some'), 'en', 'some person'),
			array($this->_create_person_object('mr'), 'cs', 'mr muž'),
			array($this->_create_person_object('ms'), 'cs', 'ms žena'),
			array($this->_create_person_object('some'), 'cs', 'some člověk'),
		);
	}

	private function _create_person_object($title)
	{
		$person = new \stdClass;
		$person->title = $title;
		return $person;
	}
}
