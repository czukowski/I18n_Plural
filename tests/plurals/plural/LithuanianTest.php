<?php
/**
 * Lithuanian plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n mod 10 is 1 and n mod 100 not in 11..19;       1, 21, 31, 41, 51, 61...
 * 	few → n mod 10 in 2..9 and n mod 100 not in 11..19;    2-9, 22-29, 32-39...
 * 	other → everything else                                0, 10-20, 30, 40, 50...; 1.31, 2.31, 10.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Lithuanian_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(21, 'one'),
			array(31, 'one'),
			array(41, 'one'),
			array(51, 'one'),
			array(101, 'one'),
			array(2, 'few'),
			array(3, 'few'),
			array(5, 'few'),
			array(7, 'few'),
			array(9, 'few'),
			array(22, 'few'),
			array(23, 'few'),
			array(25, 'few'),
			array(27, 'few'),
			array(29, 'few'),
			array(32, 'few'),
			array(33, 'few'),
			array(35, 'few'),
			array(37, 'few'),
			array(39, 'few'),
			array(0, 'other'),
			array(10, 'other'),
			array(11, 'other'),
			array(12, 'other'),
			array(13, 'other'),
			array(15, 'other'),
			array(18, 'other'),
			array(20, 'other'),
			array(30, 'other'),
			array(40, 'other'),
			array(50, 'other'),
			array(0.31, 'other'),
			array(1.31, 'other'),
			array(1.99, 'other'),
		);
	}
}
