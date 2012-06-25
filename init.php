<?php defined('SYSPATH') or die('No direct script access.');

if ( ! function_exists('___'))
{
	/**
	 * This is a gateway to the `I18n_Core` functions, as there's no static access to it.
	 * 
	 *    ___(':count user is online', 1000, array(':count' => 1000));
	 *    // 1000 users are online
	 * 
	 * @uses    I18n_Core::translate()
	 * @param   string  $string to translate
	 * @param   mixed   $context string form or numeric count
	 * @param   array   $values param values to insert
	 * @param   string  $lang target language
	 * @return  string
	 */
	function ___($string, $context = 0, $values = NULL, $lang = NULL)
	{
		static $i18n;
		if ($i18n === NULL)
		{
			// Initialize I18n_Core object
			$i18n = new I18n_Core;
			$i18n->attach(new I18n_Reader_Kohana);
		}
		if ($lang === NULL)
		{
			$lang = I18n::lang();
		}
		return $i18n->translate($string, $context, $values, $lang);
	}
}