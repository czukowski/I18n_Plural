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
class I18n_Validation_Test extends I18n_Testcase
{
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
		$this->_test_errors($expected);
	}

	/**
	 * Tests Kohana_Validation::errors() with the same parameters as `test_errors()`
	 * 
	 * @dataProvider  provide_errors
	 * @param  array  $array     The array of data
	 * @param  array  $rules     The array of rules
	 * @param  array  $labels    The array of field labels
	 * @param  array  $expected  Array of expected errors
	 */
	public function test_kohana_errors($array, $rules, $labels, $expected)
	{
		$this->setup_object($array, $rules, $labels, '\Kohana_Validation');
		$this->_test_errors($expected);
	}

	/**
	 * @param  array  $expected
	 */
	private function _test_errors($expected)
	{
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
	public function test_translated_errors($data, $rules, $labels, $translate, $translated_expected, $untranslated_expected)
	{
		$this->setup_object($data, $rules, $labels);
		$this->object->check();
		// 1) Set lang to $translate and use TRUE as 2nd argument (translate to current language)
		\I18n::lang($translate);
		$this->assertSame($translated_expected, $this->object->errors('Validation', TRUE));
		// 2) Set lang to non-existing and use $translate as 2nd argument (translate to specific language)
		\I18n::lang('xx-xx');
		$this->assertSame($translated_expected, $this->object->errors('Validation', $translate));
		// 3) Use FALSE as 2nd argument (do not translate)
		$this->assertSame($untranslated_expected, $this->object->errors('Validation', FALSE));
		// 4) Use 'en' as 2nd argument (translate to default language)
		$this->assertSame($untranslated_expected, $this->object->errors('Validation', 'en'));
	}

	/**
	 * Provides test data for test_translated_errors()
	 *
	 * @return array
	 */
	public function provide_translated_errors()
	{
		// [validate_array, rules, labels, translate, expected]
		return array(
			array(
				array('spanish' => ''),
				array('spanish' => array(array('not_empty', NULL))),
				array('spanish' => 'Spanish'),
				'es',
				// Errors are not translated yet so only the label will translate
				array('spanish' => 'Español must not be empty'),
				array('spanish' => 'Spanish must not be empty'),
			),
			array(
				array('password' => '123', 'confirm' => '456'),
				array('confirm' => array(array('matches', array(':validation', ':field', 'password')))),
				array('password' => 'Password', 'confirm' => 'Confirm'),
				'cs',
				// No translations exist for these labels nor message
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

	/**
	 * @dataProvider   provide_labels 
	 * @param  string  $field
	 * @param  string  $label
	 */
	public function test_label($field, $label, $translate)
	{
		$this->setup_object();
		// Set label
		$object = $this->object->label($field, $label);
		$this->assertSame($this->object, $object);
		// Get label
		$actual = $this->object->label($field, NULL, $translate);
		$this->assertEquals($label, $actual);
	}

	public function provide_labels()
	{
		return array(
			array('some-field', 'some-label', FALSE),
			array('some-field', 'some-label', TRUE),
		);
	}

	/**
	 * Sets up empty validation object
	 */
	public function setup_empty_object()
	{
		$this->object = new \I18n_Validation(array());
	}

	/**
	 * Setup validation object with mocked `_translate()` method, optionally prefilled with parameters
	 */
	public function setup_object($array = array(), $rules = array(), $labels = array(), $className = '\I18n_Validation')
	{
		$this->object = $this->getMock($className, array('_translate'), array($array));
		$this->object->expects($this->any())
			->method('_translate')
			->will($this->returnCallback(array($this, 'callback_translate')));
		$this->object->labels($labels);
		foreach ($rules as $field => $field_rules)
		{
			$this->object->rules($field, $field_rules);
		}
	}

	/**
	 * Translation mock method
	 */
	public function callback_translate($key, $context, $params, $lang)
	{
		$i18n = new \I18n_Core;
		$i18n->attach(new \Plurals\Tests\Reader);
		if ( ! is_string($lang))
		{
			$lang = \I18n::lang();
		}
		return $i18n->translate($key, $context, $params, $lang);
	}

	/**
	 * @dataProvider   provide_translations
	 * @param  string  $key
	 * @param  string  $context
	 * @param  array   $params
	 * @param  string  $lang 
	 * @param  string  $current_lang 
	 * @param  string  $expected
	 */
	public function test_translate($key, $context, $params, $lang, $current_lang, $expected)
	{
		\I18n::lang($current_lang);
		$this->setup_empty_object();
		$translate = new \ReflectionMethod($this->object, '_translate');
		$translate->setAccessible(TRUE);
		$actual = $translate->invoke($this->object, $key, $context, $params, $lang);
		$this->assertEquals($expected, $actual);
	}

	public function provide_translations()
	{
		// [key, context, params, lang, current_lang, expected]
		return array(
			array(':count files', 'one', array(), TRUE, 'cs', ':count soubor'),
			array(':count files', 'one', array(':count' => 1), 'cs', 'en', '1 soubor'),
			array(':count files', 1, array(), 'cs', 'ru', ':count soubor'),
			array(':count files', 1, array(':count' => 1), 'cs', 'pl', '1 soubor'),
		);
	}
}