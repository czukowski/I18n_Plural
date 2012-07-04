<?php
/**
 * Plural rules for Scottish Gaelic language:
 * 
 * Locales: gd
 * 
 * Languages:
 * - Scottish Gaelic (gd)
 * 
 * Rules:
 *  one → n in 1,11;
 *  two → n in 2,12;
 *  few → n in 3..10,13..19;
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
class I18n_Plural_Gaelic implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		if ($count == 1 OR $count == 11)
		{
			return 'one';
		}
		elseif ($count == 2 OR $count == 12)
		{
			return 'two';
		}
		elseif (is_int($count) AND (($count >= 3 AND $count <= 10) OR ($count >= 13 AND $count <= 19)))
		{
			return 'few';
		}
		else
		{
			return 'other';
        }
	}
}