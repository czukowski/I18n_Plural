<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Maltese language:
 *
 * Locales: mt
 *
 * Languages:
 * - Maltese (mt)
 *
 * Rules:
 * 	one → n is 1;
 * 	few → n is 0 or n mod 100 in 2..10;
 * 	many → n mod 100 in 11..19;
 * 	other → everything else
 */
class I18n_Plural_Maltese extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif ($count == 0 OR is_int($count) AND ($i = $count % 100) >= 2 AND $i <= 10)
		{
			return 'few';
		}
		elseif (is_int($count) AND ($i = $count % 100) >= 11 AND $i <= 19)
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}