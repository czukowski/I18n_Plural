<?php
/**
 * Welsh plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  zero → n is 0;             0
 *  one → n is 1;              1
 *  two → n is 2;              2
 *  few → n is 3;              3
 *  many → n is 6;             6
 *  other → everything else    4, 5, 7, 8, 10-999; 1.31, 2.31, 8.31, 3.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Welsh_Test extends I18n_PluralTestcase
{
	public function provide_categories()
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
