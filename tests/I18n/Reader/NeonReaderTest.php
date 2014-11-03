<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n\Reader;

class NeonReaderTest extends Testcase
{
	private $temp_file;
	protected $i18n = array(
		'cs.neon' => <<<NEON
test: test
locale: 'locale (cs)'
section:
	test: 'section test'
NEON
		,
		'cs/cz.neon' => <<<NEON
'locale': 'locale (cs-cz)'
'exclusive': 'only in cs-cz'
NEON
	);

	/**
	 * @dataProvider  provide_load_file
	 */
	public function test_load_file($neon, $expected)
	{
		$this->setup_object();
		$load_file = new \ReflectionMethod($this->object, 'load_file');
		$load_file->setAccessible(TRUE);
		if ($neon)
		{
			// Write neon content to temporary file.
			$this->temp_file = tempnam(sys_get_temp_dir(), 'i18n');
			file_put_contents($this->temp_file, $neon);
		}
		// Load neon from temporary file.
		$actual = $load_file->invoke($this->object, $this->temp_file);
		$this->assertSame($expected, $actual);
	}

	public function provide_load_file()
	{
		return array(
			array(
				FALSE,
				array(),
			),
			array(
				$this->i18n['cs.neon'],
				array(
					'test' => 'test',
					'locale' => 'locale (cs)',
					'section' => array(
						'test' => 'section test'
					),
				),
			),
			array(
				$this->i18n['cs/cz.neon'],
				array(
					'locale' => 'locale (cs-cz)',
					'exclusive' => 'only in cs-cz',
				),
			),
		);
	}

	protected function _load_file($content)
	{
		$decode = new \ReflectionMethod($this->object, 'decode');
		$decode->setAccessible(TRUE);
		return $decode->invoke($this->object, $content);
	}

	protected function _object_constructor_arguments()
	{
		return array('callback://app/');
	}

	public function tearDown()
	{
		if ($this->temp_file)
		{
			unlink($this->temp_file);
		}
	}
}
