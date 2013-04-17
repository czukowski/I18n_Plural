<?php
/**
 * I18n Core class
 * 
 * @package    I18n
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace I18n;
use I18n\Plural;

class Core
{
	/**
	 * @var  array  I18n_Reader_Interface instances
	 */
	private $_readers = array();
	/**
	 * @var  array  Plural rules classes instances
	 */
	private $_rules = array();
	/**
	 * @var  Plural\Factory
	 */
	private $_plural_rules_factory;

	/**
	 * Attach an i18n reader
	 * 
	 * @param  I18n_Reader_Interface  $reader
	 */
	public function attach(Reader\ReaderInterface $reader)
	{
		$this->_readers[] = $reader;
	}

	/**
	 * Translation/internationalization function with context support.
	 * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
	 * 
	 *    $i18n->translate(':count user is online', 1000, array(':count' => 1000));
	 *    // 1000 users are online
	 * 
	 * @param   string  $string   String to translate
	 * @param   mixed   $context  String form or numeric count
	 * @param   array   $values   Param values to insert
	 * @param   string  $lang     Target language
	 * @return  string
	 */
	public function translate($string, $context, $values, $lang = NULL)
	{
		if (is_numeric($context))
		{
			// Get plural form
			$string = $this->plural($string, $context, $lang);
		}
		else
		{
			// Get custom form
			$string = $this->form($string, $context, $lang);
		}
		return empty($values) ? $string : strtr($string, $values);
	}

	/**
	 * Returns specified form of a string translation. If no translation exists, the original string will be
	 * returned. No parameters are replaced.
	 * 
	 *     $hello = $i18n->form('I\'ve met :name, he is my friend now.', 'fem');
	 *     // I've met :name, she is my friend now.
	 * 
	 * @param   string  $string
	 * @param   string  $form, if NULL, looking for 'other' form, else the very first form
	 * @param   string  $lang
	 * @return  string
	 */
	public function form($string, $form = NULL, $lang = NULL)
	{
		$translation = $this->get($string, $lang);
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
	 * Returns translation of a string. If no translation exists, the original string will be
	 * returned. No parameters are replaced.
	 * 
	 *     $hello = $i18n->plural('Hello, my name is :name and I have :count friend.', 10);
	 *     // Hello, my name is :name and I have :count friends.
	 * 
	 * @param   string  $string
	 * @param   mixed   $count
	 * @param   string  $lang
	 * @return  string
	 */
	public function plural($string, $count = 0, $lang = NULL)
	{
		// Get the translation form key
		$form = $this->plural_rules($lang)
			->plural_category($count);
		// Return the translation for that form
		return $this->form($string, $form, $lang);
	}

	/**
	 * Returns the translation from the first reader where it exists, or the input string
	 * if no translation is available.
	 * 
	 * @param   string  $string
	 * @param   string  $lang
	 * @return  string
	 */
	protected function get($string, $lang)
	{
		foreach ($this->_readers as $reader)
		{
			if (($translation = $reader->get($string, $lang)))
			{
				return $translation;
			}
		}
		return $string;
	}

	/**
	 * Plural rules lazy initialization
	 * 
	 * @param   string  $lang
	 * @return  Plural\Rules
	 */
	protected function plural_rules($lang)
	{
		if ( ! isset($this->_rules[$lang]))
		{
			// Get language code prefix
			$parts = explode('-', $lang, 2);
			$this->_rules[$lang] = $this->plural_rules_factory()
				->create_rules($parts[0]);
		}
		return $this->_rules[$lang];
	}

	/**
	 * @return  Plural\Factory
	 */
	protected function plural_rules_factory()
	{
		if ($this->_plural_rules_factory === NULL)
		{
			$this->_plural_rules_factory = new Plural\Factory;
		}
		return $this->_plural_rules_factory;
	}
}