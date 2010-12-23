<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana translation/internationalization function with custom forms support.
 * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
 *
 *    ___(':count user is online', 1000, array(':count' => 1000));
 *    // 1000 users are online
 *
 * @uses I18n_Plural::get()
 * @uses I18n_Form::get()
 * @param string $string to translate
 * @param mixed $count string form or numeric count
 * @param array $values param values to insert
 * @param string $lang target language
 * @return string
 */
function ___($string, $count = 0, $values = NULL, $lang = NULL)
{
	if (is_array($count) AND ! is_array($values))
	{
		// Assume no form is specified and the 2nd argument are parameters
		$lang = $values;
		$values = $count;
		$count = 0;
	}
	if (is_numeric($count))
	{
		// Get plural form
		$string = I18n_Plural::get($string, $count, $lang);
	}
	else
	{
		// Get custom form
		$string = I18n_Form::get($string, $count, $lang);
	}
	return empty($values) ? $string : strtr($string, $values);
}