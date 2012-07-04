<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: he
 * 
 * Languages:
 *  Hebrew (he)
 * 
 * Rules:
 *  one → n is 1;
 *  two → n is 2;
 *  many → n is not 0 and n mod 10 is 0;
 *  other → everything else
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
class I18n_Plural_Hebrew implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		if ($count == 2)
		{
			return 'two';
		}
		elseif ($count != 0 AND ($count % 10) === 0)
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}