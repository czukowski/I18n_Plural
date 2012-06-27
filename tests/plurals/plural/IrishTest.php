<?php
/**
 * Irish plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n is 1;              1
 *  two → n is 2;              2
 *  few → n in 3..6;           3-6
 *  many → n in 7..10;         7-10
 *  other → everything else    0, 11-999; 1.2, 2.07, 3.94, 7.81, 11.68...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Irish_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(2, 'two'),
			array(3, 'few'),
			array(4, 'few'),
			array(5, 'few'),
			array(6, 'few'),
			array(7, 'many'),
			array(8, 'many'),
			array(9, 'many'),
			array(10, 'many'),
			array(0, 'other'),
			array(11, 'other'),
			array(77, 'other'),
			array(301, 'other'),
			array(999, 'other'),
			array(1.2, 'other'),
			array(2.07, 'other'),
			array(3.94, 'other'),
			array(7.81, 'other'),
			array(11.68, 'other'),
		);
	}
}
