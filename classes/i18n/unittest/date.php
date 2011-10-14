<?php
/**
 * Base class for some I18n_Date unit tests
 * 
 * @package    I18n_Plural
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Unittest_Date extends I18n_Unittest_Core
{
	public $ref;

	public function setUp()
	{
		$this->ref = time();
		parent::setUp();
	}
}