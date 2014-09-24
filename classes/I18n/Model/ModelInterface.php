<?php
/**
 * The Model Interface.
 *
 * @package    I18n
 * @category   Plural Rules
 * @author     Korney Czukowski
 * @copyright  (c) 2014 Korney Czukowski
 * @license    MIT License
 */
namespace I18n\Model;

interface ModelInterface
{
	/**
	 * The only important function for the I18n model is the ability to cast to string.
	 */
	public function __toString();
}
