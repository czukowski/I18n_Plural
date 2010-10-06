<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana translation/internationalization function with custom forms support.
 * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
 *
 *    ___(':count user is online', 1000, array(':count' => 1000));
 *    // 1000 users are online
 *
 * @uses I18n_Plural::get
 * @param string to translate
 * @param mixed string form or numeric count
 * @param array param values to insert
 * @return string
 */
function ___($string, $count = 0, array $values = NULL)
{
	if (is_array($count) AND $values === NULL)
	{
		// Assume no form is specified and the 2nd argument are parameters
		$values = $count;
		$count = 0;
	}
	if (is_numeric($count))
	{
		// Get plural form
		$string = I18n_Plural::get($string, $count);
	}
	else
	{
		// Get custom form
		$string = I18n_Form::get($string, $count);
	}
	return empty($values) ? $string : strtr($string, $values);
}