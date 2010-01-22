<?php
/**
 * @version		$Id$
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Categories Search plugin
 *
 * @package		Joomla
 * @subpackage	Search
 * @since 		1.6
 */
class plgSearchCategories extends JPlugin
{

	function __construct()
	{
		$this->loadLanguage('plg_search_categories');
	}

	/**
	 * @return array An array of search areas
	 */
	function onSearchAreas()
	{
		static $areas = array(
		'categories' => 'Categories'
		);
		return $areas;
	}

	/**
	 * Categories Search method
	 *
	 * The sql must return the following fields that are
	 * used in a common display routine: href, title, section, created, text,
	 * browsernav
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 * @param mixed An array if restricted to areas, null if search all
	 */
	function onSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$db		= &JFactory::getDbo();
		$user	= &JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels());
		$searchText = $text;

		require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys(plgSearchCategoryAreas()))) {
				return array();
			}
		}

		// load plugin params info
		$plugin = &JPluginHelper::getPlugin('search', 'categories');
		$pluginParams = new JParameter($plugin->params);

		$limit = $pluginParams->def('search_limit', 50);

		$text = trim($text);
		if ($text == '') {
			return array();
		}

		switch ($ordering) {
			case 'alpha':
				$order = 'a.name ASC';
				break;

			case 'category':
			case 'popular':
			case 'newest':
			case 'oldest':
			default:
				$order = 'a.name DESC';
		}

		$text	= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
		$query	= 'SELECT a.title, a.description AS text, "" AS created, a.name,'
		. ' "2" AS browsernav,'
		. ' s.id AS secid, a.id AS catid,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug'
		. ' FROM #__categories AS a'
		. ' INNER JOIN #__sections AS s ON s.id = a.section'
		. ' WHERE (a.name LIKE '.$text
		. ' OR a.title LIKE '.$text
		. ' OR a.description LIKE '.$text.')'
		. ' AND a.published = 1'
		. ' AND s.published = 1'
		. ' AND a.access IN ('.$groups.')'
		. ' AND s.access IN ('.$groups.')'
		. ' GROUP BY a.id'
		. ' ORDER BY '. $order
		;
		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();

		$count = count($rows);
		for ($i = 0; $i < $count; $i++) {
			$rows[$i]->href = ContentRoute::category($rows[$i]->slug, $rows[$i]->secid);
			$rows[$i]->section 	= JText::_('Category');
		}

		$return = array();
		foreach($rows AS $key => $category) {
			if (searchHelper::checkNoHTML($category, $searchText, array('name', 'title', 'text'))) {
				$return[] = $category;
			}
		}

		return $return;
	}
}