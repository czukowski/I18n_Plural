<?php
/**
 * Sample Model for countable objects translation using Test Reader adapter.
 * It has pre-defined translation string, expects the language to be set beforehand
 * and accepts `$count` argument.
 * 
 * The translate method arguments must be optional, in order to be compatible with base model!
 * The model's use of `translate()` method arguments should be secondary, because this alone
 * would not work if the model is casted as string!
 * 
 * Acts as a basic usage example.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class SampleCountableModel extends ModelBase
{
	/**
	 * @var  string  Pre-defined translation string.
	 */
	protected $_string = ':count countable';

	/**
	 * Translate using predefined string.
	 * 
	 * @return  string
	 */
	public function translate($count = NULL)
	{
		if ($count === NULL)
		{
			$count = $this->_parameter_default('count', 0);
		}
		return $this->i18n()
			->translate($this->_string, $count, array(':count' => $count), $this->lang());
	}
}
