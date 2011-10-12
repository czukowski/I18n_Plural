<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'date_formats' => array(
		'db' => '%Y-%m-%d %H:%M:%S',
		'compact' => '%Y%m%dT%H%M%S',
		'header' => '%g',
		'iso8601' => '%Y-%m-%dT%H:%M:%S%P',
		'rfc822' => '%r',
		'rfc2822' => '%r',
		// 04 Oct 07:25
		'short' => '%d %b %H:%M',
		// October 04, 2011 07:41
		'long' => '%B %d, %Y %H:%M',
		// 4 October 2011 07:51
		// TODO: this is local date format, remove or merged under auto-local formatting
        'article' => '%e %C %Y %H:%M',
    )
);