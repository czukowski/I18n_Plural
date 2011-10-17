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
	public function provider_get()
	{
		$provide = array();
		$existing_translations = array(
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
		);
		$non_existing_translations = array(
			array('en', 'this_1234567890_translation_QWERTY_key_UIOPASD_should_FGHJKL_not_ZXCVBNM_exist'),
			array('ru', 'этот_1234567890_ключ_ЙЦУКЕН_перевода_НГШЩЗФЫВ_не_АПРОЛД_должен_ЯЧСМИТЬ_существовать'),
		);

		// Add the whole $item to the test data and each its plural form separately
		foreach ($existing_translations as $item)
		{
			$provide[] = $item;
			list ($lang, $base_string, $plurals) = $item;
			foreach ($plurals as $plural => $translations)
			{
				$provide[] = array($lang, $base_string.'.'.$plural, $translations);
			}
		}

		// Add non-existing translation keys, the results should be the same strings
		foreach ($non_existing_translations as $item)
		{
			list ($lang, $non_existing_string) = $item;
			$provide[] = array($lang, $non_existing_string, $non_existing_string);
		}

		return $provide;
	}

	/**
	 * Test I18n_Core::get()
	 * 
	 * @dataProvider   provider_get
	 * @param  string  $lang
	 * @param  string  $string
	 * @param  string  $expect
	 */
	public function test_get($lang, $string, $expect)
	{
		// Pass $lang parameter
		$this->assertEquals($expect, I18n_Core::get($string, $lang));
		// Let language be determined from I18n::$lang
		I18n::lang($lang);
		$this->assertEquals($expect, I18n_Core::get($string));
	}
}