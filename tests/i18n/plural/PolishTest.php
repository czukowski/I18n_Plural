<?php
/**
 * Polish plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n is 1;                                                                      1
 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14 and n mod 100 not in 22..24;    2-4, 22-24, 32-34...
 * 	other → everything else                                                            0, 5-21, 25-31, 35-41...; 1.31, 2.31, 5.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Polish_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(2, 'few'),
			array(3, 'few'),
			array(4, 'few'),
			array(32, 'few'),
			array(33, 'few'),
			array(34, 'few'),
			array(102, 'few'),
			array(103, 'few'),
			array(104, 'few'),
			array(0, 'other'),
			array(5, 'other'),
			array(6, 'other'),
			array(10, 'other'),
			array(12, 'other'),
			array(15, 'other'),
			array(20, 'other'),
			array(21, 'other'),
			array(22, 'other'),
			array(23, 'other'),
			array(24, 'other'),
			array(25, 'other'),
			array(30, 'other'),
			array(31, 'other'),
			array(47, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(5.31, 'other'),
		);
	}
}
