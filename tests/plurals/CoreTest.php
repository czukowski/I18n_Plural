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
class I18n_Core_Test extends Kohana_Unittest_Testcase
{
	/**
	 * @return  array
	 */
	public function provider_translations()
	{
		return array(
			array('cs', ':count files', array(
				'one' => ':count soubor',
				'few' => ':count soubory',
				'other' => ':count souborů',
			)),
			array('en', ':count files', array(
				'one' => ':count file',
				'other' => ':count files',
			)),
			array('pl', ':count files', array(
				'one' => ':count plik',
				'few' => ':count pliki',
				'other' => ':count plików',
			)),
			array('ru', ':count files', array(
				'one' => ':count файл',
				'few' => ':count файла',
				'many' => ':count файлов',
				'other' => ':count файла',
			)),
			array('en', 'date.time', array(
				'long' => '%H:%M:%S',
				'short' => '%I:%M%p',
			)),
		);
	}

	/**
	 * @return  array
	 */
	public function provider_non_existing()
	{
		return array(
			array('en', 'this_1234567890_translation_QWERTY_key_UIOPASD_should_FGHJKL_not_ZXCVBNM_exist'),
			array('ru', 'этот_1234567890_ключ_ЙЦУКЕН_перевода_НГШЩЗФЫВ_не_АПРОЛД_должен_ЯЧСМИТЬ_существовать'),
		);
	}

	/**
	 * @return  array
	 */
	public function provider_get()
	{
		$provide = array();

		// Add the whole $item to the test data and each its plural form separately
		foreach ($this->provider_translations() as $item)
		{
			$provide[] = $item;
			list ($lang, $base_string, $plurals) = $item;
			foreach ($plurals as $plural => $translations)
			{
				$provide[] = array($lang, $base_string.'.'.$plural, $translations);
			}
		}

		// Add non-existing translation keys, the results should be the same strings
		foreach ($this->provider_non_existing() as $item)
		{
			list ($lang, $non_existing_string) = $item;
			$provide[] = array($lang, $non_existing_string, $non_existing_string);
		}

		return $provide;
	}

	/**
	 * Test `I18n_Core::get()`
	 * 
	 * @dataProvider   provider_get
	 * @param  string  $lang
	 * @param  string  $string
	 * @param  string  $expect
	 * @param  array   $parameters
	 */
	public function test_get($lang, $string, $expect, $parameters = array())
	{
		// Pass `$lang` parameter
		$this->assertEquals($expect, I18n_Core::get($string, $lang));
		// Let language be determined from `I18n::$lang`
		I18n::lang($lang);
		$this->assertEquals($expect, I18n_Core::get($string));
		// Test using `___()` function
		// Array `$expect` is invalid use case for `___()` function, but valid for `I18n_Core::get()`
		if ( ! is_array($expect))
		{
			$this->assertEquals(strtr($expect, $parameters), ___($string, $parameters));
		}
	}

	/**
	 * Provides test data for `I18n_Core::form()` test
	 * 
	 * @return  array
	 */
	public function provider_form()
	{
		$provide = array();

		foreach ($this->provider_translations() as $item)
		{
			// Add each plural form separately
			list ($lang, $base_string, $plurals) = $item;
			foreach ($plurals as $plural => $translations)
			{
				$provide[] = array($lang, $base_string, $plural, $translations);
			}
			// Add data sets to test non-existing keys handling
			if (array_key_exists('other', $plurals))
			{
				// For translations with the 'other' key, it should be returned when requested for
				// non-existing key
				$provide[] = array($lang, $base_string, 'this-key-makes-no-sense', $plurals['other']);
			}
			else
			{
				// For translations without the 'other' key, the first key should be returned
				reset($plurals);
				$provide[] = array($lang, $base_string, 'this-key-makes-no-sense', current($plurals));
			}
		}

		// Add non-existing translation keys, the results should be the same strings
		foreach ($this->provider_non_existing() as $item)
		{
			list ($lang, $non_existing_string) = $item;
			$provide[] = array($lang, $non_existing_string, 'anything', $non_existing_string);
		}

		return $provide;
	}

	/**
	 * Test `I18n_Core::form()`
	 * 
	 * @dataProvider   provider_form
	 * @param  string  $lang
	 * @param  string  $string
	 * @param  string  $form
	 * @param  string  $expect
	 * @param  array   $parameters
	 */
	public function test_form($lang, $string, $form, $expect, $parameters = array())
	{
		// Pass `$lang` parameter
		$this->assertEquals($expect, I18n_Core::form($string, $form, $lang));
		// Let language be determined from `I18n::$lang`
		I18n::lang($lang);
		$this->assertEquals($expect, I18n_Core::form($string, $form));
		// Test using `___()` function
		$this->assertEquals(strtr($expect, $parameters), ___($string, $form, $parameters));
	}

	/**
	 * Provides test data for I18n_Core::plural() test
	 * 
	 * @return  array
	 */
	public function provider_plural()
	{
		return array(
			array('en-us', ':count files', 1, ':count file', array(':count' => 1)),
			array('en-us', ':count files', 10, ':count files', array(':count' => 10)),
			array('cs', ':count files', 1, ':count soubor', array(':count' => 1)),
			array('cs', ':count files', 2, ':count soubory', array(':count' => 2)),
			array('cs', ':count files', 10, ':count souborů', array(':count' => 10)),
			array('ru', ':count files', 1, ':count файл', array(':count' => 1)),
			array('ru', ':count files', 2, ':count файла', array(':count' => 2)),
			array('ru', ':count files', 10, ':count файлов', array(':count' => 10)),
			array('ru', ':count files', 12, ':count файлов', array(':count' => 12)),
			array('ru', ':count files', 112, ':count файлов', array(':count' => 112)),
			array('ru', ':count files', 122, ':count файла', array(':count' => 122)),
			array('ru', ':count files', 1.46, ':count файла', array(':count' => 1.46)),
		);
	}

	/**
	 * Test `I18n::plural()` and `___()`
	 * 
	 * @dataProvider   provider_plural
	 * @param  string  $lang
	 * @param  string  $string
	 * @param  mixed   $count
	 * @param  mixed   $key
	 * @param  string  $expect
	 * @param  array   $parameters
	 */
	public function test_plural($lang, $string, $count, $expect, $parameters = array())
	{
		// Pass `$lang` parameter
		$this->assertEquals($expect, I18n_Core::plural($string, $count, $lang));
		// Let language be determined from `I18n::$lang`
		I18n::lang($lang);
		$this->assertEquals($expect, I18n_Core::plural($string, $count));
		// Test using `___()` function
		$this->assertEquals(strtr($expect, $parameters), ___($string, $count, $parameters));
	}

	/**
	 * @return  array
	 */
	public function provider_array_merge()
	{
		return array(
			// Simple example
			array(
				array('one' => array('ein' => 'NULL')),
				array('two' => array('zwei' => 'NULL')),
				array('one' => array('ein' => 'NULL'), 'two' => array('zwei' => 'NULL')),
			),
			// Example of simple overwriting scalar value with scalar value
			array(
				array('one' => array('ein' => 'NULL'), 'two' => array('zwei' => 'NULL')),
				array('two' => array('zwei' => 'TRUE')),
				array('one' => array('ein' => 'NULL'), 'two' => array('zwei' => 'TRUE')),
			),
			// Example of overwriting array with scalar value
			array(
				array('one' => array('ein' => 'NULL'), 'two' => array('zwei' => 'NULL')),
				array('two' => 'zwei'),
				array('one' => array('ein' => 'NULL'), 'two' => 'zwei'),
			),
			// Example of overwriting scalar value with array
			array(
				array('one' => array('ein' => 'NULL'), 'two' => 'zwei'),
				array('two' => array('zwei' => 'NULL')),
				array('one' => array('ein' => 'NULL'), 'two' => array('zwei' => 'NULL')),
			),
		);
	}

	/**
	 * Tests translations merging
	 * 
	 * @dataProvider  provider_array_merge
	 * @param  array  $array1
	 * @param  array  $array2
	 * @param  array  $expect
	 */
	public function test_array_merge($array1, $array2, $expect)
	{
		// Test the `Arr::merge()` does the job for us
		$this->assertEquals($expect, Arr::merge($array1, $array2));
	}
}