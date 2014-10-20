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

class SampleFilesInDirectoriesModelTest extends SampleTestcase
{
	/**
	 * @dataProvider  provide_translate
	 */
	public function test_translate($methods, $arguments, $expected)
	{
		// Setup object state (context, lang, parameters, string).
		foreach ($methods as $name => $argument)
		{
			$method = new \ReflectionMethod($this->object, $name);
			$method->invoke($this->object, $argument);
		}
		// Test translations.
		$translate_method = new \ReflectionMethod($this->object, 'translate');
		$actual = $translate_method->invokeArgs($this->object, $arguments);
		$this->assertSame($expected, $actual);
	}

	public function provide_translate()
	{
		// [invoke methods, translate arguments, expected]
		return array(
			array(
				array('lang' => 'en', 'parameters' => array('files_count' => 1, 'directories_count' => 20)),
				array(),
				'Found 1 file in 20 directories',
			),
			array(
				array('lang' => 'en'),
				array(1, 20),
				'Found 1 file in 20 directories',
			),
			array(
				array('lang' => 'en'),
				array(1),
				'Found 1 file in 0 directories',
			),
			array(
				array('lang' => 'en', 'parameters' => array('files_count' => 3)),
				array(NULL, 5),
				'Found 3 files in 5 directories',
			),
			array(
				array('lang' => 'en', 'parameters' => array('files_count' => 3)),
				array(NULL, 5, 'cs'),
				'Byly nalezeny 3 soubory v 5 složkách',
			),
			array(
				array('lang' => 'en', 'parameters' => array('files_count' => 30)),
				array(NULL, NULL, 'cs'),
				'Bylo nalezeno 30 souborů v 0 složkách',
			),
			array(
				array('parameters' => array('files_count' => 30)),
				array(NULL, NULL, 'ru'),
				'Найдено 30 файлов в 0 папках',
			),
			array(
				array('lang' => 'ru'),
				array(NULL, NULL),
				'Найдено 0 файлов в 0 папках',
			),
		);
	}
}
