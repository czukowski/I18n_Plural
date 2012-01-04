<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 * 
 * @group plurals
 */
class I18n_Validation_Test extends I18n_Unittest_Core
{
	/**
	 * @var  I18n_Validation
	 */
	protected $object;

	/**
	 * @param  array  $array   The array of data
	 * @param  array  $rules   The array of rules
	 * @param  array  $labels  The array of field labels
	 */
	protected function setup_object($array, $rules, $labels)
	{
		$this->object = new I18n_Validation($array);
		$this->object->labels($labels);
		foreach ($rules as $field => $field_rules)
		{
			$this->object->rules($field, $field_rules);
		}		
	}

	/**
	 * Tests I18n_Validation::errors()
	 *
	 * @dataProvider  provide_errors
	 * @param  array  $array     The array of data
	 * @param  array  $rules     The array of rules
	 * @param  array  $labels    The array of field labels
	 * @param  array  $expected  Array of expected errors
	 */
	public function test_errors($array, $rules, $labels, $expected)
	{
		$this->setup_object($array, $rules, $labels);
		$this->object->check();
		$this->assertSame($expected, $this->object->errors('Validation', FALSE));
		// Should be able to get raw errors array
		$this->assertAttributeSame($this->object->errors(NULL), '_errors', $this->object);
	}

	/**
	 * Provides test data for test_errors()
	 *
	 * @return  array
	 */
	public function provide_errors()
	{
		// [data, rules, labels, expected]
		return array(
			// No Error
			array(
				array('username' => 'frank'),
				array('username' => array(array('not_empty', NULL))),
				array('username' => 'Username'),
				array(),
			),
			// Error from message file
			array(
				array('username' => ''),
				array('username' => array(array('not_empty', NULL))),
				array('username' => 'Username'),
				array('username' => 'Username must not be empty'),
			),
			// Error with another field as a parameter
			array(
				array('password' => '123', 'confirm' => '456'),
				array('confirm' => array(array('matches', array(':validation', ':field', 'password')))),
				array('password' => 'Password', 'confirm' => 'Confirm'),
				array('confirm' => 'Confirm must be the same as Password'),
			),
			// Error with array field value
			array(
				array('newsletters' => array('news', 'sport', 'club')),
				array('newsletters' => array(array(array($this, 'validation_fail'), NULL))),
				array(),
				array('newsletters' => 'Validation.newsletters.validation_fail'),
			),
			// No error message exists, display the path expected
			array(
				array('username' => 'John'),
				array('username' => array(array('strpos', array(':value', 'Kohana')))),
				array(),
				array('username' => 'Validation.username.strpos'),
			),
		);
	}

	/**
	 * Tests I18n_Validation::errors()
	 *
	 * @dataProvider   provide_translated_errors
	 * @param  string  $lang                   Language
	 * @param  array   $data                   The array of data to test
	 * @param  array   $rules                  The array of rules to add
	 * @param  array   $labels                 The array of field labels
	 * @param  array   $translated_expected    The array of expected errors when translated
	 * @param  array   $untranslated_expected  The array of expected errors when not translated
	 */
	public function test_translated_errors($lang, $data, $rules, $labels, $translated_expected, $untranslated_expected)
	{
		I18n::lang($lang);
		$this->setup_object($data, $rules, $labels);
		$this->object->check();
		$result_1 = $this->object->errors('Validation', TRUE);
		$result_2 = $this->object->errors('Validation', 'en');
		$result_3 = $this->object->errors('Validation', FALSE);
		$this->assertSame($translated_expected, $result_1);
		$this->assertSame($translated_expected, $result_2);
		$this->assertSame($untranslated_expected, $result_3);
	}

	/**
	 * Provides test data for test_translated_errors()
	 *
	 * @return array
	 */
	public function provide_translated_errors()
	{
		// [lang, data, rules, expect_translated, expect_untranslated]
		return array(
			array(
				'es',
				array('Spanish' => ''),
				array('Spanish' => array(array('not_empty', NULL))),
				array('Spanish' => ''),
				// Errors are not translated yet so only the label will translate
				array('Spanish' => 'Español must not be empty'),
				array('Spanish' => 'Spanish must not be empty'),
			),
			// Error with another field as a parameter
			array(
				'cs',
				array('password' => '123', 'confirm' => '456'),
				array('confirm' => array(array('matches', array(':validation', ':field', 'password')))),
				array('password' => 'Password', 'confirm' => 'Confirm'),
				array('confirm' => 'Confirm must be the same as Password'),
				array('confirm' => 'Confirm must be the same as Password'),
			),
		);
	}

	/**
	 * This method always return FALSE
	 * 
	 * @see     ValidationTest::provide_errors()
	 * @return  boolean
	 */
	public function validation_fail()
	{
		return FALSE;
	}
}