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
	 * Returns translation of a string. No parameters are replaced.
	 * 
	 * @param   string   text to translate
	 * @param   string   target language
	 * @return  string
	 */
	public function get($string, $lang = NULL);

}