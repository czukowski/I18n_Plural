Plural inflections
==================

This module will help you to output accurate language-dependent plural inflections, that's based on [CLDR Language Plural Rules](http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html).

There is a number of **Groups**, that define certain set of inflection **Rules**, and one or more languages following them. Each Rule has a **Key**, that represents the variation. For example, for English, there are two rules: 'one' for singular form and 'other' for plural. Every Group has at least 'other' Group.

Usage
-----

Modify lines in your translation files, that may need inflection applied, so that they are arrays instead of strings. You may also want to create a translation file for your default application language.

Example (i18n/en.php):

    return array(
        'Hello world' => array(
            'one' => 'Hello world',
            'other' => 'Hello worlds',
        ),
    );

Use the ___() function (3 underscores, as opposed to 2 underscores being standard Kohana translation function). It is defined in module's init.php:

    echo ___('Hello world', 2);
    // Hello worlds

If you think about it, there's pretty much extra writing, so you could use some shorthands for translation keys, and it'll work anyway, since the triple-underscore function, unlike the double-underscore, does the translation in any case. On the other hand, this may look a bit harsh, and in case no translation is found, you'll end up with gibberish, so it's entirely up to you:

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

Somewhere else:

    echo ___('hlwrld.iyo', 1, array(':age' => 1));
    // Hello world, I\'m 1 year old
    echo ___('hlwrld.iyo', 2, array(':age' => 2));
    // Hello world, I\'m 2 years old
    echo ___('hlwrld.iyo', 10, array(':age' => 10));
    // Hello world, I\'m 2 years old
    
    I18n::lang('ru'); // Switch Kohana to another language
    
    echo ___('hlwrld.iyo', 1, array(':age' => 1));
    // Привет мир, мне уже 1 год
    echo ___('hlwrld.iyo', 2, array(':age' => 2));
    // Привет мир, мне уже 2 года
    echo ___('hlwrld.iyo', 10, array(':age' => 10));
    // Привет мир, мне уже 10 лет

API
---

### init.php

#### function ___($string, $count = 0, array $values = NULL)

Function, that always translates a string

 * @param string $string
 * @param mixed $count
 * @param array $values
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
