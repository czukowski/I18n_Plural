<?php
/**
 * Breton plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n mod 10 is 1 and n mod 100 not in 11,71,91;                     1, 21, 31, 41, 51, 61...
 *  two → n mod 10 is 2 and n mod 100 not in 12,72,92;                     2, 22, 32, 42, 52, 62...
 *  few → n mod 10 in 3..4,9 and n mod 100 not in 10..19,70..79,90..99;    3, 4, 9, 23, 24, 29...
 *  many → n mod 1000000 is 0 and n is not 0;                              1000000, 2000000...
 *  other → everything else                                                0, 5-8, 10-20, 25-28...; 1.2, 2.07, 3.94, 5.81...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Breton_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(21, 'one'),
			array(31, 'one'),
			array(41, 'one'),
			array(51, 'one'),
			array(61, 'one'),
			array(2, 'two'),
			array(22, 'two'),
			array(32, 'two'),
			array(42, 'two'),
			array(52, 'two'),
			array(62, 'two'),
			array(3, 'few'),
			array(4, 'few'),
			array(9, 'few'),
			array(23, 'few'),
			array(24, 'few'),
			array(29, 'few'),
			array(43, 'few'),
			array(44, 'few'),
			array(49, 'few'),
			array(53, 'few'),
			array(54, 'few'),
			array(59, 'few'),
			array(1000000, 'many'),
			array(2000000, 'many'),
			array(0, 'other'),
			array(5, 'other'),
			array(6, 'other'),
			array(7, 'other'),
			array(8, 'other'),
			array(10, 'other'),
			array(11, 'other'),
			array(12, 'other'),
			array(13, 'other'),
			array(14, 'other'),
			array(15, 'other'),
			array(16, 'other'),
			array(17, 'other'),
			array(18, 'other'),
			array(19, 'other'),
			array(20, 'other'),
			array(25, 'other'),
			array(26, 'other'),
			array(27, 'other'),
			array(28, 'other'),
			array(73, 'other'),
			array(74, 'other'),
			array(79, 'other'),
			array(93, 'other'),
			array(94, 'other'),
			array(99, 'other'),
			array(1.2, 'other'),
			array(2.07, 'other'),
			array(3.94, 'other'),
			array(5.81, 'other'),
		);
	}
}
