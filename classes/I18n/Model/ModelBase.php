<?php
/**
 * The Base Model class.
 *
 * @package    I18n
 * @category   Models
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;
use I18n;

abstract class ModelBase implements ModelInterface
{
	/**
	 * @var  mixed
	 */
	private $_context;
	/**
	 * @var  I18n\Core
	 */
	private $_i18n;
	/**
	 * @var  string
	 */
	private $_lang;
	/**
	 * @var  array
	 */
	private $_parameters = array();

	/**
	 * This function is to implement the translation by calling the core object
	 * with the calculated arguments.
	 * 
	 * @return  string
	 */
	abstract public function translate();

	/**
	 * Translation context getter and setter.
	 * 
	 * @param   mixed  $context
	 * @return  $this|mixed
	 */
	public function context($context = NULL)
	{
		if ( ! func_num_args())
		{
			return $this->_context;
		}
		$this->_context = $context;
		return $this;
	}

	/**
	 * Translation 'core' object getter and setter.
	 * 
	 * @param   I18n\Core $i18n
	 * @return  $this|I18n\Core
	 * @throws  \LogicException
	 */
	public function i18n(I18n\Core $i18n = NULL)
	{
		if (func_num_args() > 0)
		{
			$this->_i18n = $i18n;
			return $this;
		}
		elseif ($this->_i18n instanceof I18n\Core)
		{
			return $this->_i18n;
		}
		throw new \LogicException('I18n Core object not set.');
	}

	/**
	 * Translation destination language getter and setter.
	 * 
	 * @param   string  $lang
	 * @return  $this|string
	 */
	public function lang($lang = NULL)
	{
		if ( ! func_num_args())
		{
			return $this->_lang;
		}
		$this->_lang = $lang;
		return $this;
	}

	/**
	 * Specific parameter getter and setter.
	 * 
	 * @param   string  $key
	 * @param   mixed   $value
	 * @return  $this|mixed
	 */
	public function parameter($key, $value = NULL)
	{
		if (func_num_args() === 1)
		{
			if ( ! array_key_exists($key, $this->_parameters))
			{
				throw new \InvalidArgumentException('Parameter not set: '.$key);
			}
			return $this->_parameters[$key];
		}
		$this->_parameters[$key] = $value;
		return $this;
	}

	/**
	 * All parameters getter and setter.
	 * 
	 * @param   array  $values
	 * @return  $this|array
	 */
	public function parameters($values = array())
	{
		if ( ! func_num_args())
		{
			return $this->_parameters;
		}
		$this->_parameters = (array) $values;
		return $this;
	}

	/**
	 * Parameter getter with the default value fallback.
	 */
	protected function _parameter_default($key, $default = NULL)
	{
		if ( ! array_key_exists($key, $this->_parameters))
		{
			return $default;
		}
		return $this->_parameters[$key];
	}

	/**
	 * Try and call the main 'to string' function.
	 * `__toString` method must not throw exceptions, just return empty string in case of error.
	 * 
	 * @return  string
	 */
	public function __toString()
	{
		try
		{
			return $this->translate();
		}
		catch (\Exception $e)
		{
			return '';
		}
	}
}
