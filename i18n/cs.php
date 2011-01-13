<?php defined('SYSPATH') or die('No direct script access.');

return array(
	// Plural test
	':count files'	=> array(
		'one' => ':count soubor',
		'few' => ':count soubory',
		'other' => ':count souborů',
	),
	// Date/time
	'date.months' => array('Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'),
	'date.months_abbr' => array('ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'),
	'date.days' => array('Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'),
	'date.days_abbr' => array('ne', 'po', 'út', 'st', 'čt', 'pá', 'so'),
	'date.date_order' => array('date', 'month', 'year'),
	'date.short_date' => '%d.%m.%Y',
	'date.short_time' => '%H:%M',
	'date.am' => 'dop.',
	'date.pm' => 'odp.',
	'date.less_than_minute_ago' => 'před chvílí',
	'date.minute_ago' => array(
		'one'	=> 'přibližně před minutou',
		'other' => 'před {delta} minutami', // same as 'few'
	),
	'date.hour_ago' => array(
		'one'	=> 'přibližně před hodinou',
		'other' => 'před {delta} hodinami',
	),
	'date.day_ago' => array(
		'one'	=> 'před dnem',
		'other' => 'před {delta} dny',
	),
	'date.week_ago' => array(
		'one'	=> 'před týdnem',
		'other' => 'před {delta} týdny',
	),
	'date.month_ago' => array(
		'one'	=> 'před měsícem',
		'other' => 'před {delta} měsíci',
	),
	'date.year_ago' => array(
		'one'	=> 'před rokem',
		'other' => 'před {delta} lety',
	),
	'date.less_than_minute_until' => 'za chvíli',
	'date.minute_until' => array(
		'one'	=> 'přibližně za minutu',
		'few' => 'za {delta} minuty',
		'other' => 'za {delta} minut',
	),
	'date.hour_until' => array(
		'one'	=> 'přibližně za hodinu',
		'few'	=> 'za {delta} hodiny',
		'other' => 'za {delta} hodin',
	),
	'date.day_until' => array(
		'one'	=> 'za den',
		'few'	=> 'za {delta} dny',
		'other'	=> 'za {delta} dnů',
	),
	'date.week_until' => array(
		'one'	=> 'za týden',
		'few'	=> 'za {delta} týdny',
		'other' => 'za {delta} týdnů',
	),
	'date.month_until' => array(
		'one'	=> 'za měsíc',
		'few'	=> 'za {delta} měsíce',
		'other' => 'za {delta} měsíců',
	),
	'date.year_until' => array(
		'one'	=> 'za rok',
		'few'	=> 'za {delta} roky',
		'other' => 'za {delta} let',
	),
	'date.never' => 'nikdy',
);