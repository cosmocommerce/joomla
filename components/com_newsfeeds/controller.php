<?php
/**
 * @version		$Id: controller.php 11952 2009-06-01 03:21:19Z robs $
 * @package		Joomla.Site
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Newsfeeds Component Controller
 *
 * @package		Joomla.Site
 * @subpackage	Newsfeeds
 * @since 1.5
 */
class NewsfeedsController extends JController
{
	/**
	 * Method to show a newsfeeds view
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		// Set a default view if none exists
		if (! JRequest::getCmd('view')) {
			JRequest::setVar('view', 'categories');
		}

		parent::display();
	}
}

?>
