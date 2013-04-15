<?php
/**
 * Hebrew plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n is 1;                           1
 *  two → n is 2;                           2
 *  many → n is not 0 and n mod 10 is 0;    10, 20, 100...
 *  other → everything                      0, 3-9, 11-19, 21-29...; 1.31, 5.45...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
namespace I18n\Plural;

class HebrewTest extends Testcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array('1', 'one'),
			array(1.0, 'one'),
			array('1.0', 'one'),
			array(2, 'two'),
			array('2', 'two'),
			array(2.0, 'two'),
			array('2.0', 'two'),
			array(10, 'many'),
			array('10', 'many'),
			array(10.0, 'many'),
			array('10.0', 'many'),
			array(20, 'many'),
			array(100, 'many'),
			array(0, 'other'),
			array(3, 'other'),
			array(9, 'other'),
			array(77, 'other'),
			array(301, 'other'),
			array(999, 'other'),
			array(1.31, 'other'),
			array(5.45, 'other'),
		);
	}
}
