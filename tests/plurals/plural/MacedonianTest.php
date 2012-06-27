<?php
/**
 * Macedonian plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n mod 10 is 1 and n is not 11;    1, 21, 31, 41, 51, 61...
 * 	other → everything else                 0, 2-20, 22-30, 32-40...; 1.31, 2.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Macedonian_Test extends I18n_PluralTestcase
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
			array(0, 'other'),
			array(2, 'other'),
			array(3, 'other'),
			array(5, 'other'),
			array(9, 'other'),
			array(11, 'other'),
			array(13, 'other'),
			array(14, 'other'),
			array(18, 'other'),
			array(19, 'other'),
			array(20, 'other'),
			array(22, 'other'),
			array(25, 'other'),
			array(30, 'other'),
			array(32, 'other'),
			array(40, 'other'),
			array(0.31, 'other'),
			array(1.31, 'other'),
			array(1.99, 'other'),
		);
	}
}
