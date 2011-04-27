<?php
/**
 * @group i18n_plural
 * @group i18n_plural.validation
 */
class ValidationTest extends Kohana_Unittest_Testcase
{
	public function setUp()
	{
		$this->lang = I18n::lang();
		I18n::lang('en-us');
	}

	public function tearDown()
	{
		I18n::lang($this->lang);
	}

	public function testValidation()
	{
		$validation = Validation::factory(array('test1' => 20, 'test2' => 'abcdefgh', 'test3' => '2356'))
			->label('test2', 'Test 2')
			->label('test3', 'Test 3')
			->rule('test1', 'not_empty')
			->rule('test2', 'max_length', array(':value', 5))
			->rule('test3', 'exact_length', array(':value', 1));
		$passed = $validation->check();
		$errors = $validation->errors('');
		$this->assertFalse($passed);
		$this->assertEquals(count($errors), 2);
		$this->assertEquals($errors['test2'], ___('valid.max_length.other', array(':field' => 'Test 2', ':param2' => 5)));
		$this->assertEquals($errors['test3'], ___('valid.exact_length.one', array(':field' => 'Test 3', ':param2' => 1)));
	}
}