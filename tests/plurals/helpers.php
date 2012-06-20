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
			'person' => array(
				'some' => 'person',
				'mr' => 'man',
				'ms' => 'woman',
			),
			'countable' => array(
				'zero' => 'No countables',
				'one' => 'One countable',
				'two' => 'Two countables',
				'three' => 'Three countables',
				'other' => 'Many countables',
			),
		),
		'cs' => array(
			'person' => array(
				'mr' => 'muž',
				'ms' => 'žena',
				'other' => 'člověk',
			),
		),
	);

	public function get($string, $lang = NULL)
	{
		if (isset($this->translations[$lang][$string]))
		{
			return $this->translations[$lang][$string];
		}
		return $string;
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