<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana translation/internationalization function with plurals support.
 * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
 *
 *    ___(':count user is online', 1000, array(':count' => 1000));
 *    // 1000 users are online
 *
 * @uses I18n_Plural::get
 * @param string $string
 * @param mixed $count
 * @param array $values
 * @return string
 */
function ___($string, $count = 0, array $values = NULL)
{
	if (is_array($count) AND $values === NULL)
	{
		$values = $count;
		$count = 0;
	}
	$string = I18n_Plural::get($string, $count);
	return empty($values) ? $string : strtr($string, $values);
}