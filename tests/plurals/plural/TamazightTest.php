<?php
/**
 * Central Morocco Tamazight plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n in 0..1 or n in 11..99;    0, 1, 11-99
 *  other → everything else            	2-10, 100-999..., 1.2, 2.07...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
class I18n_Plural_Tamazight_Test extends I18n_PluralTestcase
{
	public function provide_categories()
	{
		return array(
			array(0, 'one'),
			array(1, 'one'),
			array(11, 'one'),
			array(12, 'one'),
			array(19, 'one'),
			array(20, 'one'),
			array(21, 'one'),
			array(32, 'one'),
			array(43, 'one'),
			array(54, 'one'),
			array(65, 'one'),
			array(76, 'one'),
			array(87, 'one'),
			array(98, 'one'),
			array(99, 'one'),
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
			array(1.2, 'other'),
			array(2.07, 'other'),
			array(3.31, 'other'),
			array(11.31, 'other'),
			array(100.31, 'other'),
		);
	}
}