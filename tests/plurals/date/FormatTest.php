<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 * @group      plurals.date
 */
class I18n_Date_Format_Test extends I18n_Testcase
{
	/**
	 * Test common date formats are same across all languages
	 * 
	 * @dataProvider  provide_neutral_formats
	 */
	public function test_neutral_date_format($date, $unused, $lang)
	{
		$time = strtotime($date);
		I18n::lang($lang);

		// Escaped `%` sign
		$this->assertEquals('%', Date::format($date, '%%'));

		// Milliseconds (timestamp donesn't have milliseconds)
		$this->assertEquals('000', Date::format($date, '%L'));

		// Timezones and offsets
		// The GMT offset ("-08:00")
		$this->assertEquals(date('P', $time), Date::format($date, '%P'));
		// The GMT offset ("-0800")
		$this->assertEquals(date('O', $time), Date::format($date, '%z'));
		// The time zone ("GMT")
		$this->assertEquals(date('T', $time), Date::format($date, '%Z'));

		// The ordinal of the day of the month
		$this->assertEquals(date('jS', $time), Date::format($date, '%o'));

		// Timestamp
		$this->assertEquals($time, Date::format($date, '%s'));

		// The full year (four digits; "2007")
		$full_year = substr($date, 0, 4);
		$this->assertEquals($full_year, Date::format($date, '%Y'));

		// The short year (two digits; "07")
		$short_year = substr($date, 2, 2);
		$this->assertEquals($short_year, Date::format($date, '%y'));

		// The numerical month to two digits (01 is Jan, 12 is Dec)
		$month = substr($date, 5, 2);
		$this->assertEquals($month, Date::format($date, '%m'));

		// 2-digit date (01, 05, etc)
		$day_of_month = substr($date, 8, 2);
		$this->assertEquals($day_of_month, Date::format($date, '%d'));

		// Day of the month without leading zeros
		$day_of_month = (string) intval($day_of_month);
		$this->assertEquals($day_of_month, Date::format($date, '%e'));

		// The hour to two digits in military time (24 hr mode) (01, 11, 14, etc)
		$hour_24 = substr($date, 11, 2);
		$this->assertEquals($hour_24, Date::format($date, '%H'));

		// The hour (24-hour clock) as a digit (range 0 to 23).
		// Single digits are preceded by a blank space.
		$hour_24 = str_pad(intval($hour_24), 2, ' ', STR_PAD_LEFT);
		$this->assertEquals($hour_24, Date::format($date, '%k'));

		// The hour in 12 hour time (1, 11, 2, etc)
		$hour_12 = (intval($hour_24) % 12);
		// Note that for 00:xx:xx the 12hr format is 12:xx am
		$hour_12 = ($hour_12 ? (string) $hour_12 : '12');
		$this->assertEquals($hour_12, Date::format($date, '%I'));

		// The hour (12-hour clock) as a digit (range 1 to 12).
		// Single digits are preceded by a blank space.
		$hour_12 = str_pad(intval($hour_12), 2, ' ', STR_PAD_LEFT);
		$this->assertEquals($hour_12, Date::format($date, '%l'));

		// The minutes to two digits (01, 40, 59)
		$minute = substr($date, 14, 2);
		$this->assertEquals($minute, Date::format($date, '%M'));

		// The seconds to two digits (01, 40, 59)
		$second = substr($date, 17, 2);
		$this->assertEquals($second, Date::format($date, '%S'));
	}

	/**
	 * Test common date formats are same acroll all languages
	 * 
	 * @dataProvider provide_neutral_formats
	 */
	public function test_named_date_format($date, $unused, $lang)
	{
		$time = strtotime($date);
		I18n::lang($lang);

		// Named date formats
		$this->assertEquals(date('Y-m-d H:i:s', $time), Date::format($date, 'db'));
		$this->assertEquals(date('Ymd\THis', $time), Date::format($date, 'compact'));
		$this->assertEquals(gmdate('D, d M Y H:i:s \G\M\T', $time), Date::format($date, 'header'));
		$this->assertEquals(date('c', $time), Date::format($date, 'iso8601'));
		$this->assertEquals(date('r', $time), Date::format($date, 'rfc822'));
		$this->assertEquals(date('r', $time), Date::format($date, 'rfc2822'));
	}

	public function provide_neutral_formats()
	{
		return array_merge(
			$this->provide_am_pm_formats(),
			$this->provide_months_formats(),
			$this->provide_weekday_formats(),
			$this->provide_yearday_formats()
		);
	}

	/**
	 * Tests simple local AM/PM formats return the expected values
	 * 
	 * @dataProvider  provide_am_pm_formats
	 */
	public function test_local_am_pm_format($date, $abbr, $lang)
	{
		// Set language
		I18n::lang($lang);

		$this->assertEquals(___('date.'.$abbr), Date::format($date, '%p'));
	}

	public function provide_am_pm_formats()
	{
		$provide = array(
			array('2011-09-03 01:20:30', 'am'),
			array('2011-09-03 00:00:00', 'am'),
			array('2011-09-03 12:00:00', 'pm'),
			array('2011-09-03 23:59:59', 'pm'),
		);
		return $this->_combine_providers($provide, $this->provide_languages());
	}

	/**
	 * Tests simple local month formats return the expected values
	 * 
	 * @dataProvider  provide_months_formats
	 */
	public function test_local_month_format($date, $month, $lang)
	{
		// Set language
		I18n::lang($lang);

		// Short month ("Jan", "Feb")
		$months_abbr = ___('date.months', 'abbr');
		$this->assertTrue(is_array($months_abbr));
		$this->assertEquals($months_abbr[$month], Date::format($date, '%b'));

		// Full month ("January")
		$months_full = ___('date.months');
		$this->assertTrue(is_array($months_full));
		$this->assertEquals($months_full[$month], Date::format($date, '%B'));

		// Full month in the genitive case, applies to some languages, doesn't
		// affect other (e.g. 'Январь' -> 'Января')
		$months_gen = ___('date.months', 'gen');
		$this->assertTrue(is_array($months_gen));
		$this->assertEquals($months_gen[$month], Date::format($date, '%C'));
	}

	public function provide_months_formats()
	{
		$provide = array(
			// January
			array('2011-01-03 01:49:59', 0),
			// February
			array('2011-02-03 02:51:01', 1),
			// March
			array('2011-03-03 03:21:00', 2),
			// April
			array('2011-04-03 04:59:04', 3),
			// May
			array('2011-05-03 06:39:39', 4),
			// June
			array('2011-06-03 08:48:10', 5),
			// July
			array('2011-07-03 10:30:08', 6),
			// August
			array('2011-08-03 12:17:14', 7),
			// September
			array('2011-09-03 16:18:08', 8),
			// October
			array('2011-10-03 18:14:48', 9),
			// November
			array('2011-11-03 20:10:27', 10),
			// December
			array('2011-12-03 23:02:02', 11),
		);
		return $this->_combine_providers($provide, $this->provide_languages());
	}

	/**
	 * Tests simple language-neutral weekday formats return the expected values
	 * 
	 * @dataProvider  provide_weekday_formats
	 */
	public function test_neutral_weekday_format($date, $weekday, $lang)
	{
		I18n::lang($lang);

		// Test $date is on $wekday
		// The numerical day of the week, one digit (0 is Sunday, 1 is Monday)
		$this->assertEquals($weekday, Date::format($date, '%w'));

		// 3-letter, non-localized textual representation of a day (Mon, Tue)
		$time = strtotime($date);
		$this->assertEquals(date('D', $time), Date::format($date, '%D'));		
	}

	/**
	 * Tests simple local weekday formats return the expected values
	 * 
	 * @dataProvider  provide_weekday_formats
	 */
	public function test_local_weekday_format($date, $weekday, $lang)
	{
		I18n::lang($lang);

		// Short day ("Mon", "Tue")
		$days_abbr = ___('date.days', 'abbr');
		$this->assertTrue(is_array($days_abbr));
		$this->assertEquals($days_abbr[$weekday], Date::format($date, '%a'));

		// Full day ("Monday")
		$days_full = ___('date.days');
		$this->assertTrue(is_array($days_full));
		$this->assertEquals($days_full[$weekday], Date::format($date, '%A'));

		// Accusative case of week day name
		$days_acc = ___('date.days', 'acc');
		$this->assertTrue(is_array($days_acc));
		$this->assertEquals($days_acc[$weekday], Date::format($date, '%N'));
	}

	/**
	 * Provides dates with different week days
	 * 
	 * @return array
	 */
	public function provide_weekday_formats()
	{
		$provide = array(
			// Sunday
			array('2011-11-06 21:45:32', 0),
			// Monday
			array('2011-06-06 11:16:37', 1),
			// Tuesday
			array('2011-09-06 01:28:56', 2),
			// Wednesday
			array('2011-07-06 02:36:03', 3),
			// Thursday
			array('2011-10-06 22:35:49', 4),
			// Friday
			array('2011-05-06 12:50:24', 5),
			// Saturday
			array('2011-08-06 23:59:59', 6),
		);
		return $this->_combine_providers($provide, $this->provide_languages());
	}

	/**
	 * Tests simple yearday formats return the expected values
	 * 
	 * @dataProvider  provide_yearday_formats
	 */
	public function test_yearday_date_format($date, $yearday, $yearweek, $lang)
	{
		I18n::lang($lang);

		// The day of the year to three digits (001 is Jan 1st)
		$yearday = str_pad($yearday, 3, '0', STR_PAD_LEFT);
		$this->assertEquals($yearday, Date::format($date, '%j'));

		// The week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)
		$yearweek = str_pad($yearweek, 2, '0', STR_PAD_LEFT);
		$this->assertEquals($yearweek, Date::format($date, '%U'));
	}

	/**
	 * Provides dates with different year days
	 * 
	 * @return array
	 */
	public function provide_yearday_formats()
	{
		$provide = array(
			array('2010-11-09 16:48:01', 312, 45),
			array('2011-03-23 18:50:09', 81, 12),
			array('2013-02-14 23:36:11', 44, 7),
			array('2009-07-21 19:37:19', 201, 30),
			array('2011-12-31 05:26:59', 364, 52),
			array('2014-05-09 11:01:38', 128, 19),
			array('2012-01-01 06:54:41', 0, 52),
		);
		return $this->_combine_providers($provide, $this->provide_languages());
	}

	public function provide_languages()
	{
		return array(
			array('en'),
			array('pl'),
			array('ru'),
			array('cs'),
		);
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
			foreach ($array1 as $item1)
			{
				$result[] = array_merge($item1, $item2);
			}
		}
		return $result;
	}
}