<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	mod_newsflash
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/router.php';

class modNewsFlashHelper
{
	function renderItem(&$item, &$params, &$access)
	{
		$app	= &JFactory::getApplication();
		$user	= &JFactory::getUser();
		$groups	= $user->authorisedLevels();
		// $groups	= implode(',', $groups);

		$item->text		= $item->introtext;
		$item->groups	= '';
		$item->readmore = (trim($item->fulltext) != '');
		$item->metadesc = '';
		$item->metakey	= '';
		$item->created	= '';
		$item->modified = '';

		if ($params->get('readmore') || $params->get('link_titles'))
		{
			if ($params->get('intro_only'))
			{
				// Check to see if the user has access to view the full article
				if (in_array($item->access, $groups)) {
					$item->linkOn = JRoute::_(ContentRoute::article($item->slug, $item->catslug));
					$item->linkText = JText::_('MOD_NEWSFLASH_READMORE');
				}
				else {
					$item->linkOn = JRoute::_('index.php?option=com_users&view=login');
					$item->linkText = JText::_('MOD_NEWSFLASH_READMORE_REGISTER');
				}
			}
		}

		if (!$params->get('image')) {
			$item->text = preg_replace('/<img[^>]*>/', '', $item->text);
		}

		$results = $app->triggerEvent('onAfterDisplayTitle', array (&$item, &$params, 1));
		$item->afterDisplayTitle = trim(implode("\n", $results));

		$results = $app->triggerEvent('onBeforeDisplayContent', array (&$item, &$params, 1));
		$item->beforeDisplayContent = trim(implode("\n", $results));

		require JModuleHelper::getLayoutPath('mod_newsflash', '_item');
	}

	function getList(&$params, &$access)
	{
		$db	= JFactory::getDbo();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels());

		$catid	= (int) $params->get('catid', 0);
		$items	= (int) $params->get('items', 0);

		$contentConfig	= &JComponentHelper::getParams('com_content');
		$noauth			= !$contentConfig->get('show_noauth');
		$date = JFactory::getDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();

		// query to determine article count
		$query	= $db->getQuery(true);
		$query->select('a.*');
		$query->select('CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug');
		$query->select('CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
		$query->from('#__content as a');
		$query->innerJoin('#__categories AS cc ON cc.id = a.catid');
		$query->where('a.state = 1');
		$query->where($noauth ? 'a.access IN ('.$groups.')' : '');
		$query->where($noauth ? 'cc.access IN ('.$groups.')' : '');
		$query->where('(a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).')');
		$query->where('(a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).')');
		$query->where('cc.id = '. (int) $catid);
		$query->where('cc.published = 1');
		$query->order('a.ordering');

		$db->setQuery($query, 0, $items);
		$rows = $db->loadObjectList();

		return $rows;
	}
}
