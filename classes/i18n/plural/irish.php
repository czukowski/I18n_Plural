<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ga
 * 
 * Languages:
 *  Irish (ga)
 * 
 * Rules:
 *  one → n is 1;
 *  two → n is 2;
 *  few → n in 3..6;
 *  many → n in 7..10;
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
class I18n_Plural_Irish implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif ($count == 2)
		{
			return 'two';
		}
		elseif (is_int($count) AND $count >= 3 AND $count <= 6)
		{
			return 'few';
		}
		elseif (is_int($count) AND $count >= 7 AND $count <= 10)
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}