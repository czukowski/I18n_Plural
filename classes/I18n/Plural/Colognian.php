<?php
/**
 * Plural rules for Colognian language:
 * 
 * Locales: ksh
 * 
 * Languages:
 * - Colognian (ksh)
 * 
 * Rules:
 *  zero → n is 0;
 *  one → n is 1;
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

class Colognian implements PluralInterface
{
	public function plural_category($count)
	{
		if ($count == 0)
		{
			return 'zero';
		}
		if ($count == 1)
		{
			return 'one';
		}
		else
		{
			return 'other';
		}
	}
}