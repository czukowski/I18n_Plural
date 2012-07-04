<?php
/**
 * Romanian plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n is 1;                                         1
 * 	few → n is 0 OR n is not 1 AND n mod 100 in 1..19;    0, 2-19, 101-119, 201-219...
 * 	other → everything else                               20-100, 120-200, 220-300...; 1.31, 2.31, 20.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Romanian_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(0, 'few'),
			array(2, 'few'),
			array(3, 'few'),
			array(5, 'few'),
			array(9, 'few'),
			array(10, 'few'),
			array(15, 'few'),
			array(18, 'few'),
			array(19, 'few'),
			array(101, 'few'),
			array(109, 'few'),
			array(110, 'few'),
			array(111, 'few'),
			array(117, 'few'),
			array(119, 'few'),
			array(201, 'few'),
			array(209, 'few'),
			array(210, 'few'),
			array(211, 'few'),
			array(217, 'few'),
			array(219, 'few'),
			array(20, 'other'),
			array(23, 'other'),
			array(35, 'other'),
			array(89, 'other'),
			array(99, 'other'),
			array(100, 'other'),
			array(120, 'other'),
			array(121, 'other'),
			array(200, 'other'),
			array(220, 'other'),
			array(300, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(20.31, 'other'),
		);
	}
}
