<?php
/**
 * This file contains some helper files for the unit tests
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace Plurals\Tests;

/**
 * Test translation reader that returns predefined results
 */
class Reader implements \I18n_Reader_Interface {

	public $translations = array(
		'en' => array(
			':title person' => array(
				'some' => ':title person',
				'mr' => ':title man',
				'ms' => ':title woman',
			),
			':count countable' => array(
				'zero' => ':count countables',
				'one' => ':count countable',
				'two' => ':count countables',
				'three' => ':count countables',
				'other' => ':count countables',
			),
		),
		'es' => array(
			'Spanish' => 'Español',
		),
		'cs' => array(
			':title person' => array(
				'mr' => ':title muž',
				'ms' => ':title žena',
				'other' => ':title člověk',
			),
			'something :what' => 'něco :what',
		),
	);

	public function get($string, $lang = NULL)
	{
		if (isset($this->translations[$lang][$string]))
		{
			return $this->translations[$lang][$string];
		}
		return NULL;
	}
}

/**
 * Test plural rules that return predefined values
 */
class Rules implements \I18n_Plural_Interface {

	public $rules = array(
		0 => 'zero',
		1 => 'one',
		2 => 'two',
		3 => 'three',
	);

	public function get_category($count)
	{
		return isset($this->rules[$count]) ? $this->rules[$count] : 'other';
	}
}