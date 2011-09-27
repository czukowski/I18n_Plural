<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateI18nTest extends Kohana_Unittest_Testcase
{
	public $ref;
	public $lang;

	public function  __construct()
	{
		$this->ref = time();
		parent::__construct();
	}

	public function setUp()
	{
		$this->lang = I18n::lang();
		I18n::lang('ru');
	}

	public function tearDown()
	{
		I18n::lang($this->lang);
	}

	public function testDateFormat()
	{
		$this->assertEquals(Date::format(time(), 'db'), date('Y-m-d H:i:s'));
		$this->assertEquals(Date::format(time(), 'compact'), date('Ymd\THis'));
		$this->assertEquals(Date::format(time(), 'iso8601'), date('c'));
		$this->assertEquals(Date::format(time(), 'rfc2822'), date('r'));
		$months = I18n::get('date.months_abbr');
		$this->assertEquals(Date::format(time(), 'short'), date('d '.$months[date('n') - 1].' H:i'));
		$months = I18n::get('date.months');
		$this->assertEquals(Date::format(time(), 'long'), date($months[date('n') - 1].' d, Y H:i'));
		$this->assertEquals(Date::format(time(), '%%'), '%');
		$this->assertEquals(Date::format(time()), date('d.m.Y H:i'));
		$this->assertEquals(Date::format(), date('d.m.Y H:i'));
	}

	public function testLessThanMinuteAgo()
	{
		$str = 'меньше минуты назад';
		$this->assertEquals(Date::fuzzy_span($this->ref, $this->ref), $str);		// from now
		$this->assertEquals(Date::fuzzy_span($this->ref - 45, $this->ref), $str);	// up to 45 seconds ago
	}

	public function testAboutMinuteAgo()
	{
		$str = 'минуту назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 46, $this->ref), $str);	// from 46 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 89, $this->ref), $str);	// up to 89 seconds ago
	}

	public function test2MinutesAgo()
	{
		$str = '2 минуты назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 90, $this->ref), $str);	// from 90 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 149, $this->ref), $str);	// up to 149 seconds ago
	}

	public function test3MinutesAgo()
	{
		$str = '3 минуты назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 150, $this->ref), $str);	// from 150 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 209, $this->ref), $str);	// up to 209 seconds ago
	}

	public function test4MinutesAgo()
	{
		$str = '4 минуты назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 210, $this->ref), $str);	// from 210 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 269, $this->ref), $str);	// up to 269 seconds ago
	}

	public function test45MinutesAgo()
	{
		$str = '45 минут назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 2670, $this->ref), $str);	// from 2670 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 2700, $this->ref), $str);	// up to 2700 seconds ago
	}

	public function test46MinutesAgo()
	{
		$str = 'час назад';
		$this->assertEquals(Date::fuzzy_span($this->ref - 2701, $this->ref), $str);	// from 2701 seconds ago (45 minutes + 1 second)
		$this->assertEquals(Date::fuzzy_span($this->ref - 5399, $this->ref), $str);	// up to 5399 seconds ago (90 minutes - 1 second)
	}

	public function testUntilAMinute()
	{
		$str = 'меньше чем через минуту';
		$this->assertEquals(Date::fuzzy_span($this->ref + 1, $this->ref), $str);	// from 1 second from now
		$this->assertEquals(Date::fuzzy_span($this->ref + 45, $this->ref), $str);	// up to 45 seconds from now
	}

	public function testUntilADay()
	{
		$str = 'через день';
		$this->assertEquals(Date::fuzzy_span($this->ref + 86400, $this->ref), $str);	// from 1 second from now
	}
}