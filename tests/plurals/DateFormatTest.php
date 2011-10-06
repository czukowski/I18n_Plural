<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateFormatTest extends I18n_Unittest_Testcase
{
	public $lang = 'en';

	/**
	 * Provides test data for tests
	 * 
	 * @return array
	 */
	public function provider_languages()
	{
		return array(
			array('en'),
			array('pl'),
			array('ru'),
			array('cs'),
		);
	}

	/**
	 * Tests common date formats are same acroll all languages
	 * 
	 * @test
	 * @dataProvider provider_languages
	 */
	public function test_neutral_date_format($lang)
	{
		I18n::lang($lang);

		// Named date formats
		$this->assertEquals(date('Y-m-d H:i:s'), Date::format(time(), 'db'));
		$this->assertEquals(date('Ymd\THis'), Date::format(time(), 'compact'));
		$this->assertEquals(gmdate('D, d M Y H:i:s \G\M\T'), Date::format(time(), 'header'));
		$this->assertEquals(date('c'), Date::format(time(), 'iso8601'));
		$this->assertEquals(date('r'), Date::format(time(), 'rfc822'));
		$this->assertEquals(date('r'), Date::format(time(), 'rfc2822'));

		// Escaped `%` sign
		$this->assertEquals('%', Date::format(time(), '%%'));

		// 2-digit date (01, 05, etc)
		$this->assertEquals(date('d'), Date::format(time(), '%d'));

		// 3-letter, non-localized textual representation of a day (Mon, Tue)
		$this->assertEquals(date('D'), Date::format(time(), '%D'));

		
	}

	/**
	 * Provides dates with different months
	 * 
	 * @return array
	 */
	public function provider_am_pm_dates()
	{
		$provide = array(
			array('2011-09-03 01:20:30', 'am'),
			array('2011-09-03 00:00:00', 'am'),
			array('2011-09-03 12:00:00', 'pm'),
			array('2011-09-03 23:59:59', 'pm'),
		);
		return $this->_combine_providers($provide, $this->provider_languages());
	}

	/**
	 * Tests simple local AM/PM formats return the expected values
	 * 
	 * @test
	 * @dataProvider provider_am_pm_dates
	 * @param  string   $date
	 * @param  integer  $abbr
	 * @param  string   $lang
	 */
	public function test_local_am_pm_format($date, $abbr, $lang)
	{
		// Set language
		I18n::lang($lang);

		$this->assertEquals(___('date.'.$abbr), Date::format($date, '%p'));
	}

	/**
	 * Provides dates with different months
	 * 
	 * @return array
	 */
	public function provider_months_dates()
	{
		$provide = array(
			// January
			array('2011-01-03 01:00:00', 0),
			// February
			array('2011-02-03 01:00:00', 1),
			// March
			array('2011-03-03 01:00:00', 2),
			// April
			array('2011-04-03 01:05:00', 3),
			// May
			array('2011-05-03 01:00:00', 4),
			// June
			array('2011-06-03 01:00:00', 5),
			// July
			array('2011-07-03 01:00:00', 6),
			// August
			array('2011-08-03 01:00:00', 7),
			// September
			array('2011-09-03 01:00:00', 8),
			// October
			array('2011-10-03 01:00:00', 9),
			// November
			array('2011-11-03 01:00:00', 10),
			// December
			array('2011-12-03 01:00:00', 11),
		);
		return $this->_combine_providers($provide, $this->provider_languages());
	}

	/**
	 * Tests simple local month formats return the expected values
	 * 
	 * @test
	 * @dataProvider provider_months_dates
	 * @param  string   $date
	 * @param  integer  $month
	 * @param  string   $lang
	 */
	public function test_local_month_format($date, $month, $lang)
	{
		// Set language
		I18n::lang($lang);

		// Short month ("Jan", "Feb")
		$months_abbr = I18n_Form::get('date.months', 'abbr');
		$this->assertTrue(is_array($months_abbr));
		$this->assertEquals($months_abbr[$month], Date::format($date, '%b'));

		// Full month ("January")
		$months_full = I18n_Form::get('date.months');
		$this->assertTrue(is_array($months_full));
		$this->assertEquals($months_full[$month], Date::format($date, '%B'));

		// Full month in the genitive case, applies to some languages, doesn't
		// affect other (e.g. 'Январь' -> 'Января')
		$months_gen = I18n_Form::get('date.months', 'gen');
		$this->assertTrue(is_array($months_gen));
		$this->assertEquals($months_gen[$month], Date::format($date, '%C'));
	}

	/**
	 * Provides dates with from different week days
	 * 
	 * @return array
	 */
	public function provider_weekday_dates()
	{
		$provide = array(
			// Sunday
			array('2011-11-06 01:00:00', 0),
			// Monday
			array('2011-06-06 01:00:00', 1),
			// Tuesday
			array('2011-09-06 01:00:00', 2),
			// Wednesday
			array('2011-07-06 01:00:00', 3),
			// Thursday
			array('2011-10-06 01:05:00', 4),
			// Friday
			array('2011-05-06 01:00:00', 5),
			// Saturday
			array('2011-08-06 01:00:00', 6),
		);
		return $this->_combine_providers($provide, $this->provider_languages());
	}

	/**
	 * Tests simple local weekday formats return the expected values
	 * 
	 * @test
	 * @dataProvider provider_weekday_dates
	 * @param  string   $date
	 * @param  integer  $weekday
	 * @param  string   $lang
	 */
	public function test_local_weekday_format($date, $weekday, $lang)
	{
		I18n::lang($lang);

		// Short day ("Mon", "Tue")
		$days_abbr = I18n_Form::get('date.days', 'abbr');
		$this->assertTrue(is_array($days_abbr));
		$this->assertEquals($days_abbr[$weekday], Date::format($date, '%a'));

		// Full day ("Monday")
		$days_full = I18n_Form::get('date.days');
		$this->assertTrue(is_array($days_full));
		$this->assertEquals($days_full[$weekday], Date::format($date, '%A'));

		// Accusative case of week day name
		$days_acc = I18n_Form::get('date.days', 'acc');
		$this->assertTrue(is_array($days_acc));
		$this->assertEquals($days_acc[$weekday], Date::format($date, '%N'));
	}

	/**
	 * Creates a combination from two data providers
	 * 
	 * @param   array  $array1
	 * @param   array  $array2
	 * @return  array
	 */
	protected function _combine_providers($array1, $array2)
	{
		$result = array();
		foreach ($array2 as $item2)
		{
			foreach ($array1 as $item1) {
				$result[] = array_merge($item1, $item2);
			}
		}
		return $result;
	}
}