<?php
/**
 * @version		$Id: toolbar.massmail.html.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla.Administrator
 * @subpackage	Massmail
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	Massmail
 */
class TOOLBAR_massmail
{
	/**
	* Draws the menu for a New Contact
	*/
	function _DEFAULT() {

		JToolBarHelper::title(JText::_('Mass Mail'), 'massemail.png');
		JToolBarHelper::custom('send','send.png','send_f2.png','Send Mail',false);
		JToolBarHelper::cancel();
		JToolBarHelper::preferences('com_massmail', 200);
		JToolBarHelper::help('screen.users.massmail');
	}
}