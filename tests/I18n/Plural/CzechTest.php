<?php
/**
 * Czech plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n is 1;              1
 * 	few → n in 2..4;           2-4
 * 	other → everything else    0, 5-999; 1.31, 2.31, 5.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Czech_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(2, 'few'),
			array(3, 'few'),
			array(4, 'few'),
			array(0, 'other'),
			array(5, 'other'),
			array(7, 'other'),
			array(17, 'other'),
			array(28, 'other'),
			array(39, 'other'),
			array(40, 'other'),
			array(51, 'other'),
			array(63, 'other'),
			array(111, 'other'),
			array(597, 'other'),
			array(846, 'other'),
			array(999, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(5.31, 'other'),
		);
	}
}
