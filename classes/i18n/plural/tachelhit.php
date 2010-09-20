<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Tachelhit language:
 *
 * Locales: shi
 *
 * Languages:
 * - Tachelhit (shi)
 *
 * Rules:
 * 	one → n within 0..1;
 * 	few → n in 2..10;
 * 	other → everything else
 */
class I18n_Plural_Tachelhit extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count >= 0 AND $count <= 1)
		{
			return 'one';
		}
		elseif (is_int($count) AND $count >= 0 AND $count <= 10)
		{
			return 'few';
        }
		else
		{
			return 'other';
        }
	}
}