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
	 * @var  \Nette\DI\Container
	 */
	private $context;

	/**
	 * Instanciates a new I18n\Core object.
	 * 
	 * @param  \Nette\DI\Container  $context
	 */
	public function __construct(\Nette\DI\Container $context)
	{
		$this->context = $context;
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
	 * Does not support parameters replacement and uses default language.
	 * 
	 * @param   string  $string
	 * @param   mixed   $count
	 * @return  string
	 */
	public function translate($string, $count = NULL)
	{
		// Use the default language from nette config
		$lang = $this->context->parameters['defaultLocale'];
		return $this->i18n->translate($string, $count, array(), $lang);
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