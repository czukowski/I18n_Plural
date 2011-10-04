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
			array('cz'),
		);
	}

	/**
	 * Tests common date formats are same acroll all languages
	 * 
	 * @test
	 * @dataProvider provider_languages
	 */
	public function testDateFormat($lang)
	{
		I18n::lang($lang);

		$this->assertEquals(date('Y-m-d H:i:s'), Date::format(time(), 'db'));
		$this->assertEquals(date('Ymd\THis'), Date::format(time(), 'compact'));
		$this->assertEquals(gmdate('D, d M Y H:i:s \G\M\T'), Date::format(time(), 'header'));
		$this->assertEquals(date('c'), Date::format(time(), 'iso8601'));
		$this->assertEquals(date('r'), Date::format(time(), 'rfc822'));
		$this->assertEquals(date('r'), Date::format(time(), 'rfc2822'));
		$this->assertEquals('%', Date::format(time(), '%%'));
	}
}