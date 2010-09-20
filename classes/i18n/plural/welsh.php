<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Welsh language:
 *
 * Locales: cy
 *
 * Languages:
 * - Welsh (cy)
 *
 * Rules:
 * 	one → n is 1;
 * 	two → n is 2;
 * 	many → n is 8 or n is 11;
 * 	other → everything else
 */
class I18n_Plural_Welsh extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif ($count == 2)
		{
			return 'two';
		}
		elseif ($count == 8 OR $count == 11)
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}