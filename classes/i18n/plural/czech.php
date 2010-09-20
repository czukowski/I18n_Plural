<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 *
 * Locales: cs sk
 *
 * Languages:
 * - Czech (cs)
 * - Slovak (sk)
 *
 * Rules:
 * 	one → n is 1;
 * 	few → n in 2..4;
 * 	other → everything else
 */
class I18n_Plural_Czech extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		else if (is_int($count) AND $count >= 2 AND $count <= 4)
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}