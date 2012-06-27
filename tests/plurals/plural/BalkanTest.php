<?php
/**
 * Balkan plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n mod 10 is 1 and n mod 100 is not 11;                        1, 21, 31, 41, 51, 61...
 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14;                 2-4, 22-24, 32-34...
 * 	many → n mod 10 is 0 or n mod 10 in 5..9 or n mod 100 in 11..14;    0, 5-20, 25-30, 35-40...
 * 	other → everything else                                             1.31, 2.31, 5.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Balkan_Test extends I18n_PluralTestcase
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
			array(2, 'few'),
			array(3, 'few'),
			array(4, 'few'),
			array(22, 'few'),
			array(23, 'few'),
			array(24, 'few'),
			array(142, 'few'),
			array(143, 'few'),
			array(144, 'few'),
			array(0, 'many'),
			array(5, 'many'),
			array(6, 'many'),
			array(7, 'many'),
			array(11, 'many'),
			array(12, 'many'),
			array(15, 'many'),
			array(20, 'many'),
			array(25, 'many'),
			array(26, 'many'),
			array(28, 'many'),
			array(29, 'many'),
			array(30, 'many'),
			array(65, 'many'),
			array(66, 'many'),
			array(68, 'many'),
			array(69, 'many'),
			array(70, 'many'),
			array(112, 'many'),
			array(1112, 'many'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(5.31, 'other'),
		);
	}
}
