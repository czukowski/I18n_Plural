<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    // Plural test
    ':count files' => array(
        'one' => ':count plik',
        'few' => ':count pliki',
        'other' => ':count plików',
    ),
    // Date/time
    'date' => array(
        'months' => array('Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'),
        'months_abbr' => array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), // http://poradnia.pwn.pl/lista.php?id=1788
        'days' => array('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'),
        'days_abbr' => array('Niedz', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'),  // without ending dots for readability
        'order' => array('date', 'month', 'year'),
        'short_date' => '%Y-%m-%d', // http://pl.wikipedia.org/wiki/ISO_8601
        'short_time' => '%H:%M',
        'am' => 'AM',
        'pm' => 'PM',
        'less_than_minute_ago' => 'mniej niż minutę temu',
        'minute_ago' => array(
            'one' => 'ok. minutę temu',
            'few' => '{delta} minuty temu',
            'other' => '{delta} minut temu',
        ),
        'hour_ago' => array(
            'one' => 'ok. godzinę temu',
            'few' => 'ok. {delta} godziny temu',
            'other' => 'ok. {delta} godzin temu',
        ),
        'day_ago' => array(
            'one' => 'wczoraj',
            'few' => '{delta} dni temu',
            'other' => '{delta} dni temu',
        ),
        'week_ago' => array(
            'one' => 'tydzień temu',
            'few' => '{delta} tygodnie temu',
            'other' => '{delta} tygodni temu',
        ),
        'month_ago' => array(
            'one' => 'miesiąc temu',
            'few' => '{delta} miesięce temu',
            'other' => '{delta} miesięcy temu',
        ),
        'year_ago' => array(
            'one' => 'rok temu',
            'few' => '{delta} lata temu',
            'other' => '{delta} lat temu',
        ),
        'less_than_minute_until' => 'mniej niż za minutę',
        'minute_until' => array(
            'one' => 'za minutę',
            'few' => 'za {delta} minuty',
            'other' => 'za {delta} minut',
        ),
        'hour_until' => array(
            'one' => 'za godzinę',
            'few' => 'za {delta} godziny',
            'other' => 'za {delta} godzin',
        ),
        'day_until' => array(
            'one' => '1 day from now',
            'few' => 'za {delta} dni',
            'other' => 'za {delta} dni',
        ),
        'week_until' => array(
            'one' => 'za tydzień',
            'few' => 'za {delta} tygodnie',
            'other' => 'za {delta} tygodni',
        ),
        'month_until' => array(
            'one' => 'za miesiąc',
            'few' => 'za {delta} miesiące',
            'other' => 'za {delta} miesięcy',
        ),
        'year_until' => array(
            'one' => 'za rok',
            'few' => 'za {delta} lata',
            'other' => 'za {delta} lat',
        ),
        'never' => 'nigdy',
    ),
    'valid' => array(
        'decimal' => array(
            'one' => 'Pole :field być 1-cyfrową liczbą',
			'few' => 'Pole :field być :param2-cyfrową liczbą',
            'other' => 'Pole :field być :param2-cyfrową liczbą',
        ),
        'exact_length' => array(
            'one' => ':field musi mieć długość dokładnie jednego znaku',
            'other' => 'Pole :field musi mieć długość :param2 znaków',
        ),
        'max_length' => array(
			'few' => 'Pole :field musi być krótsze niż :param2 znaki',
            'other' => 'Pole :field musi być krótsze niż :param2 znaków',
        ),
        'min_length' => array(
            'one' => 'Pole :field musi być dłuższe niż 1 znak',
			'few' => 'Pole :field musi być dłuższe niż :param2 znaki',
            'other' => 'Pole :field musi być dłuższe niż :param2 znaków',
        ),
    ),
);