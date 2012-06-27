<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: az bm bo dz fa id ig ii hu ja jv ka kde kea km kn ko lo ms my sah ses sg th to tr vi wo yo zh
 * 
 * Languages:
 * - Azerbaijani (az)
 * - Bambara (bm)
 * - Tibetan (bo)
 * - Dzongkha (dz)
 * - Persian (fa)
 * - Indonesian (id)
 * - Igbo (ig)
 * - Sichuan Yi (ii)
 * - Hungarian (hu)
 * - Japanese (ja)
 * - Javanese (jv)
 * - Georgian (ka)
 * - Makonde (kde)
 * - Kabuverdianu (kea)
 * - Khmer (km)
 * - Kannada (kn)
 * - Korean (ko)
 * - Lao (lo)
 * - Malay (ms)
 * - Burmese (my)
 * - Sakha (sah)
 * - Koyraboro Senni (ses)
 * - Sango (sg)
 * - Thai (th)
 * - Tonga (to)
 * - Turkish (tr)
 * - Vietnamese (vi)
 * - Wolof (wo)
 * - Yoruba (yo)
 * - Chinese (zh)
 * 
 * These are known to have no plurals, there are no rules:
 *  other → everything
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
class I18n_Plural_None implements I18n_Plural_Interface
{
	public function plural_category($count)
	{
		return 'other';
	}
}