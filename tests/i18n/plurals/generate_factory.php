<?php
/**
 * This is a utility script, you don't need to run it under usual circumstances.
 * 
 * This script will update the plural rules factory in the I18n_Core class, based on the test files.
 * 
 * Must be run from the command line!
 * 
 * Takes one argument - the source classes/i18n/core.php, which must contain a method with a signature
 * `protected function plural_rules_factory($prefix)`.
 * 
 * By default it will output the code back to stdout, you should redirect it to some file, which will
 * then replace the source file itself (see usage - run the file without arguments). You wouldn't want
 * to output to the source file directly, because should any error occurr, it'll be replaced by the
 * error message.
 * 
 * @package    I18n
 * @author     Korney Czukowski
 * @copyright  (c) 2012 Korney Czukowski
 * @license    MIT License
 */
require_once __DIR__.'/application/bootstrap.php';

$args = $_SERVER['argv'];

call_user_func(function() use ($args) {

	$tokens = array(
		'function' => 'protected function plural_rules_factory($prefix)',
		'if_one' => "\t\t:elseif (\$prefix == ':locale')",
		'if_many' => "\t\t:elseif (in_array(\$prefix, array(:locales)))",
		'else' => "\t\tthrow new InvalidArgumentException('Unknown language prefix: '.\$prefix.'.');",
		'new_instance' => "\t\t\treturn new :class_name;",
		'line_width' => 90,
		'options' => array(
			'weighted' => array('en', 'fr', 'ru', 'cs', 'pl'),
			'weights' => array('en' => 100),
		),
		'usage' => "\n\nUsage:\nphp generate_factory.php <path_to_core.php> <path_to_plural_dir>\nphp generate_factory.php core.php plural\nphp generate_factory.php core.php plural > core.php",
	);

	if (strpos($args[0], 'phpunit'))
	{
		die('This file isn\'t supposed to be run as a unit test!'.$tokens['usage']);
	}
	else if ( ! isset($args[2]))
	{
		die('Too few arguments'.$tokens['usage']);
	}
	$source_file = realpath(__DIR__.'/'.$args[1]);
	if ( ! $source_file)
	{
		die('File "'.$args[1].'" not found'.$tokens['usage']);
	}
	$rules_dir = realpath(__DIR__.'/'.$args[2]);
	if ( ! $rules_dir)
	{
		die('"'.$args[1].'" is not a directory'.$tokens['usage']);
	}

	$output = array();

	// Find the start and end line number of the factory function
	$source_code = str_replace(array("\r\n", "\r"), "\n", file_get_contents($source_file));
	$source_lines = explode("\n", $source_code);
	$start_line = $end_line = NULL;
	$counter = 0;
	foreach ($source_lines as $num => $line)
	{
		if ($start_line === NULL AND trim($line, "\t ") == $tokens['function'])
		{
			$start_line = $num;
		}
		if ($start_line !== NULL AND $end_line === NULL AND preg_match('#[{}]#', $line))
		{
			$counter += strlen(preg_replace('#[^{]#', '', $line));
			$counter -= strlen(preg_replace('#[^}]#', '', $line));
			if ($counter === 0)
			{
				$end_line = $num;
			}
		}
	}

	// Sort locales and plural rules sets to potentially reduce number of compare operations for a factory
	// before a locale is matched to the corresponding rules set.
	$helper = new \Plurals\Tests\Generator($tokens['options']);
	$test_files = Kohana::list_files('classes/i18n/plural');
	foreach ($test_files as $file)
	{
		$helper->process_class('I18n_Plural_'.ucfirst(basename($file, EXT)));
	}
	$rules = $helper->get_rules();

	// This is a bit confusing function that tries to prevent code that requires horizontal scrolling
	function render_locales_array_condition($token, $locales, $line_width, $else)
	{
		$glue = "', '";
		$if_length = strlen(strtr($token, array(':locales' => '', ':else' => $else)));
		$array_length = strlen(implode($glue, $locales));
		if ($if_length + $array_length < $line_width)
		{
			$result = "'".implode($glue, $locales)."'";
		}
		else
		{
			$line_length = 0;
			$lines = array(array());
			$j = 0;
			for ($i = 0; $i < count($locales); $i++)
			{
				$line_length += strlen($locales[$i]);
				$lines[$j][] = $locales[$i];
				if (count($lines[$j]) > 0 AND $line_length + (count($lines[$j]) - 1) * strlen($glue) > $line_width)
				{
					$j += 1;
					$line_length = 0;
					$lines[$j] = array();
				}
			}
			foreach ($lines as &$line)
			{
				$line = "'".implode($glue, $line)."'";
			}
			$newline = "\n\t\t\t";
			$result = $newline.implode(','.$newline, $lines);
		}
		return strtr($token, array(':locales' => $result, ':else' => $else));
	}

	// Add the code before the function to the output
	for ($i = 0; $i <= $start_line; $i++)
	{
		$output[] = $source_lines[$i];
	}
	$output[] = "\t{";

	// Generate factory code and add it to the output
	$else = NULL;
	foreach ($rules as $class_name => $locales)
	{
		if (count($locales) === 1)
		{
			$output[] = strtr($tokens['if_one'], array(':locale' => reset($locales), ':else' => $else));
		}
		else
		{
			$output[] = render_locales_array_condition($tokens['if_many'], $locales, $tokens['line_width'], $else);
		}
		$else = 'else';

		$output[] = "\t\t{";
		$output[] = strtr($tokens['new_instance'], array(':class_name' => $class_name));
		$output[] = "\t\t}";
	}
	$output[] = $tokens['else'];

	// Add the code after the function to the output
	for ($i = $end_line; $i < count($source_lines); $i++)
	{
		$output[] = $source_lines[$i];
	}

	print_r(implode("\n", $output));
});