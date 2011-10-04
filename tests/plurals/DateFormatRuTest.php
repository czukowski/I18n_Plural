<?php
/**
 * @group i18n_plural
 * @group i18n_plural.date
 */
class DateFormatRuTest extends I18n_Unittest_Testcase
{
	public $lang = 'ru';

	public function testDateFormat()
	{
		$months = I18n::get('date.months.abbr');
		$this->assertEquals(date('d '.$months[date('n') - 1].' H:i'), Date::format(time(), 'short'));
		$months = I18n::get('date.months.other');
		$this->assertEquals(date($months[date('n') - 1].' d, Y H:i'), Date::format(time(), 'long'));
		$this->assertEquals(date('d.m.Y H:i'), Date::format(time()));
		$this->assertEquals(date('d.m.Y H:i'), Date::format());
	}
}