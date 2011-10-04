<?php
/**
 * Base class for some I18n_Plurals unit tests
 * 
 * @package    I18n_Plural
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Unittest_Testcase extends Kohana_Unittest_Testcase
{
	public $ref;
	public $lang;
	protected $_lang;

	public function setUp()
	{
		$this->ref = time();
		$this->_lang = I18n::lang();
		I18n::lang($this->lang);
	}

	public function tearDown()
	{
		I18n::lang($this->_lang);
	}
}