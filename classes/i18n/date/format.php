<?php defined('SYSPATH') or die('No direct script access.');
/**
 * I18n_Date_Format class
 * Provides date formatting and translation methods to achieve consistency with MooTools Date.format()
 * I18n_Date_Format::format() based on MooTools Date.format()
 * @see http://github.com/mootools/mootools-more/blob/1.3wip/Source/Types/Date.js#L164
 *
 * @package    I18n_Plural
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
class I18n_Date_Format extends Kohana_Date
{
	/**
	 * Named formats
	 * @var array
	 */
	protected $_formats = array();
	/**
	 * @var int
	 */
	public $timestamp = 0;

	/**
	 * Constructor
	 * @param mixed $time
	 */
	public function __construct($time)
	{
		if (is_int($time))
		{
			$this->timestamp = $time;
		}
		elseif (is_string($time))
		{
			$this->timestamp = strtotime($time);
		}
		elseif ($time instanceof Format_Date)
		{
			$this->timestamp = $time->timestamp;
		}
		else
		{
			throw new Kohana_Exception('Unsupported time format');
		}

		$this->_formats = Kohana::config('plurals.date_formats');
	}

	/**
	 * Formats time
	 * @param string $format
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
			case 'a':  // short day ("Mon", "Tue")
				return $this->_get_abbr('days.abbr', date('w', $this->timestamp));
			case 'A':  // full day ("Monday")
				return $this->_get_abbr('days.other', date('w', $this->timestamp));
			case 'b':  // short month ("Jan", "Feb")
				return $this->_get_abbr('months.abbr', date('n', $this->timestamp) - 1);
			case 'B':  // full month ("January")
				return $this->_get_abbr('months.other', date('n', $this->timestamp) - 1);
			case 'c':  // the full date to string "Mon Dec 10 2007 14:35:42 GMT-0800 (Pacific Standard Time)"
				return $this->format('%a %b %d %H:%m:%S %Y');
			case 'C':  // workaround for full month in the genitive case (e.g. 'Январь' -> 'Января')
				return $this->_get_abbr('months.gen', date('n', $this->timestamp) - 1);
			case 'd':  // the date to two digits (01, 05, etc)
				return date('d', $this->timestamp);
			case 'D':  // a textual representation of a day, three letters
				       // XXX: non-compliant with MooTools Date.format()
				return date('D', $this->timestamp);
			case 'e':
				return str_pad(date('j', $this->timestamp), 2, ' ', STR_PAD_LEFT);
			case 'g':  // time format usable in HTTP headers
				       // XXX: non-compliant with MooTools Date.format()
				return gmdate('D, d M Y H:i:s', $this->timestamp).' GMT';
			case 'H':  // the hour to two digits in military time (24 hr mode) (01, 11, 14, etc)
				return date('H', $this->timestamp);
			case 'I':  // the hour in 12 hour time (1, 11, 2, etc)
				return date('g', $this->timestamp);
			case 'j':  // the day of the year to three digits (001 is Jan 1st)
				return str_pad(date('z', $this->timestamp), 3, '0', STR_PAD_LEFT);
			case 'k':
				return str_pad(date('G', $this->timestamp), 2, ' ', STR_PAD_LEFT);
			case 'l':
				return str_pad(date('g', $this->timestamp), 2, ' ', STR_PAD_LEFT);
			case 'L':  // milliseconds (timestamp donesn't have milliseconds)
				return '000';
			case 'm':  // the numerical month to two digits (01 is Jan, 12 is Dec)
				return date('m', $this->timestamp);
			case 'M':  // the minutes to two digits (01, 40, 59)
				return date('i', $this->timestamp);
			case 'N':  // Localized accusative case of week day name
				       // XXX: non-compliant with MooTools Date.format()
				return $this->_get_abbr('days.acc', date('N', $this->timestamp) - 1);
			case 'o':  // the ordinal of the day of the month in the current language ("st" for the 1st, "nd" for the 2nd, etc.)
				       // TODO: I18n? probably not
				return date('jS', $this->timestamp);
			case 'p':  // The current language equivalent of either AM or PM
				return ___('date.'.(date('G', $this->timestamp) < 12 ? 'am' : 'pm'));
			case 'r':  // XXX: Added to workaround localization of RFC2822 date format
				return date('r', $this->timestamp);
			case 's':
				return $this->timestamp;
			case 'S':  // the seconds to two digits (01, 40, 59)
				return date('s', $this->timestamp);
			case 'T':  // the GMT offset ("-08:00")
				       // XXX: non-compliant with MooTools Date.format()
				return date('P', $this->timestamp);
			case 'U':  // the week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)
				return date('W', $this->timestamp);
			case 'w':  // the numerical day of the week, one digit (0 is Sunday, 1 is Monday)
				return date('N', $this->timestamp);
			case 'x':  // the date in the current language prefered format. en-US: %m/%d/%Y (12/10/2007)
				return $this->format(___('date.date.short'));
			case 'X':  // the time in the current language prefered format. en-US: %I:%M%p (02:45PM)
				return $this->format(___('date.time.short'));
			case 'y':  // the short year (two digits; "07")
				return date('y', $this->timestamp);
			case 'Y':  // the full year (four digits; "2007")
				return date('Y', $this->timestamp);
			case 'z':  // the GMT offset ("-0800")
				return date('O', $this->timestamp);
			case 'Z':  // the time zone ("GMT")
				return date('T', $this->timestamp);
			case '%':
				return '%';
		}
	}

	/**
	 * @param string $abbr
	 * @param int $index
	 */
	protected function _get_abbr($abbr, $index)
	{
		$string = I18n::get('date.'.$abbr);
		return $string[$index];
	}
}