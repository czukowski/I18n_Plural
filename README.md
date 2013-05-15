Introduction
============

This package will help you to do grammatically accurate translations in your application.

Branches for the following frameworks are available:

 * [3.3/master](https://github.com/czukowski/I18n_Plural/tree/3.3/master)
   for [Kohana Framework](http://kohanaframework.org/) with some extra features are available (there are also
   branches for older Kohana versions, although no more supported).
 * [nette/master](https://github.com/czukowski/I18n_Plural/tree/nette/master)
   for [Nette Framework](http://nette.org/en/)

For use with the other frameworks or on its own, there's some work to do as you'll need to implement the I18n
files reader(s). More on them below, following some ideas on what this might be good for.

Translation contexts
====================

Many languages use different words or inflections depending on a lot of circumstances, while it isn't much
problem in English, we can find an example there, too: suppose you want to display a string, that looks like
this: "His/her name is _name_" and you know the name of a person and his or her gender. Suppose you have
a function named `__()`, that does your translations and accepts optional arguments for parameters replacement.
Then the most trivial would be to do this:

	echo __($gender == 'f' ? 'His' : 'Her').__('name is :name', array(':name' => $name));

Although you can probably see it's not flexible at all. This message doesn't have to begin with pronoun in
other languages. This is already better:

	echo __(':their name is :name', array(':name' => $name, ':their' => __($gender == 'f' ? 'His' : 'Her')));

But what if there is a language, that changes other words as well? That's where the contextual translation
comes in handy. Consider just this:

	echo __('Their name is :name', $gender);

For that to work, we have defined the translation key `Their name is :name` with 2 contexts - `f` and `m`:

	array(
		'Their name is :name' => array(
			'f' => 'Her name is :name',
			'm' => 'His name is :name',
		),
	);

Example
-------

	foreach (array('aimee', 'bob') as $username)
	{
		$person = ORM::factory('profile')->find($username);
		echo __('Their name is :name', $person->gender, array(':name' => $person->name));
	}

	// Outputs:
	// Her name is Aimee
	// His name is Bob

Example
-------

Some languages distinguish grammatical genders in way more situations, than just pronouns. Also, we can't
tell what grammatical gender a certain word is in different languages, as it may be quite random. Now we see,
that we can't always specify the required form, as we did with the given names. In this case, we can think
of a context in another way, a context can be just an object we want it to be related to.

Let's take Russian for an example, although many others will have similar translation structure as well.

	array(
		'Enabled' => array(
			'user' => 'Включен',
			'role' => 'Включена',
			'other' => 'Включено',
		),
	);

Somewhere else:

	echo __('Enabled', 'user');
	// Включен

Note the `other` key, that'll be used for any other context than `user` or `role`.

Plural inflections
==================

If you've ever been bothered by labels like "1 file(s)", there is a solution for you.

Nice people at CLDR have taken their time to compile plural rules for a large number of languages. This
module includes all these rules and a function, that converts any number into a proper context for that
language. The possible contexts are `zero`, `one`, `two`, `few`, `many` and `other`. Most languages will
only have 2-3 of these, and any of them will always have `other` context.

The rules are defined in [these classes](https://github.com/czukowski/I18n_Plural/tree/master/classes/I18n/Plural).
If you don't see your language immediately, try looking into One.php, Two.php and other generic names, they
aggregate a large number of languages, that share same rules. All the files include the rules in human
readable format and a list of languages they apply to.

It may be important to note, that the plural context must be numeric (`is_numeric` must return `TRUE` for that
value) in order to be tested against the language plural rules. Otherwise it'll look for the exact translation
key.

Example
-------

English:

	array(
		'You have :count messages' => array(
			'one' => 'You have one message',        // 1 message
			'other' => 'You have :count messages',  // more messages
		),
	);

Czech:

	array(
		'You have :count messages' => array(
			'one' => 'Máte jednu zprávu',      // 1 message
			'few' => 'Máte :count zprávy',     // 2 - 4 messages
			'other' => 'Máte :count zpráv',    // more messages
		),
	);

*Note:* before doing something like I did above (I've replaced :count with actual 'one' value for the
context `one`), check with the language rules, whether that context really applies only when the number
is 1. There are languages out there, where this is not the case, for those languages, you'll have to leave
the parameter there.

Example
-------

English:

	array(
		'Hi My Age Is'=> array(
			'one' => 'Hello world, I\'m :age year old',
			'other' => 'Hello world, I\'m :age years old',
		),
	);

Russian:

	array(
		'Hi My Age Is' => array(
			'one' => 'Привет мир, мне уже :age год',
			'few' => 'Привет мир, мне уже :age года',
			'many' => 'Привет мир, мне уже :age лет',
			'other' => 'Привет мир, мне уже :age лет',
		),
	);

In your code:

	echo __('Hi My Age Is', 1, array(':age' => 1));
	// Hello world, I\'m 1 year old
	echo __('Hi My Age Is', 2, array(':age' => 2));
	// Hello world, I\'m 2 years old
	echo __('Hi My Age Is', 10, array(':age' => 10));
	// Hello world, I\'m 10 years old
	
	// Now suppose we've switched to another language
	
	echo __('hello.myage', 1, array(':age' => 1));
	// Привет мир, мне уже 1 год
	echo __('hello.myage', 2, array(':age' => 2));
	// Привет мир, мне уже 2 года
	echo __('hello.myage', 10, array(':age' => 10));
	// Привет мир, мне уже 10 лет

Note how the 2nd and 3rd translations differ between the languages. For English, it's the same form ('years
old'), while in Russian the translations are totally different.

API
===

### class I18n\Core

#### public function attach(I18n\Reader\ReaderInterface $reader)

  * @param  I18n\Reader\ReaderInterface  $reader

This method takes a class instance that implements `I18n\Reader\ReaderInterface`. You'll implement your own
readers to provide translations from any source of your choice.

#### public function translate($string, $context, $values, $lang = NULL)

 * @param   string  $string   String to translate
 * @param   mixed   $context  String form or numeric count
 * @param   array   $values   Param values to insert
 * @param   string  $lang     Target language (optional)
 * @return  string

Translation/internationalization function with context support. The PHP function
[strtr](http://php.net/strtr) is used for replacing parameters.

	$i18n->translate(':count user is online', 1000, array(':count' => 1000));
	// 1000 users are online

#### public function form($string, $form = NULL, $lang = NULL)

 * @param   string  $string  String to translate
 * @param   string  $form    String context form, if NULL, looking for 'other' form, else the very first form
 * @param   string  $lang    Target language (optional)
 * @return  string

Returns specified form of a string translation. If no translation exists, the original string will be
returned. No parameters are replaced.

	$hello = $i18n->form('I\'ve met :name, he is my friend now.', 'fem');
	// I've met :name, she is my friend now.

#### public function plural($string, $count = 0, $lang = NULL)

 * @param   string  $string  String to translate
 * @param   mixed   $count   Integer context form, 0 by default
 * @param   string  $lang    Target language (optional)
 * @return  string

Returns translation of a string. If no translation exists, the original string will be returned.
No parameters are replaced.

	$hello = $i18n->plural('Hello, my name is :name and I have :count friend.', 10);
	// 'Hello, my name is :name and I have :count friends.'

### interface I18n\Reader\ReaderInterface

The Reader must be able to return an associative array, if more than one translation option is available.
The 'other' key has a special meaning of a default translation.

#### public function get($string, $lang = NULL)

 * @param   string   text to translate
 * @param   string   target language
 * @return  mixed

Returns translation of a string or array of translation options. No parameters are replaced. It is up
to the implementation where it gets it.

Testing
=======

Although a golden rule says you aren't supposed to test the 3rd party code (that's its authors' responsibility),
you may run it using this command from module's root directory:

	phpunit --bootstrap tests/I18n/bootstrap.php tests/I18n/
