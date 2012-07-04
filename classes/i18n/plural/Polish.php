<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Polish language:
 * 
 * Locales: pl
 * 
 * Languages:
 * - Polish (pl)
 * 
 * Rules:
 * 	one → n is 1;
 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14 and n mod 100 not in 22..24;
 * 	other → everything else (fractions)
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
class I18n_Plural_Polish implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif (is_int($count) AND ($i = $count % 10) >= 2 AND $i <= 4 AND ! (($i = $count % 100) >= 12 AND $i <= 14) AND ! ($i >= 22 AND $i <= 24))
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}