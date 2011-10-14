<?php
/**
 * Balkan plurals test
 *
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 * 
 * Note: for now, the rules are the same as with Welsh language, but according to the ticket
 * http://unicode.org/cldr/trac/ticket/2886 it's probably going to change
 * 
 * @group plurals
 * @group plurals.rules
 */
class I18n_Plural_Breton_Test extends I18n_Unittest_Plural
{
	/**
	 * return  array
	 */
	public function provider_counts()
	{
		return array(
			array(0, 'zero'),
			array(1, 'one'),
			array(2, 'two'),
			array(3, 'few'),
			array(6, 'many'),
			array(4, 'other'),
			array(5, 'other'),
			array(7, 'other'),
			array(8, 'other'),
			array(10, 'other'),
			array(12, 'other'),
			array(14, 'other'),
			array(19, 'other'),
			array(69, 'other'),
			array(198, 'other'),
			array(384, 'other'),
			array(999, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(8.31, 'other'),
			array(11.31, 'other'),
		);
	}
}
