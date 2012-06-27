<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: iu kw naq se sma smi smj smn sms
 * 
 * Languages:
 *  Inuktitut (iu)
 *  Cornish (kw)
 *  Nama (naq)
 *  Northern Sami (se)
 *  Southern Sami (sma)
 *  Sami Language (smi)
 *  Lule Sami (smj)
 *  Inari Sami (smn)
 *  Skolt Sami (sms)
 * 
 * Rules:
 *  one → n is 1;
 *  two → n is 2;
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
class I18n_Plural_Two implements I18n_Plural_Interface
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
		else
		{
			return 'other';
		}
	}
}