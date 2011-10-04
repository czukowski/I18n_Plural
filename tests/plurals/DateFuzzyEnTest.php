<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateFuzzyEnTest extends I18n_Unittest_Testcase
{
	public $lang = 'en';

	public function testLessThanMinuteAgo()
	{
		$str = 'less than a minute ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref, $this->ref));		// from now
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 45, $this->ref));	// up to 45 seconds ago
	}

	public function testAboutMinuteAgo()
	{
		$str = 'about a minute ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 46, $this->ref));	// from 46 seconds ago
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 89, $this->ref));	// up to 89 seconds ago
	}

	public function test2MinutesAgo()
	{
		$str = '2 minutes ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 90, $this->ref));	// from 90 seconds ago
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 149, $this->ref));	// up to 149 seconds ago
	}

	public function test3MinutesAgo()
	{
		$str = '3 minutes ago';
		$this->assertEquals(Date::fuzzy_span($this->ref - 150, $this->ref));	// from 150 seconds ago
		$this->assertEquals(Date::fuzzy_span($this->ref - 209, $this->ref));	// up to 209 seconds ago
	}

	public function test4MinutesAgo()
	{
		$str = '4 minutes ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 210, $this->ref));	// from 210 seconds ago
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 269, $this->ref));	// up to 269 seconds ago
	}

	public function test45MinutesAgo()
	{
		$str = '45 minutes ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 2670, $this->ref));	// from 2670 seconds ago
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 2700, $this->ref));	// up to 2700 seconds ago
	}

	public function test46MinutesAgo()
	{
		$str = 'about an hour ago';
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 2701, $this->ref));	// from 2701 seconds ago (45 minutes + 1 second)
		$this->assertEquals($str, Date::fuzzy_span($this->ref - 5399, $this->ref));	// up to 5399 seconds ago (90 minutes - 1 second)
	}

	public function testUntilAMinute()
	{
		$str = 'less than a minute from now';
		$this->assertEquals($str, Date::fuzzy_span($this->ref + 1, $this->ref));	// from 1 second from now
		$this->assertEquals($str, Date::fuzzy_span($this->ref + 45, $this->ref));	// up to 45 seconds from now
	}

	public function testUntilADay()
	{
		$str = '1 day from now';
		$this->assertEquals($str, Date::fuzzy_span($this->ref + 86400, $this->ref));	// from 1 second from now
	}
}