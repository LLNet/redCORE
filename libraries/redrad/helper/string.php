<?php
/**
 * @package     RedRad
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_REDRAD') or die;

/**
 * String helper class.
 *
 * @package     RedRad
 * @subpackage  Helper
 * @since       1.0
 */
final class RHelperString
{
	/**
	 * Function to convert a string or array into a single string
	 *
	 * @param   mixed   $values        Array or string to use as values
	 * @param   string  $filter        Filter to apply to the values to quote or (int) them
	 * @param   array   $removeValues  Items to remove/filter from the source array
	 *
	 * @return  string
	 */
	public static function multipleSanitised($values, $filter = 'integer', $removeValues = array(''))
	{
		$db = JFactory::getDbo();

		// Extra verification to avoid null values
		if (is_null($values))
		{
			return false;
		}

		if (!is_array($values))
		{
			// Convert comma separated values to arrays
			$values = (array) explode(',', $values);
		}

		// If all is selected remove filter
		if (in_array('*', $values))
		{
			return null;
		}

		// Remove undesired source values
		if (!empty($removeValues))
		{
			$values = array_diff($values, $removeValues);
		}

		// Filter to sanitise data
		switch ($filter)
		{
			case 'integer':
				JArrayHelper::toInteger($values);
				break;
			default:
				$values = array_map(array($db, 'quote'), $values);
				break;
		}

		return $values;
	}
}