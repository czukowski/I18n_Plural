<?php defined('SYSPATH') or die('No direct script access.');

return array(
	// Plural test
	':count files'	=> array(
		'one' => ':count file',
		'other' => ':count files',
	),
	// Date/time
	'date.months' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
	'date.months_abbr' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
	'date.days' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
	'date.days_abbr' => array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'),
	'date.order' => array('month', 'date', 'year'),	// Culture's date order: MM/DD/YYYY
	'date.short_date' => '%m/%d/%Y',
	'date.short_time' => '%I:%M%p',
	'date.am'	=> 'AM',
	'date.pm'	=> 'PM',
	'date.less_than_minute_ago' => 'less than a minute ago',
	'date.minute_ago' => array(
		'one'	=> 'about a minute ago',
		'other' => '{delta} minutes ago',
	),
	'date.hour_ago' => array(
		'one'	=> 'about an hour ago',
		'other' => 'about {delta} hours ago',
	),
	'date.day_ago' => array(
		'one'	=> '1 day ago',
		'other' => '{delta} days ago',
	),
	'date.week_ago' => array(
		'one'	=> '1 week ago',
		'other' => '{delta} weeks ago',
	),
	'date.month_ago' => array(
		'one'	=> '1 month ago',
		'other' => '{delta} months ago',
	),
	'date.year_ago' => array(
		'one'	=> '1 year ago',
		'other' => '{delta} years ago',
	),
	'date.less_than_minute_until' => 'less than a minute from now',
	'date.minute_until' => array(
		'one'	=> 'about a minute from now',
		'other' => '{delta} minutes from now',
	),
	'date.hour_until' => array(
		'one'	=> 'about an hour from now',
		'other' => 'about {delta} hours from now',
	),
	'date.day_until' => array(
		'one'	=> '1 day from now',
		'other' => '{delta} days from now',
	),
	'date.week_until' => array(
		'one'	=> '1 week from now',
		'other' => '{delta} weeks from now',
	),
	'date.month_until' => array(
		'one'	=> '1 month from now',
		'other' => '{delta} months from now',
	),
	'date.year_until' => array(
		'one'	=> '1 year from now',
		'other' => '{delta} years from now',
	),
	'date.never' => 'never',
);