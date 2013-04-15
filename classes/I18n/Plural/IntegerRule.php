<?php
/**
 * Common base for the plural rules with integer test.
 *
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;

abstract class IntegerRule implements PluralInterface
{
	/**
	 * Returns TRUE if the value has only integer part and no decimal digits, regardless
	 * of the actual type.
	 * 
	 * @param   mixed    $value
	 * @return  boolean
	 */
	protected function is_int($value)
	{
		return is_numeric($value) AND $value - intval($value) == 0;
	}
}