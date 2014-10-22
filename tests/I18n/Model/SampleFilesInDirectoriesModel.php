<?php
/**
 * Sample Model for translating 'found X files in Y directories' string.
 * 
 * The translate method arguments must be optional, in order to be compatible with base model!
 * The model's use of `translate()` method arguments should be secondary, because this alone
 * would not work if the model is casted as string!
 * 
 * Acts as a slightly advanced usage example.
 * 
 * Note that this model extends `ParametrizedModel` which is another usage example.
 * 
 * @package    I18n
 * @category   Unit tests
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

class SampleFilesInDirectoriesModel extends ModelBase
{
	/**
	 * @return  string
	 */
	public function translate($files_count = NULL, $directories_count = NULL, $lang = NULL)
	{
		// Get target language from argument, if passed.
		if (func_num_args() < 3)
		{
			$lang = $this->lang();
		}
		if ($files_count === NULL)
		{
			$files_count = $this->_parameter_default('files_count', 0);
		}
		if ($directories_count === NULL)
		{
			$directories_count = $this->_parameter_default('directories_count', 0);
		}
		// Translate strings.
		$files = $this->i18n()
			->translate('files_found', $files_count, array(':count' => $files_count), $lang);
		$directories = $this->i18n()
			->translate('in_directories', $directories_count, array(':count' => $directories_count), $lang);
		// Combine and return strings. Not the best possible approach to just concat the parts,
		// but it'll have to do for the example purposes.
		return "$files $directories";
	}
}
