<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ak am bh fil guw hi ln mg nso ti tl wa
 * 
 * Languages:
 *  Akan (ak)
 *  Amharic (am)
 *  Bihari (bh)
 *  Filipino (fil)
 *  Gun (guw)
 *  Hindi (hi)
 *  Lingala (ln)
 *  Malagasy (mg)
 *  Northern Sotho (nso)
 *  Tigrinya (ti)
 *  Tagalog (tl)
 *  Walloon (wa)
 *
 * Rules:
 *  one → n in 0..1;
 *  other → everything else
 */
class I18n_Plural_Zero extends I18n_Plural_Rules
{
	public function get_category($count)
	{
        if ($count == 0 || $count == 1)
		{
			return 'one';
        }
		else
		{
			return 'other';
        }
	}
}