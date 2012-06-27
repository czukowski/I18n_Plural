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
class I18n_Plural_Maltese implements I18n_Plural_Interface
{
	public function plural_category($count)
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