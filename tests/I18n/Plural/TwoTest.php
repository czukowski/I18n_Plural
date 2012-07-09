<?php
/**
 * Two plurals test
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * 
 * Test Rules:
 *  one → n is 1;              1
 *  two → n is 2;              2
 *  other → everything else    0, 3-999; 1.31, 2.31, 3.31...
 * 
 * @group  plurals
 * @group  plurals.rules
 */
namespace I18n\Plural;

class TwoTest extends Testcase
{
	public function provide_categories()
	{
		return array(
			array(1, 'one'),
			array(2, 'two'),
			array(0, 'other'),
			array(3, 'other'),
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
