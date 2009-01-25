<?php
/**
 * @version		$Id$
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * Languages Weblink Controller
 *
 * @package		Joomla
 * @subpackage	Languages
 * @since 1.5
 */
class LanguagesController extends JController
{
	function publish()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

		// Initialize some variables
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

		$params = JComponentHelper::getParams('com_languages');
		$params->set($client->name, $cid[0]);

		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_languages' );

		$table->params = $params->toString();

		// pre-save checks
		if (!$table->check()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		// save the changes
		if (!$table->store()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		$this->setredirect('index.php?option=com_languages&client='.$client->id);
	}
}