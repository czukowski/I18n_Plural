<?php
/**
 * Plural rules for Welsh language:
 * 
 * Locales: cy
 * 
 * Languages:
 * - Welsh (cy)
 * 
 * Rules:
 *  zero → n is 0;
 *  one → n is 1;
 *  two → n is 2;
 *  few → n is 3;
 *  many → n is 6;
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

class Welsh implements PluralInterface
{
	public function plural_category($count)
	{
		if ($count == 0)
		{
			return 'zero';
		}
		elseif ($count == 1)
		{
			return 'one';
		}
		elseif ($count == 2)
		{
			return 'two';
		}
		elseif ($count == 3)
		{
			return 'few';
		}
		elseif ($count == 6)
		{
			return 'many';
		}
		else
		{
			return 'other';
		}
	}
}