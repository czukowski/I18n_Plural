<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Function, that always translates a string
 * @param string $string
 * @param mixed $count
 * @param array $values
 * @return string
 */
function ___($string, $count = 0, array $values = NULL)
{
	$string = I18n_Plural::get($string, $count);
	return empty($values) ? $string : strtr($string, $values);
}