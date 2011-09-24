<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'date_formats' => array(
		'db' => '%Y-%m-%d %H:%M:%S',
		'compact' => '%Y%m%dT%H%M%S',
		'header' => '%g',
		'iso8601' => '%Y-%m-%dT%H:%M:%S%T',
		'rfc822' => '%a, %d %b %Y %H:%M:%S %z',
		'rfc2822' => '%r',
		'short' => '%d %b %H:%M',
		'long' => '%B %d, %Y %H:%M',
        'article' => '%e %C %Y %H:%M'
    )
);