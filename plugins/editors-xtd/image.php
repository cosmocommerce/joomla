<?php
/**
 * @version		$Id: image.php 11784 2009-04-24 17:34:11Z kdevine $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Editor Image buton
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonImage extends JPlugin
{
	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	function onDisplay($name)
	{
		global $mainframe;
		$params = &JComponentHelper::getParams('com_media');
		$ranks = array('publisher', 'editor', 'author', 'registered');
		$acl = & JFactory::getACL();

		// TODO: Fix this ACL call
		//for($i = 0; $i < $params->get('allowed_media_usergroup', 3); $i++)
		//{
		//	$acl->addACL('com_media', 'popup', 'users', $ranks[$i]);
		//}


		// TODO: Fix this ACL call
		//Make sure the user is authorized to view this page
		$user = & JFactory::getUser();
		if (!$user->authorize('com_media', 'popup')) {
			//return;
		}
		$doc 		= &JFactory::getDocument();
		$template 	= $mainframe->getTemplate();

		$link = 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name='.$name;

		JHtml::_('behavior.modal');

		$button = new JObject;
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('Image'));
		$button->set('name', 'image');
		$button->set('options', "{handler: 'iframe', size: {x: 570, y: 400}}");

		return $button;
	}
}
