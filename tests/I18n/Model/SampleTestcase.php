<?php
/**
 * Sample Model Testcase.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;
use I18n;

class SampleTestcase extends Testcase
{
	public function setup_object()
	{
		parent::setup_object();
		$core = new I18n\Core;
		$core->attach(new I18n\Tests\DefaultReader);
		$this->object->i18n($core);
	}
}
