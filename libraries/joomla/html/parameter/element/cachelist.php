<?php
/**
* @version		$Id: folderlist.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a cachelist element
 *
 * @package 		Joomla.Framework
 * @subpackage		Parameter
 * @since		1.6
 */

class JElementCachelist extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Cachelist';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );
		$options = array(
			JHTML::_('select.option', 0, JText::_('Disabled')),
			JHTML::_('select.option', 1, JText::_('Use Default')),
			JHTML::_('select.option', 2, JText::_('Enabled')),
		);
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', $class, 'value', 'text', $value, $control_name.$name);
	}
}
