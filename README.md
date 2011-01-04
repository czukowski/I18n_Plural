Introduction
============

This module started as a helper class to achieve accurate language-dependent plural inflections, but has grown
into almost complete alternative to Kohana 3.0.x I18n system.

Current features are:

 * Support for multiple translation options for any term
 * Support for deep array structures in i18n files
 * Choosing correct translation option when translating plural amount of any term, based on [CLDR Language Plural Rules](http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html)
 * Translating and correctly inflecting time spans

Plural inflections
==================

There is a number of **Groups**, that define certain set of inflection **Rules**, and one or more languages
following them. Each Rule has a **Key**, that represents the variation. For example, for English, there are
two Rules: 'one' for singular form and 'other' for plural. Every Group has at least 'other' Key.

Usage
-----

Modify lines in your translation files, that may need inflection applied, so that they are arrays instead of strings.
You may also want to create a translation file for your default application language.

Example (i18n/en.php):

    return array(
        'Hello world' => array(
            'one' => 'Hello world',
            'other' => 'Hello worlds',
        ),
    );

Use the ___() function (3 underscores, as opposed to 2 underscores being standard Kohana translation function). It is
defined in module's init.php:

    echo ___('Hello world', 2);
    // Hello worlds

If you think about it, there's pretty much extra writing, so you could use some shorthands for translation keys, and
it'll work anyway, since the triple-underscore function, unlike the double-underscore, does the translation in any case.
On the other hand, this may look a bit harsh, and in case no translation is found, you'll end up with gibberish, so
it's entirely up to you:

    return array(
        'hlwrld' => array(...),
    );
    ...
    echo ___('hlwrld', 10);

You can also pass the parameters, as you would using standard translation function:

i18n/en.php:

    return array(
        'hlwrld.iyo' => array(
            'one' => 'Hello world, I\'m :age year old',
            'other' => 'Hello world, I\'m :age years old',
        ),
    );

i18n/ru.php:

    return array(
        'hlwrld.iyo' => array(
            'one' => 'Привет мир, мне уже :age год',
            'few' => 'Привет мир, мне уже :age года',
            'many' => 'Привет мир, мне уже :age лет',
            'other' => 'Привет мир, мне уже :age лет',
        ),
    );

You can also use deeper arrays to structure your translations. To be able to use it, create this file in your application folder:

    class I18n extends I18n_Core {}

Translation files then may look like this:

i18n/en.php:

    return array(
        'hlwrld' => array(
			'iyo'=> array(
				'one' => 'Hello world, I\'m :age year old',
				'other' => 'Hello world, I\'m :age years old',
			),
        ),
    );

The translations will be merged recursively, but the I18n::get() will work either way. First it checks for a string key, then it
tries Arr::path().

Usage:

    echo ___('hlwrld.iyo', 1, array(':age' => 1));
    // Hello world, I\'m 1 year old
    echo ___('hlwrld.iyo', 2, array(':age' => 2));
    // Hello world, I\'m 2 years old
    echo ___('hlwrld.iyo', 10, array(':age' => 10));
    // Hello world, I\'m 10 years old
    
    I18n::lang('ru'); // Switch Kohana to another language
    
    echo ___('hlwrld.iyo', 1, array(':age' => 1));
    // Привет мир, мне уже 1 год
    echo ___('hlwrld.iyo', 2, array(':age' => 2));
    // Привет мир, мне уже 2 года
    echo ___('hlwrld.iyo', 10, array(':age' => 10));
    // Привет мир, мне уже 10 лет

Custom forms
============

Instead of numeric _count_ parameter when dealing with plurals, you can pass any string parameter, that the ___() will
attempt to locate and use as a translation key. If the key does not exists, the function looks for 'other' key. If it doesn't
exist too, it gives up and returns the 1st array value.

Usage
-----

Suppose you have the following translations:

i18n/en.php:

    return array(
        'their_name_is' => array(
            'f' => 'Her name is :name',
            'm' => 'His name is :name',
        ),
    );

Somewhere else:

    echo ___('their_name_is', 'f', array(':name' => 'Aimee'));
    // Her name is Aimee

Some languages distinguish grammatical genders in way more situations, than just pronouns, besides, certain words may have
different grammatical gender in different languages. In this case, it's impossible to specify the required form, as it may differ
from language to language. Instead, you may tie the translation keys to the context, like so:

i18n/ru.php:

    return array(
        'Enabled' => array(
            'user' => 'Включен',
            'role' => 'Включена',
            'other' => 'Включено',
        ),
    );

Somewhere else:

    echo ___('Enabled', 'user');
    // Включен

Note the 'other' key, that'll be used for any other context than 'user' or 'role'.

Date and time formatting
========================

Provides date formatting and translation methods to achieve consistency with MooTools
[Date.format()](http://mootools.net/docs/more/Native/Date#Date:format). May come in handy for those, who use
[MooTools](http://mootools.net) for their client-side code, so the date/time format strings and verbose representation
are the same for both server and client side.

Usage
-----

The I18n_Date class extends Kohana_Date class, so if you create this:

    class Date extends I18n_Date {}

then you can use it transparently. Only fuzzy_span() method is overriden, so that it behaves as MooTools Date.timeDiffInWords()
method. In the following examples, I'll use Date::_method\_name()_, but you could as well I18n_Date::_method\_name()_, if you
don't want to override Kohana_Date::fuzzy_span().

	$time = time();
	Date::fuzzy_span(time, time - 10); // -10 seconds
    // less than a minute ago
	Date::fuzzy_span(time, time - 50); // -50 seconds
    // about a minute ago
	Date::fuzzy_span(time, time - 100); // 1:40 ago
    // 2 minutes ago
	Date::fuzzy_span(time, time + 86400); // +24 hours
    // 1 day from now

and so on. The string returned will be translated to the current language.

You can also format dates with various formats using Date::format() method. Possible formatting keys are same as with MooTools
[Date.format()](http://mootools.net/docs/more/Native/Date#Date:format) method:

    Date::format($time, '%m/%d/%Y');
    // 10/05/2010
    Date::format($time); // Default is %x %X
    // 10/05/2010 10:53PM
    Date::format($time, 'db'); // using shorthands
    // 2010-10-05 10:53:24
    Date::format($time, 'short');
    // 05 Oct 10:53
    Date::format($time, 'long');
    // October 05, 2010 10:53
    Date::format($time, 'iso8601');
    // 2010-10-05T10:53:24+02:00

If you don't specify format, it will assume %x %X, which is a current date and time in the current language prefered format.
It's defined in Kohana translation files, see files from this package for examples (array keys with 'date.' prefix).

Following format shorthands are currrently supported:

 * db => %Y-%m-%d %H:%M:%S
 * compact => %Y%m%dT%H%M%S
 * iso8601 => %Y-%m-%dT%H:%M:%S%T
 * rfc822 => %a, %d %b %Y %H:%M:%S %z
 * rfc2822 => %a, %d %b %Y %H:%M:%S %z
 * short => %d %b %H:%M
 * long => %B %d, %Y %H:%M

API
---

### init.php

#### function ___($string, $count = 0, $values = NULL, $lang = NULL)

Kohana translation/internationalization function with custom forms support. The PHP function [strtr](http://php.net/strtr)
is used for replacing parameters.

    ___(':count user is online', 1000, array(':count' => 1000));
    // 1000 users are online

 * @param string to translate
 * @param mixed string form or numeric count
 * @param array param values to insert
 * @param string target language
 * @return string

### class I18n_Plural

#### public static function get($string, $count = 0)

Returns translation of a string. If no translation exists, the original string will be returned. No parameters are replaced.

    $hello = I18n_Plural::get('Hello, my name is :name and I have :count friend.', 10);
    // 'Hello, my name is :name and I have :count friends.'

 * @param string $string
 * @param mixed $count
 * @return string

#### public static function instance($lang)

Returns class, that handles plural inflection for the given language.

 * @param string $lang
 * @return I18n_Plural_Rules

### class I18n_Date

#### public static function fuzzy_span($from, $to = NULL)

Returns the difference between a time and now in a "fuzzy" way.
Overrides Kohana_Date::fuzzy_span() method.

 * @param integer $from UNIX timestamp
 * @param integer $to UNIX timestamp, current timestamp is used when NULL
 * @return string

#### public static function format($timestamp = NULL, $format = NULL)

Formats date and time.

 * @param mixed timestamp, string with date representation or I18n_Date_Format object; current timestamp if NULL
 * @param string format string or shorthand; '%x %X' if NULL
 * @return string