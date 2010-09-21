<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Macedonian language
 * 
 * Locales: mk
 *
 * Languages:
 * - Macedonian (mk)
 *
 * Rules:
 * 	one → n mod 10 is 1 and n is not 11;
 * 	other → everything else
 *
 * Reference CLDR Version 1.8.1 (2010-04-30 23:05:14 GMT)
 * @see http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 *
 * @package		I18n_Plural
 * @author		Korney Czukowski
 * @copyright	(c) 2010 Korney Czukowski
 * @license		http://kohanaphp.com/license
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