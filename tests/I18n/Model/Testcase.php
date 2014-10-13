<?php
/**
 * Model Testcase.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;
use I18n;

class Testcase extends I18n\Testcase
{
	public function setUp()
	{
		parent::setUp();
		$this->setup_object();
	}

	/**
	 * @param  mixed  $expected
	 */
	protected function _set_expected_exception($expected)
	{
		if ($expected instanceof \Exception)
		{
			$this->setExpectedException(get_class($expected));
		}
	}
}
