<?php
/**
 * Sample Model for person gender translation using Test Reader adapter.
 * 
 * Acts as a very basic usage example.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class SamplePersonModel extends ModelBase
{
	/**
	 * @return  string
	 */
	public function translate()
	{
		$person = $this->context();
		return $this->i18n()
			->translate(':title person', $person->title, array(':title' => $person->title), $this->lang());
	}
}
