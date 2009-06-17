<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Require the com_content helper library
require_once(JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'query.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'route.php');

// Component Helper
jimport('joomla.application.component.helper');

// Create the controller
$controller = new ContentController();

// Register Extra tasks
$controller->registerTask('new'  , 	'edit');
$controller->registerTask('apply', 	'save');
$controller->registerTask('apply_new', 'save');

// Perform the Request task
$controller->execute(JRequest::getVar('task', null, 'default', 'cmd'));
$controller->redirect();