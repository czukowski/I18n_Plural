<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for Latvian language:
 * 
 * Locales: lv
 * 
 * Languages:
 * - Latvian (lv)
 * 
 * Rules:
 * 	zero → n is 0;
 * 	one → n mod 10 is 1 and n mod 100 is not 11;
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
class I18n_Plural_Latvian implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 0)
		{
			return 'zero';
		}
		elseif (is_int($count) AND $count % 10 == 1 AND $count % 100 != 11)
		{
			return 'one';
		}
		else
		{
			return 'other';
		}
	}
}