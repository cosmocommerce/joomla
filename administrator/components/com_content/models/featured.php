<?php
/**
 * @version		$Id$
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).DS.'articles.php';

/**
 * About Page Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class ContentModelFeatured extends ContentModelArticles
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	public $_context = 'com_content.featured';

	/**
	 * @param	boolean	True to join selected foreign information
	 *
	 * @return	string
	 */
	function _getListQuery($resolveFKs = true)
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title, a.alias, a.checked_out, a.checked_out_time, a.catid, a.state, a.access, a.created, a.hits'
			)
		);
		$query->from('#__content AS a');

		// Join over the content table.
		$query->select('fp.ordering');
		$query->join('INNER', '#__content_frontpage AS fp ON fp.content_id = a.id');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');

		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');

		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
			$query->where('a.access = ' . (int) $access);
		}

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state = 0 OR a.state = 1)');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('a.title LIKE '.$search.' OR a.alias LIKE '.$search);
			}
		}

		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'a.title')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		//echo nl2br(str_replace('#__','jos_',(string)$query));
		return $query;
	}
}
