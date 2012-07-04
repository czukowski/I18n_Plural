<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
class I18n_Date_Test extends I18n_Testcase
{
	private $reference_time;

	/**
	 * Tests Date::fuzzy_span output
	 * 
	 * @dataProvider  provide_fuzzy_span
	 */
	public function test_fuzzy_span($lang, $time_diff, $expect)
	{
		\I18n::lang($lang);
		$this->assertEquals($expect, \Date::fuzzy_span($this->reference_time + $time_diff, $this->reference_time));
		$this->assertEquals($expect, \Date::fuzzy_span(time() + $time_diff));
	}

	public function provide_fuzzy_span()
	{
		return array(
			array('en', 0, 'less than a minute ago'),
			array('ru', 0, 'меньше минуты назад'),
			array('en', -45, 'less than a minute ago'),
			array('ru', -45, 'меньше минуты назад'),
			array('en', -46, 'about a minute ago'),
			array('ru', -46, 'минуту назад'),
			array('en', -89, 'about a minute ago'),
			array('ru', -89, 'минуту назад'),
			array('en', -90, '2 minutes ago'),
			array('ru', -90, '2 минуты назад'),
			array('en', -149, '2 minutes ago'),
			array('ru', -149, '2 минуты назад'),
			array('en', -150, '3 minutes ago'),
			array('ru', -150, '3 минуты назад'),
			array('en', -209, '3 minutes ago'),
			array('ru', -209, '3 минуты назад'),
			array('en', -210, '4 minutes ago'),
			array('en', -269, '4 minutes ago'),
			array('ru', -270, '5 минут назад'),
			array('ru', -329, '5 минут назад'),
			array('en', -2670, '45 minutes ago'),
			array('en', -2700, '45 minutes ago'),
			array('en', -2701, 'about an hour ago'),
			array('ru', -2701, 'час назад'),
			array('en', -5399, 'about an hour ago'),
			array('ru', -5399, 'час назад'),
			array('en', 1, 'less than a minute from now'),
			array('ru', 1, 'меньше чем через минуту'),
			array('en', 45, 'less than a minute from now'),
			array('ru', 45, 'меньше чем через минуту'),
			array('en', 86400, '1 day from now'),
		);
	}

	/**
	 * Tests Date::fuzzy_span output_from_empty
	 * 
	 * @dataProvider  provide_fuzzy_span_from_empty
	 */
	public function test_fuzzy_span_from_empty($lang, $expect)
	{
		\I18n::lang($lang);
		$this->assertEquals($expect, \Date::fuzzy_span(NULL));
	}

	public function provide_fuzzy_span_from_empty()
	{
		return array(
			array('en', 'never'),
			array('ru', 'никогда'),
		);
	}

	public function setUp()
	{
		parent::setUp();
		$this->reference_time = time();
	}
}