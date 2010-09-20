<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: az bm fa ig hu ja kde kea ko my ses sg to tr vi wo yo zh bo dz id jv ka km kn ms th
 * 
 * Languages:
 *  Azerbaijani (az)
 *  Bambara (bm)
 *  Persian (fa)
 *  Igbo (ig)
 *  Hungarian (hu)
 *  Japanese (ja)
 *  Makonde (kde)
 *  Kabuverdianu (kea)
 *  Korean (ko)
 *  Burmese (my)
 *  Koyraboro Senni (ses)
 *  Sango (sg)
 *  Tonga (to)
 *  Turkish (tr)
 *  Vietnamese (vi)
 *  Wolof (wo)
 *  Yoruba (yo)
 *  Chinese (zh)
 *  Tibetan (bo)
 *  Dzongkha (dz)
 *  Indonesian (id)
 *  Javanese (jv)
 *  Georgian (ka)
 *  Khmer (km)
 *  Kannada (kn)
 *  Malay (ms)
 *  Thai (th)
 *
 * These are known to have no plurals, there are no rules:
 *  other → everything
 */
class I18n_Plural_None extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		return 'other';
	}
}