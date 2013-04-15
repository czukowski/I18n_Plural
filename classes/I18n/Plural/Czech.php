<?php
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
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Plural;

class Czech extends IntegerRule
{
	public function plural_category($count)
	{
		if ($count == 1)
		{
			return 'one';
		}
		elseif ($this->is_int($count) AND $count >= 2 AND $count <= 4)
		{
			return 'few';
		}
		else
		{
			return 'other';
		}
	}
}