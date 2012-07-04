<?php
/**
 * Colognian plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  zero → n is 0;             0
 *  one → n is 1;              1
 *  other → everything else    2-999; 0.2, 1.07, 2.94...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Colognian_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'zero'),
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
			array(0.2, 'other'),
			array(1.07, 'other'),
			array(2.94, 'other'),
		);
	}
}