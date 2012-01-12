<?php defined('SYSPATH') or die('No direct script access.');
/**
 * I18n_Validation class
 * Attempts to provide grammatically accurate error translations, where plurals are involved
 * The I18n_Validation::errors() method is a slightly modified original Kohana_Validation::errors()
 * 
 * @package    I18n_Plural
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
class I18n_Validation extends Kohana_Validation
{
	/**
	 * Returns the error messages. If no file is specified, the error message
	 * will be the name of the rule that failed. When a file is specified, the
	 * message will be loaded from "field/rule", or if no rule-specific message
	 * exists, "field/default" will be used. If neither is set, the returned
	 * message will be "file/field/rule".
	 *
	 * By default all messages are translated using the default language.
	 * A string can be used as the second parameter to specified the language
	 * that the message was written in.
	 *
	 *     // Get errors from messages/forms/login.php
	 *     $errors = $validate->errors('forms/login');
	 *
	 * @uses    Kohana::message
	 * @param   string  file to load error messages from
	 * @param   mixed   translate the message
	 * @return  array
	 */
	public function errors($file = NULL, $translate = TRUE)
	{
		if ($file === NULL)
		{
			// Return the error list
			return $this->_errors;
		}

		// Create a new message list
		$messages = array();

		foreach ($this->_errors as $field => $set)
		{
			list($error, $params) = $set;

			// Get the label for this field
			$label = $this->label($field, NULL, $translate);

			// Start the translation values list
			$values = array(
				':field' => $label,
				':value' => $this->_field_value_parameter($field),
			);

			$context = NULL;
			if ($params)
			{
				foreach ($params as $key => $value)
				{
					// Objects cannot be used in message files
					if (is_object($value))
					{
						continue;
					}

					// All values must be strings
					$value = $this->_parameter_to_string($value);

					// Check if a label for this parameter exists
					if (isset($this->_labels[$value]))
					{
						// Use the label as the value, eg: related field name for "matches"
						$value = $this->_translate($this->_labels[$value], NULL, array(), $translate);
					}

					// Add each parameter as a numbered value, starting from 1
					$values[':param'.($key + 1)] = $value;

					// Starting from 2nd parameter, detect context (1st is validation context)
					if ($context === NULL AND $key > 0 AND is_numeric($value))
					{
						$context = $value;
					}
				}
			}

			$path = "{$file}.{$field}.{$error}";
			if ( (bool) ($message = Kohana::message($file, "{$field}.{$error}")))
			{
				// Found a message for this field and error
			}
			elseif ( (bool) ($message = Kohana::message($file, "{$field}.default")))
			{
				// Found a default message for this field
			}
			elseif ( (bool) ($message = Kohana::message($file, $error)))
			{
				// Found a default message for this error
			}
			elseif ($translate)
			{
				// No message exists
				$message = NULL;
			}
			else
			{
				$message = $path;
			}

			if ($translate)
			{
				if ($message !== NULL)
				{
					$translated = $this->_translate($message, $context, $values, $translate);
				}
				elseif (($translated = $this->_translate($path, $context, $values, $translate)) != $path)
				{
					// Found path translation
				}
				elseif (($translated = $this->_translate('valid.'.$error, $context, $values, $translate)) != 'valid.'.$error)
				{
					// Found a default translation for this error
				}
				elseif ( (bool) ($message = Kohana::message('validate', $error)))
				{
					// Found a default message for this error
					$translated = $this->_translate($message, $context, $values, $translate);
				}
				else
				{
					$translated = $path;
				}
				$message = $translated;
			}
			else
			{
				// Do not translate, just replace the values
				$message = strtr($message, $values);
			}

			// Set the message for this field
			$messages[$field] = $message;
		}

		return $messages;
	}

	private function _parameter_to_string($param)
	{
		if (is_array($param))
		{
			// All values must be strings
			$param = implode(', ', Arr::flatten($param));
		}
		return $param;
	}

	private function _field_value_parameter($field)
	{
		return $this->_parameter_to_string(Arr::get($this, $field));
	}

	/**
	 * Returns field label, optionally untranslated
	 * 
	 * @param   string   $field
	 * @param   boolean  $translate
	 * @return  string
	 */
	public function label($field, $label = NULL, $translate = TRUE)
	{
		if ($label !== NULL)
		{
			// Set label
			return parent::label($field, $label);
		}
		// Get label
		return $this->_translate($this->_labels[$field], NULL, array(), $translate);
	}

	/**
	 * Uses `___()` function to translate any text
	 * 
	 * @param   string   $string
	 * @param   string   $context
	 * @param   array    $values
	 * @param   string   $lang
	 * @return  string
	 */
	protected function _translate($string, $context = 0, $values = NULL, $lang = NULL)
	{
		if ($lang === TRUE)
		{
			// Use current language
			$lang = NULL;
		}
		return ___($string, $context, $values, $lang);
	}
}