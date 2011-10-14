<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Base I18n_Plural_Rules class
 *
 * @package    I18n_Plural
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
abstract class I18n_Plural_Rules
{
	/**
	 * Returns category key
	 * 
	 * @param   integer  $count
	 * @return  string
	 */
	abstract public function get_category($count);
}