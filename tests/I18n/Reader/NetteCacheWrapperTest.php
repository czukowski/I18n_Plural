<?php
/**
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2015 Korney Czukowski
 * @license    MIT License
 * @group      plurals
 */
namespace I18n\Reader;
use I18n,
	Nette\Caching\Cache;

class NetteCacheWrapperTest extends I18n\Testcase
{
	private $_cache_data;
	private $_cache_options;

	/**
	 * @dataProvider  provide_add_directory_option
	 */
	public function test_add_directory_option($path, $mask, $expected)
	{
		$object = new NetteCacheWrapper($this->create_cache_mock());
		$object->add_directory_option($path, $mask);
		$object['any key'] = 'any data';
		$this->assertEquals($expected, $this->_cache_options);
	}

	public function provide_add_directory_option()
	{
		// Use real files in the tests directory for the lack of any better test cases.
		$netteDirectory = realpath(__DIR__.'/../../Nette');
		return array(
			array(
				$netteDirectory,
				'*.php',
				array(
					Cache::FILES => array(
						$netteDirectory.'/Caching/Cache.php',
						$netteDirectory.'/Localization/ITranslator.php',
					),
				),
			),
			array(
				$netteDirectory,
				'*.dat',
				array(),
			),
		);
	}

	/**
	 * @dataProvider  provide_constructor_options
	 */
	public function test_constructor_options($options, $expected)
	{
		$object = new NetteCacheWrapper($this->create_cache_mock(), $options);
		$object['any key'] = 'any data';
		$this->assertEquals($expected, $this->_cache_options);
	}

	public function provide_constructor_options()
	{
		$netteDirectory = realpath(__DIR__.'/../../Nette');
		return array(
			array(
				array(Cache::FILES => 'en-us.neon'),
				array(Cache::FILES => 'en-us.neon'),
			),
			array(
				array(
					NetteCacheWrapper::DIRECTORIES => array(
						$netteDirectory => '*.php',
					),
				),
				array(
					Cache::FILES => array(
						$netteDirectory.'/Caching/Cache.php',
						$netteDirectory.'/Localization/ITranslator.php',
					),
				),
			),
			array(
				array(
					NetteCacheWrapper::DIRECTORIES => array(
						$netteDirectory => '*.php',
					),
					Cache::FILES => 'en-us.neon',
				),
				array(
					Cache::FILES => array(
						'en-us.neon',
						$netteDirectory.'/Caching/Cache.php',
						$netteDirectory.'/Localization/ITranslator.php',
					),
				),
			),
		);
	}

	/**
	 * @dataProvider  provide_array_access
	 */
	public function test_array_access($key, $value)
	{
		$this->setup_object();
		$this->assertFalse(isset($this->object[$key]));
		$this->object[$key] = $value;
		$this->assertTrue(isset($this->object[$key]));
		$this->assertEquals($value, $this->object[$key]);
		unset($this->object[$key]);
		$this->assertFalse(isset($this->object[$key]));
	}

	public function provide_array_access()
	{
		return array(
			array('en', array('key1' => 'value1')),
		);
	}

	public function setUp()
	{
		$this->_cache_data = array();
		parent::setUp();
	}

	protected function _object_constructor_arguments()
	{
		return array($this->create_cache_mock());
	}

	/**
	 * @return  Nette\Caching\Cache
	 */
	protected function create_cache_mock()
	{
		$cache = $this->getMock('Nette\Caching\Cache', array(), array(), '', FALSE);
		$cache->expects($this->any())
			->method('load')
			->will($this->returnCallback(array($this, 'callback_cache_load')));
		$cache->expects($this->any())
			->method('save')
			->will($this->returnCallback(array($this, 'callback_cache_save')));
		return $cache;
	}

	public function callback_cache_load($key)
	{
		return isset($this->_cache_data[$key]) ? $this->_cache_data[$key] : NULL;
	}

	public function callback_cache_save($key, $value, $options = array())
	{
		$this->_cache_data[$key] = $value;
		$this->_cache_options = $options;
	}
}
