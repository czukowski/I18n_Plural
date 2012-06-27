<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: cs sk
 * 
 * Languages:
 * - Czech (cs)
 * - Slovak (sk)
 * 
 * Rules:
 * 	one → n is 1;
 * 	few → n in 2..4;
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
class I18n_Plural_Czech implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif (is_int($count) AND $count >= 2 AND $count <= 4)
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}