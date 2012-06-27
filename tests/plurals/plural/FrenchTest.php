<?php
/**
 * French plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n within 0..2 and n is not 2;    0, 1, 1.31...
 *  other → everything else                2-999; 2.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_French_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'one'),
			array(1, 'one'),
			array(1.31, 'one'),
			array(1.99, 'one'),
			array(2, 'other'),
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
			array(2.31, 'other'),
			array(5.31, 'other'),
		);
	}
}
