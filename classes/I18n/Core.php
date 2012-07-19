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
	public function translate($string, $context, $values, $lang)
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
			$this->_rules[$lang] = $this->plural_rules_factory($parts[0]);
		}
		return $this->_rules[$lang];
	}

	/**
	 * Chooses inflection class to use according to CLDR plural rules
	 * 
	 * @param   string  $prefix
	 * @return  Plural\PluralInterface
	 */
	protected function plural_rules_factory($prefix)
	{
		if ($prefix == 'pl')
		{
			return new Plural\Polish;
		}
		elseif (in_array($prefix, array('cs', 'sk')))
		{
			return new Plural\Czech;
		}
		elseif (in_array($prefix, array('fr', 'ff', 'kab')))
		{
			return new Plural\French;
		}
		elseif (in_array($prefix, array('ru', 'sr', 'uk', 'sh', 'be', 'hr', 'bs')))
		{
			return new Plural\Balkan;
		}
		elseif (in_array($prefix, array(
			'en', 'ny', 'nr', 'no', 'om', 'os', 'ps', 'pa', 'nn', 'or', 'nl', 'lg', 'lb', 'ky', 'ml', 'mr',
			'ne', 'nd', 'nb', 'pt', 'rm', 'ts', 'tn', 'tk', 'ur', 'vo', 'zu', 'xh', 've', 'te', 'ta', 'sq',
			'so', 'sn', 'ss', 'st', 'sw', 'sv', 'ku', 'mn', 'et', 'eo', 'el', 'eu', 'fi', 'fy', 'fo', 'ee',
			'dv', 'bg', 'af', 'bn', 'ca', 'de', 'da', 'gl', 'es', 'it', 'is', 'ks', 'ha', 'kk', 'kl', 'gu',
			'brx', 'mas', 'teo', 'chr', 'cgg', 'tig', 'wae', 'xog', 'ast', 'vun', 'bem', 'syr', 'bez', 'asa',
			'rof', 'ksb', 'rwk', 'haw', 'pap', 'gsw', 'fur', 'saq', 'seh', 'nyn', 'kcg', 'ssy', 'kaj', 'jmc',
			'nah', 'ckb')))
		{
			return new Plural\One;
		}
		elseif ($prefix == 'mt')
		{
			return new Plural\Maltese;
		}
		elseif ($prefix == 'gv')
		{
			return new Plural\Manx;
		}
		elseif ($prefix == 'sl')
		{
			return new Plural\Slovenian;
		}
		elseif ($prefix == 'cy')
		{
			return new Plural\Welsh;
		}
		elseif ($prefix == 'ar')
		{
			return new Plural\Arabic;
		}
		elseif ($prefix == 'shi')
		{
			return new Plural\Tachelhit;
		}
		elseif ($prefix == 'tzm')
		{
			return new Plural\Tamazight;
		}
		elseif ($prefix == 'mk')
		{
			return new Plural\Macedonian;
		}
		elseif ($prefix == 'lt')
		{
			return new Plural\Lithuanian;
		}
		elseif ($prefix == 'he')
		{
			return new Plural\Hebrew;
		}
		elseif ($prefix == 'gd')
		{
			return new Plural\Gaelic;
		}
		elseif ($prefix == 'ga')
		{
			return new Plural\Irish;
		}
		elseif ($prefix == 'lag')
		{
			return new Plural\Langi;
		}
		elseif ($prefix == 'lv')
		{
			return new Plural\Latvian;
		}
		elseif ($prefix == 'br')
		{
			return new Plural\Breton;
		}
		elseif ($prefix == 'ksh')
		{
			return new Plural\Colognian;
		}
		elseif (in_array($prefix, array('mo', 'ro')))
		{
			return new Plural\Romanian;
		}
		elseif (in_array($prefix, array(
			'se', 'kw', 'iu', 'smn', 'sms', 'smj', 'sma', 'naq', 'smi')))
		{
			return new Plural\Two;
		}
		elseif (in_array($prefix, array(
			'hi', 'ln', 'mg', 'ak', 'tl', 'am', 'bh', 'wa', 'ti', 'guw', 'fil', 'nso')))
		{
			return new Plural\Zero;
		}
		elseif (in_array($prefix, array(
			'my', 'sg', 'ms', 'lo', 'kn', 'ko', 'th', 'to', 'yo', 'zh', 'wo', 'vi', 'tr', 'az', 'km', 'id',
			'ig', 'fa', 'dz', 'bm', 'bo', 'ii', 'hu', 'ka', 'jv', 'ja', 'kde', 'ses', 'sah', 'kea')))
		{
			return new Plural\None;
		}
		throw new \InvalidArgumentException('Unknown language prefix: '.$prefix.'.');
	}
}