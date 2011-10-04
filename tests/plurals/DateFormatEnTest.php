<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateFormatEnTest extends I18n_Unittest_Testcase
{
	public $lang = 'en';

	public function testDateFormat()
	{
		$this->assertEquals(date('d M H:i'), Date::format(time(), 'short'));
		$this->assertEquals(date('F d, Y H:i'), Date::format(time(), 'long'));
		$this->assertEquals(date('m/d/Y g:iA'), Date::format(time()));
		$this->assertEquals(date('m/d/Y g:iA'), Date::format());
	}
}