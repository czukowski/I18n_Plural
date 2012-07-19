<?php defined('SYSPATH') or die('No direct script access.');

if ( ! function_exists('___'))
{
	/**
	 * This is a gateway to the `I18n_Core` functions, as there's no static access to it.
	 * 
	 *    ___(':count user is online', 1000, array(':count' => 1000));
	 *    // 1000 users are online
	 * 
	 * @uses    \I18n\Core::translate()
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
			// Initialize I18n Core object
			$i18n = new \I18n\Core;
			$i18n->attach(new \I18n\Reader\Kohana);
		}
		if (is_array($context) AND ! is_array($values))
		{
			// Assume no form is specified and the 2nd argument are parameters
			$lang = $values;
			$values = $context;
			$context = 0;
		}
		if ($lang === NULL)
		{
			$lang = I18n::lang();
		}
		return $i18n->translate($string, $context, $values, $lang);
	}
}