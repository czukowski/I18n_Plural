<?php
/**
 * Slovenian plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n mod 100 is 1;       1, 101, 201, 301, 401, 501...
 * 	two → n mod 100 is 2;       2, 102, 202, 302, 402, 502...
 * 	few → n mod 100 in 3..4;    3, 4, 103, 104, 203, 204...
 * 	other → everything else     0, 5-100, 105-200, 205-300...; 1.31, 2.31, 3.31, 5.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Slovenian_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(101, 'one'),
			array(201, 'one'),
			array(301, 'one'),
			array(401, 'one'),
			array(501, 'one'),
			array(2, 'two'),
			array(102, 'two'),
			array(202, 'two'),
			array(302, 'two'),
			array(402, 'two'),
			array(502, 'two'),
			array(3, 'few'),
			array(4, 'few'),
			array(103, 'few'),
			array(104, 'few'),
			array(203, 'few'),
			array(204, 'few'),
			array(0, 'other'),
			array(5, 'other'),
			array(6, 'other'),
			array(8, 'other'),
			array(10, 'other'),
			array(11, 'other'),
			array(29, 'other'),
			array(60, 'other'),
			array(99, 'other'),
			array(100, 'other'),
			array(105, 'other'),
			array(189, 'other'),
			array(200, 'other'),
			array(205, 'other'),
			array(300, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(3.31, 'other'),
			array(5.31, 'other'),
		);
	}
}
