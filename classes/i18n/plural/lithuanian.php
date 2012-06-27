<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Lithuanian language:
 * 
 * Locales: lt
 * 
 * Languages:
 * - Lithuanian (lt)
 * 
 * Rules:
 * 	one → n mod 10 is 1 and n mod 100 not in 11..19;
 * 	few → n mod 10 in 2..9 and n mod 100 not in 11..19;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * @see  plurals.xml (local copy)
 * 
 * @package    I18n_Plural
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
class I18n_Plural_Lithuanian implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if (is_int($count) AND $count % 10 == 1 AND ! (($i = $count % 100) >= 11 AND $i <= 19))
		{
			return 'one';
		}
		elseif (is_int($count) AND ($i = $count % 10) >= 2 AND $i <= 9 AND ! (($i = $count % 100) >= 11 AND $i <= 19))
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}