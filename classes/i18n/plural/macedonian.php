<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Macedonian language:
 *
 * Locales: mk
 *
 * Languages:
 * - Macedonian (mk)
 *
 * Rules:
 * 	one → n mod 10 is 1 and n is not 11;
 * 	other → everything else
 */
class I18n_Plural_Macedonian extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if (is_int($count) AND $count % 10 == 1 AND $count != 11)
		{
			return 'one';
		}
		else
		{
			return 'other';
		}
	}
}