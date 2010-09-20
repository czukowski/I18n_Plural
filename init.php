<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Function, that always translates a string
 * @param string $string
 * @param array $values
 * @param mixed $count
 * @return string
 */
function ___($string, array $values = NULL, $count = 0)
{
	$string = I18n_Plural::get($string, $count);
	return empty($values) ? $string : strtr($string, $values);
}