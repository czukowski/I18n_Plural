<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana translation/internationalization convenience function with context support.
 * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
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
	return I18n_Core::instance()->translate($string, $context, $values, $lang);
}

// Initialize I18n_Core object. It'll be then accessible via `I18n_Core::instance()`
new I18n_Core(new I18n_Reader_Kohana);