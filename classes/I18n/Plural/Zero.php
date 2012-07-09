<?php
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ak am bh fil tl guw hi ln mg nso ti wa
 * 
 * Languages:
 *  Akan (ak)
 *  Amharic (am)
 *  Bihari (bh)
 *  Filipino (fil)
 *  Gun (guw)
 *  Hindi (hi)
 *  Lingala (ln)
 *  Malagasy (mg)
 *  Northern Sotho (nso)
 *  Tigrinya (ti)
 *  Walloon (wa)
 * 
 * Rules:
 *  one → n in 0..1;
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

class Zero implements PluralInterface
{
	public function plural_category($count)
	{
        if ($count == 0 || $count == 1)
		{
			return 'one';
        }
		else
		{
			return 'other';
        }
	}
}