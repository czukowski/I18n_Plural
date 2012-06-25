<?php
/**
 * I18n Reader Interface
 * 
 * @package    I18n_Reader
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
interface I18n_Reader_Interface {

	/**
	 * Returns the translation(s) of a string or NULL if there's no translation for the string.
	 * No parameters are replaced.
	 * 
	 * @param   string   text to translate
	 * @param   string   target language
	 * @return  mixed
	 */
	public function get($string, $lang = NULL);

}