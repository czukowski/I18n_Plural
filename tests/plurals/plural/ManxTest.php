<?php
/**
 * Manx plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n mod 10 in 1..2 or n mod 20 is 0;    0-2, 11, 12, 20-22...
 * 	other → everything else                     3-10, 13-19, 23-30..., 1.2, 3.07...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Manx_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'one'),
			array(1, 'one'),
			array(2, 'one'),
			array(11, 'one'),
			array(12, 'one'),
			array(20, 'one'),
			array(21, 'one'),
			array(22, 'one'),
			array(3, 'other'),
			array(4, 'other'),
			array(5, 'other'),
			array(6, 'other'),
			array(7, 'other'),
			array(8, 'other'),
			array(9, 'other'),
			array(10, 'other'),
			array(13, 'other'),
			array(14, 'other'),
			array(15, 'other'),
			array(16, 'other'),
			array(17, 'other'),
			array(18, 'other'),
			array(19, 'other'),
			array(23, 'other'),
			array(25, 'other'),
			array(29, 'other'),
			array(30, 'other'),
			array(0.31, 'other'),
			array(1.2, 'other'),
			array(2.07, 'other'),
			array(3.31, 'other'),
			array(11.31, 'other'),
			array(21.11, 'other'),
			array(100.31, 'other'),
		);
	}
}