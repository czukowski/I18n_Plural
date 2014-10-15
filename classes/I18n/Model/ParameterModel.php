<?php
/**
 * Parametrized Model class.
 * 
 * Implements default `translate()` function for the simpler translation needs,
 * that can be configured in subclasses' property named `$_translate` or using
 * `initialize()` method.
 * 
 * The `$_translate` property is array of arrays, each defining arguments
 * that may be passed to the `translate()` function directly, then falling
 * back to the model's parameter, context or lang and finally, falling back
 * to the default values from the `$_translate` definition.
 * 
 * The valid formats can be defined as follows:
 * 
 *     [
 *         ['context', default value],
 *         ['lang', default value],
 *         ['string', preset value],
 *         ['parameter', parameter name, default value],
 *         ['parameter', parameter name],
 *     ]
 * 
 * Each defining argument goes in the order they might be passed to `translate()`
 * function. Take care of this order if you ever call the `translate()` function
 * directly, as all arguments are optional!
 * 
 * Note the special case, where 'parameter' does not have the default value.
 * This is especially for substituting context to a parameter value. For this reason
 * it's suggested that such context parameters are defined at the end. Such parameters
 * will be ignored if passed to `translate()` function.
 * 
 * The first element of each argument array is a literal string: 'context', 'lang',
 * 'parameter' or 'string'. It makes sense to have only one 'context', 'lang', and
 * 'string' definition, because in case of multiple definitions, the latter value
 * will always overwrite the former.
 * 
 * @package    I18n
 * @category   Models
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class ParameterModel extends ModelBase
{
	const CONTEXT = 'context';
	const LANG = 'lang';
	const PARAMETER = 'parameter';
	const STRING = 'string';
	/**
	 * @var  array  Parameter keys that are replaced by context.
	 */
	private $_context_params;
	/**
	 * @var  string  Pre-defined translation string.
	 */
	private $_string;
	/**
	 * @var  array  Translate function arguments description.
	 */
	protected $_translate = array();

	/**
	 * Initialize translation data by validating and then setting `$_translate` property.
	 * 
	 * @param   array  $translate
	 * @return  $this
	 */
	public function initialize($translate)
	{
		$contexts = array();
		foreach ($translate as $order => $element)
		{
			$this->_validate_element($element, $order);
			$key = reset($element);
			if ($key === self::PARAMETER && count($element) === 2 && ($parameter = next($element)) && ! in_array($parameter, $contexts))
			{
				// Special case of 'parameter' definition without default value means that the
				// context is substituted.
				$contexts[] = $parameter;
			}
		}
		$this->_context_params = $contexts;
		$this->_translate = $translate;
		return $this;
	}

	/**
	 * Validates that translate element conforms to the specification.
	 * 
	 * @param   array    $element   N-th argument definition from `$_translate` property.
	 * @param   integer  $position  argument position (N)
	 * @throws  \InvalidArgumentException
	 */
	private function _validate_element($element, $position)
	{
		$key = reset($element);
		$allowed_keys = array(self::CONTEXT, self::LANG, self::PARAMETER, self::STRING);
		if ( ! in_array($key, $allowed_keys))
		{
			throw new \InvalidArgumentException('Translation definition "'.$key.'" expected to be one of "'.implode('", "', $allowed_keys).'", "'.$key.'" found.');
		}
		$elements_count = count($element);
		if ($key !== self::PARAMETER && $elements_count !== 2)
		{
			throw new \InvalidArgumentException('Translation definition "'.$key.'" expected to have 2 elements, '.$elements_count.' found.');
		}
		elseif ($key === self::PARAMETER && ($elements_count < 2 || $elements_count > 3))
		{
			throw new \InvalidArgumentException('Translation definition "'.$key.'" at position '.($position + 1).' expected to have 2 or 3 elements, '.$elements_count.' found.');
		}
	}

	/**
	 * Translation string getter and setter. This makes sense here for 'parametrized'
	 * translation logic for changing translation string on-the-fly.
	 * 
	 * @param   string  $string
	 * @return  $this|string
	 */
	public function string($string = NULL)
	{
		if (func_num_args() === 0)
		{
			return $this->_string;
		}
		$this->_string = $string;
		return $this;
	}

	/**
	 * Parametrized translation method. Provides 'automatic' translation using
	 * method arguments, model state and default values.
	 * 
	 * @return  string
	 */
	public function translate()
	{
		$arguments = func_get_args();

		// Default translation parameters.
		$translate = array(
			'context' => $this->context(),
			'lang' => $this->lang(),
			'parameters' => $this->parameters(),
			'string' => $this->string(),
		);

		// Populate `$translate` variable with function arguments and/or model state.
		foreach ($this->_translate as $i => $element)
		{
			$this->_setup_element($translate, $element, $i, $arguments);
		}
		// Now that the basic data have been set, parameters that need to have context values.
		foreach ($this->_context_params as $parameter)
		{
			$translate['parameters'][$parameter] = $translate[self::CONTEXT];
		}

		// Translate using the populated data.
		return $this->i18n()
			->translate($translate['string'], $translate['context'], $translate['parameters'], $translate['lang']);
	}

	/**
	 * Determine translation property values from `translate()` function arguments and using
	 * fallback logic described in the class header.
	 * 
	 * @param  array    $translate  translation parts array that will be used in translation.
	 * @param  array    $element    N-th argument definition from `$_translate` property.
	 * @param  integer  $position   argument position (N)
	 * @param  array    $arguments  `translate()` function arguments.
	 */
	private function _setup_element(&$translate, $element, $position, $arguments)
	{
		$key = array_shift($element);
		$arguments_count = count($arguments);
		$element_count = count($element);
		if ($key !== self::PARAMETER)
		{
			// The key is 'context', 'lang' or 'string'. They've already been pre-initialized
			// from the model state and should only be replaced by `translate()` function
			// direct arguments or translate parameters default values.
			$translate[$key] = $position < $arguments_count
				? $arguments[$position]
				: ($translate[$key] === NULL ? array_shift($element) : $translate[$key]);
		}
		elseif ($key === self::PARAMETER && $element_count === 2)
		{
			// If `translate()` function argument at the current position has been passed, then
			// use it as parameter value, else use set parameter, fallback to preset default.
			list ($parameter, $default) = $element;
			$translate['parameters'][$parameter] = $position < $arguments_count
				? $arguments[$position]
				: $this->_parameter_default($parameter, $default);
		}
	}
}
