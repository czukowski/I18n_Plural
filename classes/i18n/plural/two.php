<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ga se sma smi smj smn sms
 * 
 * Languages:
 *  Irish (ga)
 *  Northern Sami (se)
 *  Southern Sami (sma)
 *  Sami Language (smi)
 *  Lule Sami (smj)
 *  Inari Sami (smn)
 *  Skolt Sami (sms)
 *
 * Rules:
 *  one → n is 1;
 *  two → n is 2;
 *  other → everything else
 */
class I18n_Plural_Two extends I18n_Plural_Rules
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
		else
		{
			return 'other';
		}
	}
}