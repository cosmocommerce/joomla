<?php
/**
 * @version		$Id: redirect.php 13031 2009-10-02 21:54:22Z louis $
 * @package		Joomla.Administrator
 * @subpackage	com_redirect
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @copyright	Copyright (C) 2008 - 2009 JXtended, LLC. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Invalid Request.');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_redirect')) {
	return JError::raiseWarning(404, JText::_('ALERTNOTAUTH'));
}

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= &JController::getInstance('Redirect');
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
