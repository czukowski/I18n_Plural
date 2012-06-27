<?php
/**
 * Plural rules for Manx language:
 * 
 * Locales: gv
 * 
 * Languages:
 * - Manx (gv)
 * 
 * Rules:
 * 	one → n mod 10 in 1..2 or n mod 20 is 0;    0-2, 11, 12, 20-22...
 * 	other → everything else                     3-10, 13-19, 23-30...; 1.2, 3.07...
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
class I18n_Plural_Manx implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if (is_int($count) AND (in_array($count % 10, array(1, 2)) OR ($count % 20 == 0)))
		{
			return 'one';
        }
		else
		{
			return 'other';
        }
	}
}