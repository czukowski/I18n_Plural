<?php
/**
 * @group i18n_plural
 * @group i18n_plural.plural
 */
class PluralTest extends Kohana_Unittest_Testcase
{
	/**
	 * Test translations
	 */
	public function testTranslations()
	{
		I18n::lang('en-us');
		$this->assertEquals(___(':count files', 1, array(':count' => 1)), '1 file');
		$this->assertEquals(___(':count files', 10, array(':count' => 10)), '10 files');

		I18n::lang('cs');
		$this->assertEquals(___(':count files', 1, array(':count' => 1)), '1 soubor');
		$this->assertEquals(___(':count files', 2, array(':count' => 2)), '2 soubory');
		$this->assertEquals(___(':count files', 10, array(':count' => 10)), '10 souborů');

		I18n::lang('ru');
		$this->assertEquals(___(':count files', 1, array(':count' => 1)), '1 файл');
		$this->assertEquals(___(':count files', 2, array(':count' => 2)), '2 файла');
		$this->assertEquals(___(':count files', 10, array(':count' => 10)), '10 файлов');
		$this->assertEquals(___(':count files', 12, array(':count' => 12)), '12 файлов');
		$this->assertEquals(___(':count files', 112, array(':count' => 112)), '112 файлов');
		$this->assertEquals(___(':count files', 122, array(':count' => 122)), '122 файла');
		$this->assertEquals(___(':count files', 1.46, array(':count' => 1.46)), '1.46 файла');

		I18n::lang('en');
	}

	/**
	 * Rules:
	 *  one → n in 0..1;			0, 1
	 *  other → everything else		2-999; 1.31, 2.31...
	 */
	public function testZero()
	{
		$t = $this->_get_instance('ak');

		$this->assertEquals($t->get_category(0), 'one');
		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(2), 'other');
		$this->assertEquals($t->get_category(3), 'other');
		$this->assertEquals($t->get_category(4), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(6), 'other');
		$this->assertEquals($t->get_category(7), 'other');
		$this->assertEquals($t->get_category(9), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(12), 'other');
		$this->assertEquals($t->get_category(14), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(69), 'other');
		$this->assertEquals($t->get_category(198), 'other');
		$this->assertEquals($t->get_category(384), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(8.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
	}

	/**
	 * Rules:
	 *  zero → n is 0;					0
	 *  one → n is 1;					1
	 *  two → n is 2;					2
	 *  few → n is 3;					3
	 *  many → n is 6;					6
	 *  other → everything else			4, 5, 7, 8, 10-999; 1.31, 2.31, 8.31, 3.31...
	 */
	public function testWelsh()
	{
		$t = $this->_get_instance('cy');

		$this->assertEquals($t->get_category(0), 'zero');
		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(2), 'two');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(6), 'many');

		$this->assertEquals($t->get_category(4), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(7), 'other');
		$this->assertEquals($t->get_category(8), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(12), 'other');
		$this->assertEquals($t->get_category(14), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(69), 'other');
		$this->assertEquals($t->get_category(198), 'other');
		$this->assertEquals($t->get_category(384), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(8.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
	}

	/**
	 * Rules:
	 *  one → n is 1;				1
	 *  two → n is 2;				2
	 *  other → everything else		0, 3-999; 1.31, 2.31, 3.31...
	 */
	public function testTwo()
	{
		$t = $this->_get_instance('ga');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(2), 'two');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(3), 'other');
		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(69), 'other');
		$this->assertEquals($t->get_category(198), 'other');
		$this->assertEquals($t->get_category(384), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n within 0..1;		0, 1
	 * 	few → n in 2..10;			2-10
	 * 	other → everything else		11-999; 1.31, 2.31, 11.31...
	 */
	public function testTachelhit()
	{
		$t = $this->_get_instance('shi');

		$this->assertEquals($t->get_category(0), 'one');
		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(5), 'few');
		$this->assertEquals($t->get_category(8), 'few');
		$this->assertEquals($t->get_category(10), 'few');

		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(69), 'other');
		$this->assertEquals($t->get_category(198), 'other');
		$this->assertEquals($t->get_category(384), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n mod 100 is 1;			1, 101, 201, 301, 401, 501...
	 * 	two → n mod 100 is 2;			2, 102, 202, 302, 402, 502...
	 * 	few → n mod 100 in 3..4;		3, 4, 103, 104, 203, 204...
	 * 	other → everything else			0, 5-100, 105-200, 205-300...; 1.31, 2.31, 3.31, 5.31...
	 */
	public function testSlovenian()
	{
		$t = $this->_get_instance('sl');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(101), 'one');
		$this->assertEquals($t->get_category(201), 'one');
		$this->assertEquals($t->get_category(301), 'one');
		$this->assertEquals($t->get_category(401), 'one');
		$this->assertEquals($t->get_category(501), 'one');

		$this->assertEquals($t->get_category(2), 'two');
		$this->assertEquals($t->get_category(102), 'two');
		$this->assertEquals($t->get_category(202), 'two');
		$this->assertEquals($t->get_category(302), 'two');
		$this->assertEquals($t->get_category(402), 'two');
		$this->assertEquals($t->get_category(502), 'two');

		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(4), 'few');
		$this->assertEquals($t->get_category(103), 'few');
		$this->assertEquals($t->get_category(104), 'few');
		$this->assertEquals($t->get_category(203), 'few');
		$this->assertEquals($t->get_category(204), 'few');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(6), 'other');
		$this->assertEquals($t->get_category(8), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(29), 'other');
		$this->assertEquals($t->get_category(60), 'other');
		$this->assertEquals($t->get_category(99), 'other');
		$this->assertEquals($t->get_category(100), 'other');
		$this->assertEquals($t->get_category(105), 'other');
		$this->assertEquals($t->get_category(189), 'other');
		$this->assertEquals($t->get_category(200), 'other');
		$this->assertEquals($t->get_category(205), 'other');
		$this->assertEquals($t->get_category(300), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(3.31), 'other');
		$this->assertEquals($t->get_category(5.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n is 1;											1
	 * 	few → n is 0 OR n is not 1 AND n mod 100 in 1..19;		0, 2-19, 101-119, 201-219...
	 * 	other → everything else									20-100, 120-200, 220-300...; 1.31, 2.31, 20.31...
	 */
	public function testRomanian()
	{
		$t = $this->_get_instance('ro');

		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(0), 'few');
		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(5), 'few');
		$this->assertEquals($t->get_category(9), 'few');
		$this->assertEquals($t->get_category(10), 'few');
		$this->assertEquals($t->get_category(15), 'few');
		$this->assertEquals($t->get_category(18), 'few');
		$this->assertEquals($t->get_category(19), 'few');
		$this->assertEquals($t->get_category(101), 'few');
		$this->assertEquals($t->get_category(109), 'few');
		$this->assertEquals($t->get_category(110), 'few');
		$this->assertEquals($t->get_category(111), 'few');
		$this->assertEquals($t->get_category(117), 'few');
		$this->assertEquals($t->get_category(119), 'few');
		$this->assertEquals($t->get_category(201), 'few');
		$this->assertEquals($t->get_category(209), 'few');
		$this->assertEquals($t->get_category(210), 'few');
		$this->assertEquals($t->get_category(211), 'few');
		$this->assertEquals($t->get_category(217), 'few');
		$this->assertEquals($t->get_category(219), 'few');

		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(23), 'other');
		$this->assertEquals($t->get_category(35), 'other');
		$this->assertEquals($t->get_category(89), 'other');
		$this->assertEquals($t->get_category(99), 'other');
		$this->assertEquals($t->get_category(100), 'other');
		$this->assertEquals($t->get_category(120), 'other');
		$this->assertEquals($t->get_category(121), 'other');
		$this->assertEquals($t->get_category(200), 'other');
		$this->assertEquals($t->get_category(220), 'other');
		$this->assertEquals($t->get_category(300), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(20.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n is 1;																		1
	 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14 and n mod 100 not in 22..24;		2-4, 22-24, 32-34...
	 * 	other → everything else																0, 5-21, 25-31, 35-41...; 1.31, 2.31, 5.31...
	 */
	public function testPolish()
	{
		$t = $this->_get_instance('pl');

		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(4), 'few');
		$this->assertEquals($t->get_category(32), 'few');
		$this->assertEquals($t->get_category(33), 'few');
		$this->assertEquals($t->get_category(34), 'few');
		$this->assertEquals($t->get_category(102), 'few');
		$this->assertEquals($t->get_category(103), 'few');
		$this->assertEquals($t->get_category(104), 'few');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(6), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(12), 'other');
		$this->assertEquals($t->get_category(15), 'other');
		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(21), 'other');
		$this->assertEquals($t->get_category(22), 'other');
		$this->assertEquals($t->get_category(23), 'other');
		$this->assertEquals($t->get_category(24), 'other');
		$this->assertEquals($t->get_category(25), 'other');
		$this->assertEquals($t->get_category(30), 'other');
		$this->assertEquals($t->get_category(31), 'other');
		$this->assertEquals($t->get_category(47), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(5.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n is 1;				1
	 * 	other → everything else		0, 2-999; 1.31, 2.31...
	 */
	public function testOne()
	{
		$t = $this->_get_instance('af');

		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(301), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
	}

	/**
	 * Rules:
	 *  other → everything		0-999; 1.31...
	 */
	public function testNone()
	{
		$t = $this->_get_instance('az');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(301), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n is 1;							1
	 * 	few → n is 0 or n mod 100 in 2..10;		0, 2-10, 102-110, 202-210...
	 * 	many → n mod 100 in 11..19;				11-19, 111-119, 211-219...
	 * 	other → everything else					20-101, 120-201, 220-301...; 1.31, 2.31, 11.31, 20.31...
	 */
	public function testMaltese()
	{
		$t = $this->_get_instance('mt');

		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(0), 'few');
		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(5), 'few');
		$this->assertEquals($t->get_category(7), 'few');
		$this->assertEquals($t->get_category(9), 'few');
		$this->assertEquals($t->get_category(10), 'few');
		$this->assertEquals($t->get_category(102), 'few');
		$this->assertEquals($t->get_category(103), 'few');
		$this->assertEquals($t->get_category(105), 'few');
		$this->assertEquals($t->get_category(107), 'few');
		$this->assertEquals($t->get_category(109), 'few');
		$this->assertEquals($t->get_category(110), 'few');
		$this->assertEquals($t->get_category(202), 'few');
		$this->assertEquals($t->get_category(203), 'few');
		$this->assertEquals($t->get_category(205), 'few');
		$this->assertEquals($t->get_category(207), 'few');
		$this->assertEquals($t->get_category(209), 'few');
		$this->assertEquals($t->get_category(210), 'few');

		$this->assertEquals($t->get_category(11), 'many');
		$this->assertEquals($t->get_category(12), 'many');
		$this->assertEquals($t->get_category(13), 'many');
		$this->assertEquals($t->get_category(14), 'many');
		$this->assertEquals($t->get_category(16), 'many');
		$this->assertEquals($t->get_category(19), 'many');
		$this->assertEquals($t->get_category(111), 'many');
		$this->assertEquals($t->get_category(112), 'many');
		$this->assertEquals($t->get_category(113), 'many');
		$this->assertEquals($t->get_category(114), 'many');
		$this->assertEquals($t->get_category(116), 'many');
		$this->assertEquals($t->get_category(119), 'many');

		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(21), 'other');
		$this->assertEquals($t->get_category(32), 'other');
		$this->assertEquals($t->get_category(43), 'other');
		$this->assertEquals($t->get_category(83), 'other');
		$this->assertEquals($t->get_category(99), 'other');
		$this->assertEquals($t->get_category(100), 'other');
		$this->assertEquals($t->get_category(101), 'other');
		$this->assertEquals($t->get_category(120), 'other');
		$this->assertEquals($t->get_category(200), 'other');
		$this->assertEquals($t->get_category(201), 'other');
		$this->assertEquals($t->get_category(220), 'other');
		$this->assertEquals($t->get_category(301), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
		$this->assertEquals($t->get_category(20.31), 'other');
	}

	/**
	 * Rules:
	 * 	one → n mod 10 is 1 and n is not 11;	1, 21, 31, 41, 51, 61...
	 * 	other → everything else					0, 2-20, 22-30, 32-40...; 1.31, 2.31...
	 */
	public function testMacedonian()
	{
		$t = $this->_get_instance('mk');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(21), 'one');
		$this->assertEquals($t->get_category(31), 'one');
		$this->assertEquals($t->get_category(41), 'one');
		$this->assertEquals($t->get_category(51), 'one');
		$this->assertEquals($t->get_category(101), 'one');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(2), 'other');
		$this->assertEquals($t->get_category(3), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(9), 'other');
		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(13), 'other');
		$this->assertEquals($t->get_category(14), 'other');
		$this->assertEquals($t->get_category(18), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(22), 'other');
		$this->assertEquals($t->get_category(25), 'other');
		$this->assertEquals($t->get_category(30), 'other');
		$this->assertEquals($t->get_category(32), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(0.31), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(1.99), 'other');
	}

	/**
	 * Rules:
	 * 	one → n mod 10 is 1 and n mod 100 not in 11..19;		1, 21, 31, 41, 51, 61...
	 * 	few → n mod 10 in 2..9 and n mod 100 not in 11..19;		2-9, 22-29, 32-39...
	 * 	other → everything else									0, 10-20, 30, 40, 50...; 1.31, 2.31, 10.31...
	 */
	public function testLithuanian()
	{
		$t = $this->_get_instance('lt');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(21), 'one');
		$this->assertEquals($t->get_category(31), 'one');
		$this->assertEquals($t->get_category(41), 'one');
		$this->assertEquals($t->get_category(51), 'one');
		$this->assertEquals($t->get_category(101), 'one');

		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(5), 'few');
		$this->assertEquals($t->get_category(7), 'few');
		$this->assertEquals($t->get_category(9), 'few');
		$this->assertEquals($t->get_category(22), 'few');
		$this->assertEquals($t->get_category(23), 'few');
		$this->assertEquals($t->get_category(25), 'few');
		$this->assertEquals($t->get_category(27), 'few');
		$this->assertEquals($t->get_category(29), 'few');
		$this->assertEquals($t->get_category(32), 'few');
		$this->assertEquals($t->get_category(33), 'few');
		$this->assertEquals($t->get_category(35), 'few');
		$this->assertEquals($t->get_category(37), 'few');
		$this->assertEquals($t->get_category(39), 'few');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(12), 'other');
		$this->assertEquals($t->get_category(13), 'other');
		$this->assertEquals($t->get_category(15), 'other');
		$this->assertEquals($t->get_category(18), 'other');
		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(30), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(50), 'other');
		$this->assertEquals($t->get_category(0.31), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(1.99), 'other');
	}

	/**
	 * Rules:
	 * 	zero → n is 0;										0
	 * 	one → n mod 10 is 1 and n mod 100 is not 11;		1, 21, 31, 41, 51, 61...
	 * 	other → everything else								2-20, 22-30, 32-40...; 0.31, 1.31, 2.31...
	 */
	public function testLatvian()
	{
		$t = $this->_get_instance('lv');

		$this->assertEquals($t->get_category(0), 'zero');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(21), 'one');
		$this->assertEquals($t->get_category(31), 'one');
		$this->assertEquals($t->get_category(41), 'one');
		$this->assertEquals($t->get_category(51), 'one');
		$this->assertEquals($t->get_category(101), 'one');

		$this->assertEquals($t->get_category(2), 'other');
		$this->assertEquals($t->get_category(3), 'other');
		$this->assertEquals($t->get_category(8), 'other');
		$this->assertEquals($t->get_category(10), 'other');
		$this->assertEquals($t->get_category(11), 'other');
		$this->assertEquals($t->get_category(15), 'other');
		$this->assertEquals($t->get_category(19), 'other');
		$this->assertEquals($t->get_category(20), 'other');
		$this->assertEquals($t->get_category(22), 'other');
		$this->assertEquals($t->get_category(30), 'other');
		$this->assertEquals($t->get_category(32), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(111), 'other');
		$this->assertEquals($t->get_category(0.31), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(1.99), 'other');
	}

	/**
	 * Rules:
	 * 	zero → n is 0;											0
	 * 	one → n within 0..2 and n is not 0 and n is not 2;		1, 1.31...
	 * 	other → everything else									2-999; 2.31...
	 */
	public function testLangi()
	{
		$t = $this->_get_instance('lag');

		$this->assertEquals($t->get_category(0), 'zero');

		$this->assertEquals($t->get_category(0.01), 'one');
		$this->assertEquals($t->get_category(0.51), 'one');
		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(1.31), 'one');
		$this->assertEquals($t->get_category(1.99), 'one');

		$this->assertEquals($t->get_category(2), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(7), 'other');
		$this->assertEquals($t->get_category(17), 'other');
		$this->assertEquals($t->get_category(28), 'other');
		$this->assertEquals($t->get_category(39), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(51), 'other');
		$this->assertEquals($t->get_category(63), 'other');
		$this->assertEquals($t->get_category(111), 'other');
		$this->assertEquals($t->get_category(597), 'other');
		$this->assertEquals($t->get_category(846), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
	}

	/**
	 * Test Rules:
	 *  one → n within 0..2 and n is not 2;		0, 1, 1.31...
	 *  other → everything else					2-999; 2.31...
	 */
	public function testFrench()
	{
		$t = $this->_get_instance('fr');

		$this->assertEquals($t->get_category(0), 'one');
		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(1.31), 'one');
		$this->assertEquals($t->get_category(1.99), 'one');

		$this->assertEquals($t->get_category(2), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(7), 'other');
		$this->assertEquals($t->get_category(17), 'other');
		$this->assertEquals($t->get_category(28), 'other');
		$this->assertEquals($t->get_category(39), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(51), 'other');
		$this->assertEquals($t->get_category(63), 'other');
		$this->assertEquals($t->get_category(111), 'other');
		$this->assertEquals($t->get_category(597), 'other');
		$this->assertEquals($t->get_category(846), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(5.31), 'other');
	}

	/**
	 * Test Rules:
	 * 	one → n is 1;				1
	 * 	few → n in 2..4;			2-4
	 * 	other → everything else		0, 5-999, 1.31, 2.31, 5.31...
	 */
	public function testCzech()
	{
		$t = $this->_get_instance('cs');

		$this->assertEquals($t->get_category(1), 'one');

		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(4), 'few');

		$this->assertEquals($t->get_category(0), 'other');
		$this->assertEquals($t->get_category(5), 'other');
		$this->assertEquals($t->get_category(7), 'other');
		$this->assertEquals($t->get_category(17), 'other');
		$this->assertEquals($t->get_category(28), 'other');
		$this->assertEquals($t->get_category(39), 'other');
		$this->assertEquals($t->get_category(40), 'other');
		$this->assertEquals($t->get_category(51), 'other');
		$this->assertEquals($t->get_category(63), 'other');
		$this->assertEquals($t->get_category(111), 'other');
		$this->assertEquals($t->get_category(597), 'other');
		$this->assertEquals($t->get_category(846), 'other');
		$this->assertEquals($t->get_category(999), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(5.31), 'other');
	}

	/**
	 * Test Rules:
	 * 	zero → n is 0;					0
	 * 	one → n is 1;					1
	 * 	two → n is 2;					2
	 * 	few → n mod 100 in 3..10;		3-10, 103-110, 203-210...
	 * 	many → n mod 100 in 11..99;		11-99, 111-199, 211-299...
	 * 	other → everything else			100-102, 200-202, 300-302..., 0.31, 1.31, 2.31, 3.31, 11.31, 100.31...
	 */
	public function testArabic()
	{
		$t = $this->_get_instance('ar');

		$this->assertEquals($t->get_category(0), 'zero');
		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(2), 'two');

		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(4), 'few');
		$this->assertEquals($t->get_category(6), 'few');
		$this->assertEquals($t->get_category(8), 'few');
		$this->assertEquals($t->get_category(10), 'few');
		$this->assertEquals($t->get_category(103), 'few');
		$this->assertEquals($t->get_category(104), 'few');
		$this->assertEquals($t->get_category(106), 'few');
		$this->assertEquals($t->get_category(108), 'few');
		$this->assertEquals($t->get_category(110), 'few');
		$this->assertEquals($t->get_category(203), 'few');
		$this->assertEquals($t->get_category(204), 'few');
		$this->assertEquals($t->get_category(206), 'few');
		$this->assertEquals($t->get_category(208), 'few');
		$this->assertEquals($t->get_category(210), 'few');

		$this->assertEquals($t->get_category(11), 'many');
		$this->assertEquals($t->get_category(15), 'many');
		$this->assertEquals($t->get_category(25), 'many');
		$this->assertEquals($t->get_category(36), 'many');
		$this->assertEquals($t->get_category(47), 'many');
		$this->assertEquals($t->get_category(58), 'many');
		$this->assertEquals($t->get_category(69), 'many');
		$this->assertEquals($t->get_category(71), 'many');
		$this->assertEquals($t->get_category(82), 'many');
		$this->assertEquals($t->get_category(93), 'many');
		$this->assertEquals($t->get_category(99), 'many');
		$this->assertEquals($t->get_category(111), 'many');
		$this->assertEquals($t->get_category(115), 'many');
		$this->assertEquals($t->get_category(125), 'many');
		$this->assertEquals($t->get_category(136), 'many');
		$this->assertEquals($t->get_category(147), 'many');
		$this->assertEquals($t->get_category(158), 'many');
		$this->assertEquals($t->get_category(169), 'many');
		$this->assertEquals($t->get_category(171), 'many');
		$this->assertEquals($t->get_category(182), 'many');
		$this->assertEquals($t->get_category(193), 'many');
		$this->assertEquals($t->get_category(199), 'many');
		$this->assertEquals($t->get_category(211), 'many');
		$this->assertEquals($t->get_category(215), 'many');
		$this->assertEquals($t->get_category(225), 'many');
		$this->assertEquals($t->get_category(236), 'many');
		$this->assertEquals($t->get_category(247), 'many');
		$this->assertEquals($t->get_category(258), 'many');
		$this->assertEquals($t->get_category(269), 'many');
		$this->assertEquals($t->get_category(271), 'many');
		$this->assertEquals($t->get_category(282), 'many');
		$this->assertEquals($t->get_category(293), 'many');
		$this->assertEquals($t->get_category(299), 'many');

		$this->assertEquals($t->get_category(100), 'other');
		$this->assertEquals($t->get_category(101), 'other');
		$this->assertEquals($t->get_category(102), 'other');
		$this->assertEquals($t->get_category(200), 'other');
		$this->assertEquals($t->get_category(201), 'other');
		$this->assertEquals($t->get_category(202), 'other');
		$this->assertEquals($t->get_category(300), 'other');
		$this->assertEquals($t->get_category(301), 'other');
		$this->assertEquals($t->get_category(302), 'other');
		$this->assertEquals($t->get_category(0.31), 'other');
		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(3.31), 'other');
		$this->assertEquals($t->get_category(11.31), 'other');
		$this->assertEquals($t->get_category(100.31), 'other');
	}

	/**
	 * Test rules:
	 * 	one → n mod 10 is 1 and n mod 100 is not 11;						1, 21, 31, 41, 51, 61...
	 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14;					2-4, 22-24, 32-34...
	 * 	many → n mod 10 is 0 or n mod 10 in 5..9 or n mod 100 in 11..14;	0, 5-20, 25-30, 35-40...
	 * 	other → everything else												1.31, 2.31, 5.31...
	 */
	public function testBalkan()
	{
		$t = $this->_get_instance('ru');

		$this->assertEquals($t->get_category(1), 'one');
		$this->assertEquals($t->get_category(21), 'one');
		$this->assertEquals($t->get_category(31), 'one');
		$this->assertEquals($t->get_category(41), 'one');
		$this->assertEquals($t->get_category(51), 'one');
		$this->assertEquals($t->get_category(61), 'one');

		$this->assertEquals($t->get_category(2), 'few');
		$this->assertEquals($t->get_category(3), 'few');
		$this->assertEquals($t->get_category(4), 'few');
		$this->assertEquals($t->get_category(22), 'few');
		$this->assertEquals($t->get_category(23), 'few');
		$this->assertEquals($t->get_category(24), 'few');
		$this->assertEquals($t->get_category(142), 'few');
		$this->assertEquals($t->get_category(143), 'few');
		$this->assertEquals($t->get_category(144), 'few');

		$this->assertEquals($t->get_category(0), 'many');
		$this->assertEquals($t->get_category(5), 'many');
		$this->assertEquals($t->get_category(6), 'many');
		$this->assertEquals($t->get_category(7), 'many');
		$this->assertEquals($t->get_category(11), 'many');
		$this->assertEquals($t->get_category(12), 'many');
		$this->assertEquals($t->get_category(15), 'many');
		$this->assertEquals($t->get_category(20), 'many');
		$this->assertEquals($t->get_category(25), 'many');
		$this->assertEquals($t->get_category(26), 'many');
		$this->assertEquals($t->get_category(28), 'many');
		$this->assertEquals($t->get_category(29), 'many');
		$this->assertEquals($t->get_category(30), 'many');
		$this->assertEquals($t->get_category(65), 'many');
		$this->assertEquals($t->get_category(66), 'many');
		$this->assertEquals($t->get_category(68), 'many');
		$this->assertEquals($t->get_category(69), 'many');
		$this->assertEquals($t->get_category(70), 'many');
		$this->assertEquals($t->get_category(112), 'many');
		$this->assertEquals($t->get_category(1112), 'many');

		$this->assertEquals($t->get_category(1.31), 'other');
		$this->assertEquals($t->get_category(2.31), 'other');
		$this->assertEquals($t->get_category(5.31), 'other');
	}

	private function _get_instance($prefix)
	{
		return I18n_Plural::instance($prefix);
	}
}