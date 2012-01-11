<?php
/**
 * Base class for some unit tests
 * 
 * @package    I18n_Plural
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Unittest_Core extends Kohana_Unittest_Testcase
{
	protected $lang_backup;

	public function setUp()
	{
		$this->backup_lang();
		parent::setUp();
	}

	public function tearDown()
	{
		$this->restore_lang();
		parent::tearDown();
	}

	protected function backup_lang()
	{
		$this->lang_backup = I18n::lang();
	}

	protected function restore_lang()
	{
		I18n::lang($this->lang_backup);
	}

	/**
	 * Provides test data for tests
	 */
	public function provider_languages()
	{
		return array(
			array('en'),
			array('pl'),
			array('ru'),
			array('cs'),
		);
	}

	/**
	 * Creates a combination from two data providers
	 * 
	 * @param   array  $array1
	 * @param   array  $array2
	 * @return  array
	 */
	protected function _combine_providers($array1, $array2)
	{
		$result = array();
		foreach ($array2 as $item2)
		{
			foreach ($array1 as $item1)
			{
				$result[] = array_merge($item1, $item2);
			}
		}
		return $result;
	}
}