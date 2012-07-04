<?php
/**
 * Maltese plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n is 1;                          1
 * 	few → n is 0 or n mod 100 in 2..10;    0, 2-10, 102-110, 202-210...
 * 	many → n mod 100 in 11..19;            11-19, 111-119, 211-219...
 * 	other → everything else                20-101, 120-201, 220-301...; 1.31, 2.31, 11.31, 20.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Maltese_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(0, 'few'),
			array(2, 'few'),
			array(3, 'few'),
			array(5, 'few'),
			array(7, 'few'),
			array(9, 'few'),
			array(10, 'few'),
			array(102, 'few'),
			array(103, 'few'),
			array(105, 'few'),
			array(107, 'few'),
			array(109, 'few'),
			array(110, 'few'),
			array(202, 'few'),
			array(203, 'few'),
			array(205, 'few'),
			array(207, 'few'),
			array(209, 'few'),
			array(210, 'few'),
			array(11, 'many'),
			array(12, 'many'),
			array(13, 'many'),
			array(14, 'many'),
			array(16, 'many'),
			array(19, 'many'),
			array(111, 'many'),
			array(112, 'many'),
			array(113, 'many'),
			array(114, 'many'),
			array(116, 'many'),
			array(119, 'many'),
			array(20, 'other'),
			array(21, 'other'),
			array(32, 'other'),
			array(43, 'other'),
			array(83, 'other'),
			array(99, 'other'),
			array(100, 'other'),
			array(101, 'other'),
			array(120, 'other'),
			array(200, 'other'),
			array(201, 'other'),
			array(220, 'other'),
			array(301, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(11.31, 'other'),
			array(20.31, 'other'),
		);
	}
}
