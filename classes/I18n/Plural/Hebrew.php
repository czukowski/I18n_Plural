<?php
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
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;

class Hebrew implements PluralInterface
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