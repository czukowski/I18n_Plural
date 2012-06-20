<?php defined('SYSPATH') or die('No direct script access.');
/**
 * I18n_Core class
 * 
 * @package    I18n
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
class I18n_Core
{
	private static $instance;
	/**
	 * @var  I18n_Reader_Interface
	 */
	private $reader;
	/**
	 * @var  array  Plural rules classes instances
	 */
	private $rules = array();

	/**
	 * Singleton access
	 * 
	 * @return  I18n_Core
	 */
	public static function instance()
	{
		if (self::$instance !== NULL)
		{
			return self::$instance;
		}
		throw new RuntimeException('I18n_Core is not initialized');
	}

	/**
	 * Class constructor enables singleton access
	 * 
	 * @param  I18n_Reader_Interface  $reader
	 */
	public function __construct(I18n_Reader_Interface $reader)
	{
		$this->reader = $reader;
		self::$instance = $this;
	}

	/**
	 * Class destructor removes the singleton access
	 */
	public function __destruct()
	{
		self::$instance = NULL;
	}

	/**
	 * Returns specified form of a string translation. If no translation exists, the original string will be
	 * returned. No parameters are replaced.
	 * 
	 *     $hello = $i18n->form('I\'ve met :name, he is my friend now.', 'f');
	 *     // 'I\'ve met :name, she is my friend now.'
	 * 
	 * @param   string  $string
	 * @param   string  $form, if NULL, looking for 'other' form, else the very first form
	 * @param   string  $lang
	 * @return  string
	 */
	public function form($string, $form = NULL, $lang = NULL)
	{
		$translation = $this->reader->get($string, $lang);
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
	 *     // 'Hello, my name is :name and I have :count friends.'
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
			->get_category($count);
		// Return the translation for that form
		return $this->form($string, $form, $lang);
	}

	/**
	 * Plural rules lazy initialization
	 * 
	 * @param   string  $lang
	 * @return  I18n_Plural_Rules
	 */
	protected function plural_rules($lang)
	{
		if ( ! isset($this->rules[$lang]))
		{
			// Get language code prefix
			$parts = explode('-', $lang, 2);
			$this->rules[$lang] = $this->plural_rules_factory($parts[0]);
		}
		return $this->rules[$lang];
	}

	/**
	 * Chooses inflection class to use according to CLDR plural rules
	 * 
	 * @param   string  $prefix
	 * @return  I18n_Plural_Rules
	 */
	protected function plural_rules_factory($prefix)
	{
		// Choose class
		if (in_array($prefix, array(
			'bem', 'brx', 'da', 'de', 'el', 'en', 'eo', 'es', 'et', 'fi', 'fo', 'gl', 'he', 'iw', 'it', 'nb',
			'nl', 'nn', 'no', 'sv', 'af', 'bg', 'bn', 'ca', 'eu', 'fur', 'fy', 'gu', 'ha', 'is', 'ku',
			'lb', 'ml', 'mr', 'nah', 'ne', 'om', 'or', 'pa', 'pap', 'ps', 'so', 'sq', 'sw', 'ta', 'te',
			'tk', 'ur', 'zu', 'mn', 'gsw', 'chr', 'rm', 'pt')))
		{
			return new I18n_Plural_One;
		}
		elseif (in_array($prefix, array('cs', 'sk')))
		{
			return new I18n_Plural_Czech;
		}
		elseif (in_array($prefix, array('ff', 'fr', 'kab')))
		{
			return new I18n_Plural_French;
		}
		elseif (in_array($prefix, array('hr', 'ru', 'sr', 'uk', 'be', 'bs', 'sh')))
		{
			return new I18n_Plural_Balkan;
		}
		elseif ($prefix == 'lv')
		{
			return new I18n_Plural_Latvian;
		}
		elseif ($prefix == 'lt')
		{
			return new I18n_Plural_Lithuanian;
		}
		elseif ($prefix == 'pl')
		{
			return new I18n_Plural_Polish;
		}
		elseif (in_array($prefix, array('ro', 'mo')))
		{
			return new I18n_Plural_Romanian;
		}
		elseif ($prefix == 'sl')
		{
			return new I18n_Plural_Slovenian;
		}
		elseif ($prefix == 'ar')
		{
			return new I18n_Plural_Arabic;
		}
		elseif ($prefix == 'mk')
		{
			return new I18n_Plural_Macedonian;
		}
		elseif ($prefix == 'cy')
		{
			return new I18n_Plural_Welsh;
		}
		elseif ($prefix == 'br')
		{
			return new I18n_Plural_Breton;
		}
		elseif ($prefix == 'lag')
		{
			return new I18n_Plural_Langi;
		}
		elseif ($prefix == 'shi')
		{
			return new I18n_Plural_Tachelhit;
		}
		elseif ($prefix == 'mt')
		{
			return new I18n_Plural_Maltese;
		}
		elseif (in_array($prefix, array('ga', 'se', 'sma', 'smi', 'smj', 'smn', 'sms')))
		{
			return new I18n_Plural_Two;
		}
		elseif (in_array($prefix, array('ak', 'am', 'bh', 'fil', 'tl', 'guw', 'hi', 'ln', 'mg', 'nso', 'ti', 'wa')))
		{
			return new I18n_Plural_Zero;
		}
		elseif (in_array($prefix, array(
			'az', 'bm', 'fa', 'ig', 'hu', 'ja', 'kde', 'kea', 'ko', 'my', 'ses', 'sg', 'to',
			'tr', 'vi', 'wo', 'yo', 'zh', 'bo', 'dz', 'id', 'jv', 'ka', 'km', 'kn', 'ms', 'th')))
		{
			return new I18n_Plural_None;
		}
		throw new Kohana_Exception('Unknown language prefix: :prefix.', array(':prefix' => $prefix));
	}
}