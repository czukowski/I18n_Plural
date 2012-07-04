<?php
/**
 * Zero plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n in 0..1;           0, 1
 *  other → everything else    2-999; 1.31, 2.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Zero_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'one'),
			array(1, 'one'),
			array(2, 'other'),
			array(3, 'other'),
			array(4, 'other'),
			array(5, 'other'),
			array(6, 'other'),
			array(7, 'other'),
			array(9, 'other'),
			array(10, 'other'),
			array(12, 'other'),
			array(14, 'other'),
			array(19, 'other'),
			array(69, 'other'),
			array(198, 'other'),
			array(384, 'other'),
			array(999, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(8.31, 'other'),
			array(11.31, 'other'),
		);
	}
}
