<?php
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: be bs hr ru sh sr uk
 * 
 * Languages:
 * - Belarusian (be)
 * - Bosnian (bs)
 * - Croatian (hr)
 * - Russian (ru)
 * - Serbo-Croatian (sh)
 * - Serbian (sr)
 * - Ukrainian (uk)
 * 
 * Rules:
 * 	one → n mod 10 is 1 and n mod 100 is not 11;
 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14;
 * 	many → n mod 10 is 0 or n mod 10 in 5..9 or n mod 100 in 11..14;
 * 	other → everything else (fractions)
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * @see  plurals.xml (local copy)
 * 
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;

class Balkan extends IntegerRule
{
	public function plural_category($count)
	{
		$is_int = $this->is_int($count);
		if ($is_int AND $count % 10 == 1 AND $count % 100 != 11)
		{
			return 'one';
		}
		elseif ($is_int AND ($i = $count % 10) >= 2 AND $i <= 4 AND ! (($i = $count % 100) >= 12 AND $i <= 14)) 
		{
			return 'few';
		}
		elseif ($is_int AND (($i = $count % 10) == 0 OR ($i >= 5 AND $i <= 9) OR (($i = $count % 100) >= 11 AND $i <= 14)))
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}