<?php
/**
 * @version		$Id: menu.php 12527 2009-07-11 18:36:02Z erdsiger $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * JMenu class
 *
 * @package		Joomla.Site
 * @subpackage	Application
 * @since		1.5
 */
class JMenuSite extends JMenu
{
	/**
	 * Loads the entire menu table into memory.
	 *
	 * @return array
	 */
	public function load()
	{
		$cache = &JFactory::getCache('_system', 'output');

		if (!$data = $cache->get('menu_items'))
		{
			jimport('joomla.database.query');

			// Initialize some variables.
			$db = &JFactory::getDbo();
			$query = new JQuery;

			$query->select('m.id, m.menutype, m.title, m.alias, m.path AS route, m.link, m.type, m.level');
			$query->select('m.browserNav, m.access, m.params, m.home, m.template_id, m.component_id, m.parent_id');
			$query->select('c.option as component');
			$query->from('#__menu AS m');
			$query->leftJoin('#__components AS c ON m.component_id = c.id');
			$query->where('m.published = 1');
			$query->where('m.parent_id > 0');
			$query->order('m.lft');

			$db->setQuery($query);
			if (!($menus = $db->loadObjectList('id')))
			{
				JError::raiseWarning(500, "Error loading Menus: ".$db->getErrorMsg());
				return false;
			}

			foreach ($menus as &$menu)
			{
				// Get parent information.
				$parent_tree = array();
				if (($parent = $menu->parent_id) && (isset($menus[$parent])) &&
					(is_object($menus[$parent])) && (isset($menus[$parent]->route)) && isset($menus[$parent]->tree)) {
					$parent_tree  = $menus[$parent]->tree;
				}

				// Create tree.
				array_push($parent_tree, $menu->id);
				$menu->tree = $parent_tree;

				// Create the query array.
				$url = str_replace('index.php?', '', $menu->link);
				if (strpos($url, '&amp;') !== false) {
				   $url = str_replace('&amp;','&',$url);
				}

				parse_str($url, $menu->query);
			}

			$cache->store(serialize($menus), 'menu_items');

			$this->_items = $menus;
		}
		else {
			$this->_items = unserialize($data);
		}
	}
}