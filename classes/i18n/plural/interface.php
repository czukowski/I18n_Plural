<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Interface for I18n_Plural Rules
 *
 * @package    I18n_Plural
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
interface I18n_Plural_Interface
{
	/**
	 * Returns category key by count
	 * 
	 * @param   integer  $count
	 * @return  string
	 */
	public function plural_category($count);
}