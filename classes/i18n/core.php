<?php defined('SYSPATH') or die('No direct script access.');
/**
 * I18n_Core class
 * Extends Kohana_I18n class with get() and load() functions, that does recursive merging of language files
 * and use Arr::path to get values.
 *
 * Note: Create `class I18n extends I18n_Core{}` in your application
 *
 * @package    I18n_Core
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
class I18n_Core extends Kohana_I18n
{
	/**
	 * Returns translation of a string. If no translation exists, the original
	 * string will be returned. No parameters are replaced.
	 *
	 *     $hello = I18n::get('Hello friends, my name is :name');
	 *
	 * @param   string   text to translate
	 * @param   string   target language
	 * @return  string
	 */
	public static function get($string, $lang = NULL)
	{
		if ( ! $lang)
		{
			// Use the global target language
			$lang = I18n::$lang;
		}

		// Load the translation table for this language
		$table = I18n::load($lang);

		// Return the translated string if it exists
		if (isset($table[$string]))
		{
			return $table[$string];
		}
		elseif (($translation = Arr::path($table, $string)) !== NULL)
		{
			return $translation;
		}
		return $string;
	}

	/**
	 * Returns specified form of a string translation. If no translation exists, the original string will be
	 * returned. No parameters are replaced.
	 *
	 *     $hello = I18n::form('I\'ve met :name, he is my friend now.', 'f');
	 *     // 'I\'ve met :name, she is my friend now.'
	 *
	 * @param   string  $string
	 * @param   string  $form, if NULL, looking for 'other' form, else the very first form
	 * @param   string  $lang
	 * @return  string
	 */
	public static function form($string, $form = NULL, $lang = NULL)
	{
		$translation = self::get($string, $lang);
		if (is_array($translation))
		{
			if (array_key_exists($form, $translation))
			{
				return $translation[$form];
			}
			elseif (array_key_exists('other', $translation))
			{
				return $translation['other'];
			}
			return reset($translation);
		}
		return $translation;
	}

	/**
	 * Returns the translation table for a given language.
	 *
	 *     // Get all defined Spanish messages
	 *     $messages = I18n::load('es-es');
	 *
	 * @param   string  language to load
	 * @return  array
	 */
	public static function load($lang)
	{
		if (isset(I18n::$_cache[$lang]))
		{
			return I18n::$_cache[$lang];
		}

		// New translation table
		$table = array();

		// Split the language: language, region, locale, etc
		$parts = explode('-', $lang);

		do
		{
			// Create a path for this set of parts
			$path = implode(DIRECTORY_SEPARATOR, $parts);
			$files = Kohana::find_file('i18n', $path, NULL, TRUE);
			if ($files)
			{
				$tables = array();
				foreach ($files as $file)
				{
					// Merge the language strings into the sub table
					$tables = Arr::merge($tables, Kohana::load($file));
				}

				// Append the sub table, preventing less specific language
				// files from overloading more specific files
				$table += $tables;
			}

			// Remove the last part
			array_pop($parts);
		}
		while ($parts);

		// Cache the translation table locally
		return I18n::$_cache[$lang] = $table;
	}

	/**
	 * Returns translation of a string. If no translation exists, the original string will be
	 * returned. No parameters are replaced.
	 *
	 *     $hello = I18n::plural('Hello, my name is :name and I have :count friend.', 10);
	 *     // 'Hello, my name is :name and I have :count friends.'
	 *
	 * @param   string  $string
	 * @param   mixed   $count
	 * @param   string  $lang
	 * @return  string
	 */
	public static function plural($string, $count = 0, $lang = NULL)
	{
		// Get the translation form key
		$form = I18n_Plural::instance(I18n::$lang)
			->get_category($count);
		// Return the translation for that form
		return self::form($string, $form, $lang);
	}
}