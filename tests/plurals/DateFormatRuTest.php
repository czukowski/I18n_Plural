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
		$this->assertEquals(Date::format(time(), 'short'), date('d '.$months[date('n') - 1].' H:i'));
		$months = I18n::get('date.months.other');
		$this->assertEquals(Date::format(time(), 'long'), date($months[date('n') - 1].' d, Y H:i'));
		$this->assertEquals(Date::format(time()), date('d.m.Y H:i'));
		$this->assertEquals(Date::format(), date('d.m.Y H:i'));
	}
}