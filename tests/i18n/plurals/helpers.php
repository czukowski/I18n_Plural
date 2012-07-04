<?php
/**
 * This file contains some helper files for the unit tests
 * 
 * @package    Plurals
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
namespace Plurals\Tests;

/**
 * Test translation reader that returns predefined results
 */
class Reader implements \I18n_Reader_Interface {

	public $translations = array(
		'en' => array(
			':title person' => array(
				'some' => ':title person',
				'mr' => ':title man',
				'ms' => ':title woman',
			),
			':count countable' => array(
				'zero' => ':count countables',
				'one' => ':count countable',
				'two' => ':count countables',
				'three' => ':count countables',
				'other' => ':count countables',
			),
		),
		'es' => array(
			'Spanish' => 'Español',
		),
		'cs' => array(
			':title person' => array(
				'mr' => ':title muž',
				'ms' => ':title žena',
				'other' => ':title člověk',
			),
			'something :what' => 'něco :what',
		),
	);

	public function get($string, $lang = NULL)
	{
		if (isset($this->translations[$lang][$string]))
		{
			return $this->translations[$lang][$string];
		}
		return NULL;
	}
}

/**
 * Test plural rules that return predefined values
 */
class Rules implements \I18n_Plural_Interface {

	public $rules = array(
		0 => 'zero',
		1 => 'one',
		2 => 'two',
		3 => 'three',
	);

	public function plural_category($count)
	{
		return isset($this->rules[$count]) ? $this->rules[$count] : 'other';
	}
}

/**
 * Plural rules helper class
 */
class Generator {

	/**
	 * @var  array  Class options
	 */
	private $options = array(
		'default_weight' => 10,
		'weighted' => array(),
		'weights' => array(),
		'sort_locales' => array('_sort_string_length', '_sort_popular_locales'),
		'sort_rules' => array('_sort_popular_rules'),
	);
	/**
	 * @var  array  Plural rules class names and their locales
	 */
	private $rules = array();
	/**
	 * @var  array  Scores cache
	 */
	private $scores = array();

	/**
	 * @param  array  $options
	 */
	public function __construct(array $options)
	{
		$this->options = \Arr::overwrite($this->options, $options);
	}

	/**
	 * Sort and return plural rules
	 * 
	 * @return  array
	 */
	public function get_rules()
	{
		foreach ($this->rules as &$class_locales)
		{
			usort($class_locales, array($this, '_sort_locales'));
		}
		uasort($this->rules, array($this, '_sort_rules'));
		return $this->rules;
	}

	/**
	 * Sort locales within a class
	 */
	protected function _sort_locales($locale1, $locale2)
	{
		foreach ($this->options['sort_locales'] as $function)
		{
			if (($sort_function = $this->_sort_function($function)))
			{
				if (($compare_result = call_user_func($sort_function, $locale1, $locale2)) !== 0) {
					return $compare_result;
				}
			}
		}
		return 0;
	}

	/**
	 * Sort plural rules within a whole set
	 */
	protected function _sort_rules($locales1, $locales2)
	{
		$score = array();
		$locales = array($locales1, $locales2);
		foreach ($locales as $i => $rule)
		{
			$score[$i] = $this->_rules_score($rule);
		}
		if ($score[0] > $score[1])
		{
			return -1;
		}
		elseif ($score[0] < $score[1])
		{
			return 1;
		}
		return 0;
	}

	/**
	 * Calculates a total score for a rule
	 */
	private function _rules_score($locales)
	{
		$key = implode(',', $locales);
		if ( ! isset($this->scores[$key]))
		{
			$weight = 0;
			$total = count($locales);
			if ($total === 0)
			{
				return 0;
			}
			foreach ($locales as $locale)
			{
				if (in_array($locale, $this->options['weighted']))
				{
					$weight += \Arr::get($this->options['weights'], $locale, $this->options['default_weight']);
				}
				else
				{
					$weight += (1 / $total);
				}
			}
			$this->scores[$key] = $weight / $total;
		}
		return $this->scores[$key];
	}

	/**
	 * Sort by popular locales
	 */
	protected function _sort_popular_locales($item1, $item2)
	{
		if (in_array($item1, $this->options['weighted']))
		{
			return -1;
		}
		elseif (in_array($item2, $this->options['weighted']))
		{
			return 1;
		}
		return 0;
	}

	/**
	 * Sort by string length
	 */
	protected function _sort_string_length($item1, $item2)
	{
		$length_diff = strlen($item1) - strlen($item2);
		if ($length_diff > 0)
		{
			return 1;
		}
		elseif ($length_diff < 0)
		{
			return -1;
		}
		return 0;
	}

	/**
	 * @param   mixed    $function
	 * @return  callback
	 */
	private function _sort_function($function)
	{
		if ( ! is_callable($function))
		{
			$function = array($this, $function);
		}
		if ( ! is_callable($function))
		{
			return NULL;
		}
		return $function;
	}

	/**
	 * Retrieves locales in the plural rules class
	 * 
	 * @param  string  $classname
	 */
	public function process_class($classname)
	{
		if (($class_locales = $this->_class_locales($classname)))
		{
			$this->rules[$classname] = $class_locales;
		}
	}

	/**
	 * @param   string  $classname
	 * @return  array
	 */
	private function _class_locales($classname)
	{
		$comment = $this->_get_class_doc_comment($classname);
		$lines = $this->_split_doc_lines($comment);
		return $this->_read_locales($lines);
	}

	/**
	 * @param   string  $classname
	 * @return  array
	 */
	private function _get_class_doc_comment($classname)
	{
		// Get class phpDoc comments
		$comment = $this->_object_class_reflection($classname)
			->getDocComment();
		// Normalize newlines
		return str_replace(array("\r\n", "\r"), "\n", $comment);
	}

	/**
	 * @param   string  $classname
	 * @return  \ReflectionClass
	 */
	protected function _object_class_reflection($classname)
	{
		return new \ReflectionClass($classname);
	}

	/**
	 * @param   string  $string
	 * @return  array
	 */
	private function _split_doc_lines($string)
	{
		// Split to individual lines
		$lines = explode("\n", $string);
		// Remove first 3 characters at each line
		foreach ($lines as &$line)
		{
			$line = substr($line, 3);
		}
		return $lines;
	}

	/**
	 * @param   array  $lines
	 * @return  array
	 */
	private function _read_locales(array $lines)
	{
		$locales_label = 'Locales:';
		$found = FALSE;
		$return = array();
		foreach ($lines as $line)
		{
			if (strpos($line, $locales_label) === 0 AND $found === FALSE)
			{
				$found = TRUE;
				$line = substr($line, strlen($locales_label));
			}
			if ($found && trim($line) != '')
			{
				$return = array_merge($return, preg_split('#\s+?#', trim($line)));
			}
			if (trim($line) == '' AND $found)
			{
				break;
			}
		}
		return $return;
	}
}