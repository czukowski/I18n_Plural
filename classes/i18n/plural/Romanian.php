<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ro mo
 * 
 * Languages:
 *  Moldavian (mo)
 *  Romanian (ro)
 * 
 * Rules:
 * 	one → n is 1;
 * 	few → n is 0 OR n is not 1 AND n mod 100 in 1..19;
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
class I18n_Plural_Romanian implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif (is_int($count) AND ($count == 0 OR (($i = $count % 100) >= 1 AND $i <= 19)))
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}