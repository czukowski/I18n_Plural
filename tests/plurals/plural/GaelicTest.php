<?php
/**
 * Scottish Gaelic plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n in 1,11;            1, 11
 *  two → n in 2,12;            2, 12
 *  few → n in 3..10,13..19;    3-10, 13-19
 *  other → everything else     0, 20-999; 1.2, 2.07, 3.94, 20.81...
 *  
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Gaelic_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(11, 'one'),
			array(2, 'two'),
			array(12, 'two'),
			array(3, 'few'),
			array(4, 'few'),
			array(6, 'few'),
			array(8, 'few'),
			array(10, 'few'),
			array(13, 'few'),
			array(14, 'few'),
			array(16, 'few'),
			array(18, 'few'),
			array(19, 'few'),
			array(0, 'other'),
			array(20, 'other'),
			array(31, 'other'),
			array(42, 'other'),
			array(53, 'other'),
			array(64, 'other'),
			array(75, 'other'),
			array(86, 'other'),
			array(123, 'other'),
			array(0.31, 'other'),
			array(1.2, 'other'),
			array(2.07, 'other'),
			array(3.94, 'other'),
			array(14.31, 'other'),
			array(20.81, 'other'),
			array(100.31, 'other'),
		);
	}
}