<?php
/**
 * @version		$Id: separator.php 12590 2009-08-01 05:37:44Z severdia $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a button separator
 *
 * @package 	Joomla.Framework
 * @subpackage		HTML
 * @since		1.5
 */
class JButtonSeparator extends JButton
{
	/**
	 * Button type
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $_name = 'Separator';

	public function render(&$definition)
	{
		// Initialize variables
		$class	= null;
		$style	= null;

		// Separator class name
		$class = (empty($definition[1])) ? 'spacer' : $definition[1];
		// Custom width
		$style = (empty($definition[2])) ? null : ' style="width:' .  intval($definition[2]) . 'px;"';

		return '<li class="' . $class . '"' . $style . ">\n</li>\n";
	}

	/**
	 * Empty implementation (not required)
	 */
	public function fetchButton()
	{
	}
}
