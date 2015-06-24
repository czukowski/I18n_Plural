<?php
/**
 * Nette Translator adapter class
 * 
 * @package    I18n
 * @author     Korney Czukowski
 * @copyright  (c) 2013 Korney Czukowski
 * @license    MIT License
 */
namespace I18n;

class NetteTranslator implements \Nette\Localization\ITranslator
{
	/**
	 * @var  Core
	 */
	private $i18n;
	/**
	 * @var  string
	 */
	protected $default_lang;

	/**
	 * Instanciates a new I18n\Core object.
	 * 
	 * @param  string  $default_lang
	 */
	public function __construct($default_lang = 'x')
	{
		if (is_object($default_lang))
		{
			// For backward compatibility get the default lang value from context object.
			// Do not use this way if you can avoid it.
			$default_lang = isset($default_lang->parameters['defaultLocale'])
				? $default_lang->parameters['defaultLocale']
				: 'x';
		}
		$this->default_lang = $default_lang;
		$this->i18n = new Core;
	}

	/**
	 * Attach an i18n reader to a core object.
	 * 
	 * @param  \I18n\Reader\ReaderInterface  $reader
	 */
	public function attach(Reader\ReaderInterface $reader)
	{
		$this->i18n->attach($reader);
	}

	/**
	 * Nette localization interface adapter.
	 * 
	 * @param   string  $string
	 * @param   mixed   $count
	 * @return  string
	 */
	public function translate($string, $count = NULL)
	{
		// The func_num_args/func_get_arg jiggling is to overcome the ITranslator's limitation
		if (func_num_args() > 2)
		{
			$parameters = func_get_arg(2);
		}
		if ( ! isset($parameters))
		{
			$parameters = array();
		}
		if (func_num_args() > 3)
		{
			$lang = func_get_arg(3);
		}
		if ($count && is_array($count))
		{
			// If there's no context and parameters are in its place, shift the 3rd and 4th arguments.
			$lang = $parameters ? : NULL;
			$parameters = $count;
			$count = NULL;
		}
		if ( ! isset($lang))
		{
			$lang = $this->default_lang;
		}
		return $this->i18n->translate($string, $count, $parameters, $lang);
	}

	/**
	 * Retrieves the core object instance for direct usage.
	 * 
	 * @return  Core
	 */
	public function getService()
	{
		return $this->i18n;
	}
}