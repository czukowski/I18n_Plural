<?php defined('SYSPATH') or die('No direct script access.');

return array(
	// Plural test
	':count files'	=> array(
		'one' => ':count файл',
		'few' => ':count файла',
		'many' => ':count файлов',
		'other' => ':count файла',
	),
	// Date/time
	'date.months' => array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'),
	'date.months_abbr' => array('янв', 'февр', 'март', 'апр', 'май', 'июнь', 'июль', 'авг', 'сент', 'окт', 'нояб', 'дек'),
	'date.days' => array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'),
	'date.days_abbr' => array('Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'),
	'date.date_order' => array('date', 'month', 'year'),
	'date.short_date' => '%d.%m.%Y',
	'date.short_time' => '%H:%M',
	'date.am' => 'AM',
	'date.pm' => 'PM',
	'date.less_than_minute_ago' => 'меньше минуты назад',
	'date.minute_ago' => array(
		'one'	=> 'минуту назад',
		'many'	=> '{delta} минут назад',
		'other'	=> '{delta} минуты назад', // same as 'few'
	),
	'date.hour_ago' => array(
		'one'	=> 'час назад',
		'many' => '{delta} часов назад',
		'other' => '{delta} часа назад',
	),
	'date.day_ago' => array(
		'one'	=> 'вчера',
		'many' => '{delta} дней назад',
		'other' => '{delta} днея назад',
	),
	'date.week_ago' => array(
		'one'	=> 'неделю назад',
		'many' => '{delta} недель назад',
		'other' => '{delta} недели назад',
	),
	'date.month_ago' => array(
		'one'	=> 'месяц назад',
		'many' => '{delta} месяцев назад',
		'other' => '{delta} месяца назад',
	),
	'date.year_ago' => array(
		'one'	=> 'год назад',
		'many' => '{delta} лет назад',
		'other' => '{delta} года назад',
	),
	'date.less_than_minute_until' => 'меньше чем через минуту',
	'date.minute_until' => array(
		'one'	=> 'через минуту',
		'many' => 'через {delta} минут',
		'other' => 'через {delta} минуты',
	),
	'date.hour_until' => array(
		'one'	=> 'через час',
		'many' => 'через {delta} часов',
		'other' => 'через {delta} часа',
	),
	'date.day_until' => array(
		'one'	=> 'через день',
		'many' => 'через {delta} дней',
		'other' => 'через {delta} дня',
	),
	'date.week_until' => array(
		'one'	=> 'через неделю',
		'many' => 'через {delta} недель',
		'other' => 'через {delta} недели',
	),
	'date.month_until' => array(
		'one'	=> 'через месяц',
		'many' => 'через {delta} месяцев',
		'other' => 'через {delta} месяца',
	),
	'date.year_until' => array(
		'one'	=> 'через год',
		'many' => 'через {delta} лет',
		'other' => 'через {delta} года',
	),
	'date.never' => 'никогда',
);