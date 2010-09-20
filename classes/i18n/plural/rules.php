<?php defined('SYSPATH') or die('No direct script access.');

abstract class I18n_Plural_Rules
{
	/**
	 * Returns category key
	 * @param int $count
	 * @return string
	 */
	abstract public function get_category($count);
}