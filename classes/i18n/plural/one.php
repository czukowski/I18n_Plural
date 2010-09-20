<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Plural rules for the following locales and languages:
 *
 * Locales: af bem bg bn ca chr da de el en eo es et eu fi fo fur fy gl gsw gu ha he is it iw ku lb ml mn mr nah nb ne nl nn no
 *          om or pa pap ps pt rm so sq sv sw ta te tk ur zu
 *
 * Languages:
 *  Afrikaans (af)
 *  Bemba (bem)
 *  Bulgarian (bg)
 *  Bengali (bn)
 *  Catalan (ca)
 *  Cherokee (chr)
 *  Danish (da)
 *  German (de)
 *  Greek (el)
 *  English (en)
 *  Esperanto (eo)
 *  Spanish (es)
 *  Estonian (et)
 *  Basque (eu)
 *  Finnish (fi)
 *  Faroese (fo)
 *  Friulian (fur)
 *  Western Frisian (fy)
 *  Galician (gl)
 *  Swiss German (gsw)
 *  Gujarati (gu)
 *  Hausa (ha)
 *  Hebrew (he)
 *  Icelandic (is)
 *  Italian (it)
 *  iw (iw)
 *  Kurdish (ku)
 *  Luxembourgish (lb)
 *  Malayalam (ml)
 *  Mongolian (mn)
 *  Marathi (mr)
 *  Nahuatl (nah)
 *  Norwegian Bokmål (nb)
 *  Nepali (ne)
 *  Dutch (nl)
 *  Norwegian Nynorsk (nn)
 *  Norwegian (no)
 *  Oromo (om)
 *  Oriya (or)
 *  Punjabi (pa)
 *  Papiamento (pap)
 *  Pashto (ps)
 *  Portuguese (pt)
 *  Romansh (rm)
 *  Somali (so)
 *  Albanian (sq)
 *  Swedish (sv)
 *  Swahili (sw)
 *  Tamil (ta)
 *  Telugu (te)
 *  Turkmen (tk)
 *  Urdu (ur)
 *  Zulu (zu)
 *
 * Rules:
 * 	one → n is 1;
 * 	other → everything else
 */
class I18n_Plural_One extends I18n_Plural_Rules
{
	public function get_category($count)
	{
		return $count == 1 ? 'one' : 'other';
	}
}