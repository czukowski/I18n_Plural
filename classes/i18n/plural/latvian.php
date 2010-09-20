<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Latvian language:
 *
 * Locales: lv
 *
 * Languages:
 * - Latvian (lv)
 *
 * Rules:
 * 	zero → n is 0;
 * 	one → n mod 10 is 1 and n mod 100 is not 11;
 * 	other → everything else
 */
class I18n_Plural_Latvian extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count == 0)
		{
			return 'zero';
		}
		elseif (is_int($count) AND $count % 10 == 1 AND $count % 100 != 11)
		{
			return 'one';
		}
		else
		{
			return 'other';
		}
	}
}