<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateTest extends Kohana_Unittest_Testcase
{
	public $ref;

	public function  __construct()
	{
		$this->ref = time();
		parent::__construct();
	}

	public function setUp()
	{
		$this->lang = I18n::lang();
		I18n::lang('en-us');
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
		$this->assertEquals(Date::format(time(), 'rfc822'), date('r'));
		$this->assertEquals(Date::format(time(), 'short'), date('d M H:i'));
		$this->assertEquals(Date::format(time(), 'long'), date('F d, Y H:i'));
		$this->assertEquals(Date::format(time(), '%%'), '%');
		$this->assertEquals(Date::format(time()), date('m/d/Y g:iA'));
		$this->assertEquals(Date::format(), date('m/d/Y g:iA'));
	}

	public function testLessThanMinuteAgo()
	{
		$str = 'less than a minute ago';
		$this->assertEquals(Date::fuzzy_span($this->ref, $this->ref), $str);		// from now
		$this->assertEquals(Date::fuzzy_span($this->ref - 45, $this->ref), $str);	// up to 45 seconds ago
	}

	public function testAboutMinuteAgo()
	{
		$str = 'about a minute ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 46, $this->ref), $str);	// from 46 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 89, $this->ref), $str);	// up to 89 seconds ago
	}

	public function test2MinutesAgo()
	{
		$str = '2 minutes ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 90, $this->ref), $str);	// from 90 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 149, $this->ref), $str);	// up to 149 seconds ago
	}

	public function test3MinutesAgo()
	{
		$str = '3 minutes ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 150, $this->ref), $str);	// from 150 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 209, $this->ref), $str);	// up to 209 seconds ago
	}

	public function test4MinutesAgo()
	{
		$str = '4 minutes ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 210, $this->ref), $str);	// from 210 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 269, $this->ref), $str);	// up to 269 seconds ago
	}

	public function test45MinutesAgo()
	{
		$str = '45 minutes ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 2670, $this->ref), $str);	// from 2670 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 2700, $this->ref), $str);	// up to 2700 seconds ago
	}

	public function test46MinutesAgo()
	{
		$str = 'about an hour ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 2701, $this->ref), $str);	// from 2701 seconds ago (45 minutes + 1 second)
		$this->assertEquals(Date::fuzzy_span($this->ref - 5399, $this->ref), $str);	// up to 5399 seconds ago (90 minutes - 1 second)
	}

	public function testUntilAMinute()
	{
		$str = 'less than a minute from now';
		$this->assertEquals(Date::fuzzy_span($this->ref + 1, $this->ref), $str);	// from 1 second from now
		$this->assertEquals(Date::fuzzy_span($this->ref + 45, $this->ref), $str);	// up to 45 seconds from now
	}

	public function testUntilADay()
	{
		$str = '1 day from now';
		$this->assertEquals(Date::fuzzy_span($this->ref + 86400, $this->ref), $str);	// from 1 second from now
	}
}