<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
class I18n_Reader_Kohana_Test extends I18n_Testcase {

	public function setup() {
		parent::setup();
		$this->object = new \I18n_Reader_Kohana('i18n');
		\I18n::lang('xx');
	}

	/**
	 * @dataProvider  provide_get
	 */
	public function test_get($lang, $string, $expect)
	{
		// Pass `$lang` parameter
		$this->assertEquals($expect, $this->object->get($string, $lang));
		// Let language be determined from `I18n::$lang`
		\I18n::lang($lang);
		$this->assertEquals($expect, $this->object->get($string));
	}

	public function provide_get()
	{
		$provide = array();

		// Add the whole $item to the test data and each its plural form separately
		foreach ($this->provide_translations() as $item)
		{
			$provide[] = $item;
			list ($lang, $base_string, $plurals) = $item;
			foreach ($plurals as $plural => $translations)
			{
				$provide[] = array($lang, $base_string.'.'.$plural, $translations);
			}
		}

		// Add non-existing translation keys, the results should be the same strings
		foreach ($this->provide_non_existing() as $item)
		{
			list ($lang, $non_existing_string) = $item;
			$provide[] = array($lang, $non_existing_string, NULL);
		}

		return $provide;
	}

	public function provide_translations()
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

	public function provide_non_existing()
	{
		return array(
			array('en', 'this_1234567890_translation_QWERTY_key_UIOPASD_should_FGHJKL_not_ZXCVBNM_exist'),
			array('ru', 'этот_1234567890_ключ_ЙЦУКЕН_перевода_НГШЩЗФЫВ_не_АПРОЛД_должен_ЯЧСМИТЬ_существовать'),
		);
	}

	/**
	 * Tests translations merging using `Arr::merge()`
	 * 
	 * @dataProvider  provide_array_merge
	 */
	public function test_array_merge($array1, $array2, $expect)
	{
		// Test the `Arr::merge()` does the job for us
		$this->assertEquals($expect, \Arr::merge($array1, $array2));
	}

	public function provide_array_merge()
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
}