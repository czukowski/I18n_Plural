<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ff fr kab
 * 
 * Languages:
 *  Fulah (ff)
 *  French (fr)
 *  Kabyle (kab)
 *
 * Rules:
 *  one → n within 0..2 and n is not 2;
 *  other → everything else
 */
class I18n_Plural_French extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		if ($count >= 0 AND $count < 2)
		{
			return 'one';
        }
		else
		{
			return 'other';
        }
	}
}