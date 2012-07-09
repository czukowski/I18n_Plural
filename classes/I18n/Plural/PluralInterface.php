<?php
/**
 * Interface for I18n_Plural Rules
 *
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;

interface PluralInterface
{
	/**
	 * Returns category key by count
	 * 
	 * @param   integer  $count
	 * @return  string
	 */
	public function plural_category($count);
}