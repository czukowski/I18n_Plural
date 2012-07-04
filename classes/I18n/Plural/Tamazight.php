<?php
/**
 * Plural rules for Central Morocco Tamazight language:
 * 
 * Locales: tzm
 * 
 * Languages:
 *  Central Morocco Tamazight (tzm)
 * 
 * Rules:
 *  one → n in 0..1 or n in 11..99;
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
class I18n_Plural_Tamazight implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if (is_int($count) AND ($count == 0 OR $count == 1 OR ($count >= 11 AND $count <= 99)))
		{
			return 'one';
        }
		else
		{
			return 'other';
        }
	}
}