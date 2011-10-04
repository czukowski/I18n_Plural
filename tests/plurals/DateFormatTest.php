<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateFormatTest extends I18n_Unittest_Testcase
{
	public $lang = 'en';

	public function testDateFormat()
	{
		$this->assertEquals(Date::format(time(), 'db'), date('Y-m-d H:i:s'));
		$this->assertEquals(Date::format(time(), 'compact'), date('Ymd\THis'));
		$this->assertEquals(Date::format(time(), 'iso8601'), date('c'));
		$this->assertEquals(Date::format(time(), 'rfc822'), date('r'));
		$this->assertEquals(Date::format(time(), '%%'), '%');
	}
}