<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Slovenian language:
 * 
 * Locales: sl
 * 
 * Languages:
 * - Slovenian (sl)
 * 
 * Rules:
 * 	one → n mod 100 is 1;
 * 	two → n mod 100 is 2;
 * 	few → n mod 100 in 3..4;
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
class I18n_Plural_Slovenian implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if (is_int($count) AND $count % 100 == 1)
		{
			return 'one';
		}
		elseif (is_int($count) AND $count % 100 == 2)
		{
			return 'two';
		}
		elseif (is_int($count) AND ($i = $count % 100) >= 3 AND $i <= 4)
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}