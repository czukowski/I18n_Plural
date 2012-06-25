<?php defined('SYSPATH') or die('No direct script access.');
/**
 * I18n_Date_Format class
 * Provides date formatting and translation methods to achieve consistency with MooTools Date.format()
 * I18n_Date_Format::format() based on MooTools Date.format()
 * @see http://github.com/mootools/mootools-more/blob/1.3wip/Source/Types/Date.js#L164
 *
 * @package    I18n_Plural
 * @category   Date Formatting
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
class I18n_Date_Format extends Kohana_Date
{
	/**
	 * @var  array  Named formats
	 */
	protected $_formats = array();
	/**
	 * @var  integer
	 */
	protected $_timestamp = 0;

	/**
	 * @param  mixed  $time
	 */
	public function __construct($time)
	{
		if (is_int($time))
		{
			$this->_timestamp = $time;
		}
		elseif (is_string($time))
		{
			$this->_timestamp = strtotime($time);
		}
		else
		{
			throw new Kohana_Exception('Unsupported time format');
		}
		$this->_formats = Kohana::$config->load('plurals.date_formats');
	}

	/**
	 * Formats time
	 * 
	 * @param  string  $format
	 */
	public function format($format = NULL)
	{
		if ($format === NULL)
		{
			$format = '%x %X';
		}
		// Replace short-hand with actual format
		if (array_key_exists($format, $this->_formats))
		{
			$format = $this->_formats[$format];
		}
		return preg_replace_callback('#%([a-z%])#i', array($this, '_replace_format'), $format);
	}

	/**
	 * Callback to replace format
	 * @param array $match
	 */
	public function _replace_format($match)
	{
		switch ($match[1])
		{
			case 'a':  // Short day ("Mon", "Tue")
				return $this->_get_item(date('w', $this->_timestamp), 'days', 'abbr');
			case 'A':  // Full day ("Monday")
				return $this->_get_item(date('w', $this->_timestamp), 'days');
			case 'b':  // Short month ("Jan", "Feb")
				return $this->_get_item(date('n', $this->_timestamp) - 1, 'months', 'abbr');
			case 'B':  // Full month ("January")
				return $this->_get_item(date('n', $this->_timestamp) - 1, 'months', 'other');
			case 'c':  // The full date to string "Mon Dec 10 2007 14:35:42 GMT-0800 (Pacific Standard Time)"
				return $this->format('%a %b %d %H:%m:%S %Y');
			case 'C':  // Full month in the genitive case (e.g. 'Январь' -> 'Января')
				       // Non-compliant with MooTools Date.format()
				return $this->_get_item(date('n', $this->_timestamp) - 1, 'months', 'gen');
			case 'd':  // The date to two digits (01, 05, etc)
				return date('d', $this->_timestamp);
			case 'D':  // 3-letter, non-localized textual representation of a day (Mon, Tue)
				       // Non-compliant with MooTools Date.format()
				return date('D', $this->_timestamp);
			case 'e':  // Day of the month without leading zeros
				return str_pad(date('j', $this->_timestamp), 2, ' ', STR_PAD_LEFT);
			case 'g':  // Time format usable in HTTP headers
				       // Non-compliant with MooTools Date.format()
				return gmdate('D, d M Y H:i:s', $this->_timestamp).' GMT';
			case 'H':  // The hour to two digits in military time (24 hr mode) (01, 11, 14, etc)
				return date('H', $this->_timestamp);
			case 'I':  // The hour in 12 hour time (1, 11, 2, etc)
				       // Note that for 00:xx:xx the 12hr format is 12:xx (am)
				return date('g', $this->_timestamp);
			case 'j':  // The day of the year to three digits (001 is Jan 1st)
				return str_pad(date('z', $this->_timestamp), 3, '0', STR_PAD_LEFT);
			case 'k':  // The hour (24-hour clock) as a digit (range 0 to 23).
				       // Single digits are preceded by a blank space.
				return str_pad(date('G', $this->_timestamp), 2, ' ', STR_PAD_LEFT);
			case 'l':  // The hour (12-hour clock) as a digit (range 1 to 12).
				       // Single digits are preceded by a blank space.
				return str_pad(date('g', $this->_timestamp), 2, ' ', STR_PAD_LEFT);
			case 'L':  // Milliseconds (timestamp donesn't have milliseconds)
				return '000';
			case 'm':  // The numerical month to two digits (01 is Jan, 12 is Dec)
				return date('m', $this->_timestamp);
			case 'M':  // The minutes to two digits (01, 40, 59)
				return date('i', $this->_timestamp);
			case 'N':  // Localized accusative case of week day name
				       // Non-compliant with MooTools Date.format()
				return $this->_get_item(date('w', $this->_timestamp), 'days', 'acc');
			case 'o':  // Non-local. The ordinal of the day of the month
				       // ("st" for the 1st, "nd" for the 2nd, etc.)
				return date('jS', $this->_timestamp);
			case 'p':  // The current language equivalent of either AM or PM
				return ___('date.'.(date('G', $this->_timestamp) < 12 ? 'am' : 'pm'));
			case 'P':  // The GMT offset ("-08:00")
				       // Non-compliant with MooTools Date.format()
				return date('P', $this->_timestamp);
			case 'r':  // Added to workaround localization of RFC2822 date format
				return date('r', $this->_timestamp);
			case 's':
				return $this->_timestamp;
			case 'S':  // The seconds to two digits (01, 40, 59)
				return date('s', $this->_timestamp);
			case 'U':  // The week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)
				return date('W', $this->_timestamp);
			case 'w':  // The numerical day of the week, one digit (0 is Sunday, 1 is Monday)
				return date('w', $this->_timestamp);
			case 'x':  // The date in the current language prefered format. en-US: %m/%d/%Y (12/10/2007)
				return $this->format(___('date.date.short'));
			case 'X':  // The time in the current language prefered format. en-US: %I:%M%p (02:45PM)
				return $this->format(___('date.time.short'));
			case 'y':  // The short year (two digits; "07")
				return date('y', $this->_timestamp);
			case 'Y':  // The full year (four digits; "2007")
				return date('Y', $this->_timestamp);
			case 'z':  // The GMT offset ("-0800")
				return date('O', $this->_timestamp);
			case 'Z':  // The time zone ("GMT")
				return date('T', $this->_timestamp);
			case '%':
				return '%';
		}
	}

	/**
	 * @param  integer  $index
	 * @param  string   $path
	 * @param  string   $form
	 */
	protected function _get_item($index, $path, $form = NULL)
	{
		$string = ___('date.'.$path, $form);
		return $string[$index];
	}
}