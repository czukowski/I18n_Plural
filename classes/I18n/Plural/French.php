<?php
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ff fr kab
 * 
 * Languages:
 *  Fulah (ff)
 *  French (fr)
 *  Kabyle (kab)
 * 
 * Rules:
 *  one → n within 0..2 and n is not 2;
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

class French implements PluralInterface
{
	public function plural_category($count)
	{
		if ($count >= 0 AND $count < 2)
		{
			return 'one';
		}
		else
		{
			return 'other';
		}
	}
}