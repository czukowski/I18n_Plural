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
	public $lang;
	protected $_lang;

	public function setUp()
	{
		$this->_lang = I18n::lang();
		I18n::lang($this->lang);
		parent::setUp();
	}

	public function tearDown()
	{
		I18n::lang($this->_lang);
		parent::tearDown();
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