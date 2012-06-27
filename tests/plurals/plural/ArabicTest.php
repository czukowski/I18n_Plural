<?php
/**
 * Arabic plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	zero → n is 0;                 0
 * 	one → n is 1;                  1
 * 	two → n is 2;                  2
 * 	few → n mod 100 in 3..10;      3-10, 103-110, 203-210...
 * 	many → n mod 100 in 11..99;    11-99, 111-199, 211-299...
 * 	other → everything else        100-102, 200-202, 300-302...; 0.31, 1.31, 2.31, 3.31, 11.31, 100.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Arabic_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'zero'),
			array(1, 'one'),
			array(2, 'two'),
			array(3, 'few'),
			array(4, 'few'),
			array(6, 'few'),
			array(8, 'few'),
			array(10, 'few'),
			array(103, 'few'),
			array(104, 'few'),
			array(106, 'few'),
			array(108, 'few'),
			array(110, 'few'),
			array(203, 'few'),
			array(204, 'few'),
			array(206, 'few'),
			array(208, 'few'),
			array(210, 'few'),
			array(11, 'many'),
			array(15, 'many'),
			array(25, 'many'),
			array(36, 'many'),
			array(47, 'many'),
			array(58, 'many'),
			array(69, 'many'),
			array(71, 'many'),
			array(82, 'many'),
			array(93, 'many'),
			array(99, 'many'),
			array(111, 'many'),
			array(115, 'many'),
			array(125, 'many'),
			array(136, 'many'),
			array(147, 'many'),
			array(158, 'many'),
			array(169, 'many'),
			array(171, 'many'),
			array(182, 'many'),
			array(193, 'many'),
			array(199, 'many'),
			array(211, 'many'),
			array(215, 'many'),
			array(225, 'many'),
			array(236, 'many'),
			array(247, 'many'),
			array(258, 'many'),
			array(269, 'many'),
			array(271, 'many'),
			array(282, 'many'),
			array(293, 'many'),
			array(299, 'many'),
			array(100, 'other'),
			array(101, 'other'),
			array(102, 'other'),
			array(200, 'other'),
			array(201, 'other'),
			array(202, 'other'),
			array(300, 'other'),
			array(301, 'other'),
			array(302, 'other'),
			array(0.31, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(3.31, 'other'),
			array(11.31, 'other'),
			array(100.31, 'other'),
		);
	}
}
