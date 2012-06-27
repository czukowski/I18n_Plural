<?php
/**
 * Tachelhit plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 * 	one → n within 0..1;       0, 1
 * 	few → n in 2..10;          2-10
 * 	other → everything else    11-999; 1.31, 2.31, 11.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Tachelhit_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'one'),
			array(1, 'one'),
			array(2, 'few'),
			array(3, 'few'),
			array(5, 'few'),
			array(8, 'few'),
			array(10, 'few'),
			array(11, 'other'),
			array(19, 'other'),
			array(69, 'other'),
			array(198, 'other'),
			array(384, 'other'),
			array(999, 'other'),
			array(1.31, 'other'),
			array(2.31, 'other'),
			array(11.31, 'other'),
		);
	}
}
