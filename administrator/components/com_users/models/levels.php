<?php
/**
 * @version		$Id$
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @copyright	Copyright (C) 2008 - 2009 JXtended, LLC. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.database.query');

/**
 * Access Levels model for Users.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class UsersModelLevels extends JModelList
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	 protected $_context = 'users.levels';

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function _getListQuery()
	{
		// Create a new query object.
		$query = new JQuery;

		// Select all fields from the table.
		$query->select($this->getState('list.select', 'a.*'));
		$query->from('`#__access_assetgroups` AS a');

		// Add the level in the tree.
		$query->select('COUNT(DISTINCT c2.id) AS level');
		$query->join('LEFT OUTER', '`#__access_assetgroups` AS c2 ON a.left_id > c2.left_id AND a.right_id < c2.right_id');
		$query->group('a.id');

		// Count the objects in the user group.
		$query->select('s.title AS section_title');
		$query->join('LEFT', '`#__access_sections` AS s ON s.id = a.section_id');
		$query->group('a.id');

		// If the model is set to check item state, add to the query.
		if ($this->getState('check.state', true)) {
			//$query->where('a.block = ' . (int)$this->getState('filter.state'));
		}

		// Filter the items over the parent id if set.
		$parent_id = $this->getState('filter.parent_id');
		if ($parent_id !== null && $parent_id > 0) {
			$query->join('LEFT', '`#__access_assetgroups` AS p ON p.id = '.(int)$parent_id);
			$query->where('a.left_id > p.left_id AND a.right_id < p.right_id');
		}

		// Filter the items over the section id if set.
		$sectionId = $this->getState('filter.section_id');
		if ($sectionId !== null && $sectionId > 0) {
			$query->where('a.section_id = '.(int) $sectionId);
		}

		// Filter the items over the search string if set.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$query->where('a.title LIKE '.$this->_db->Quote('%'.$search.'%'));
		}

		// Extended joins

		$query->select('GROUP_CONCAT(ug.title SEPARATOR \',\') AS user_groups');

		$query->leftJoin('#__access_assetgroup_rule_map AS agrm ON agrm.group_id = a.id');
		$query->innerJoin('#__access_rules AS r ON r.id = agrm.rule_id');
		$query->leftJoin('#__usergroup_rule_map AS ugrm ON ugrm.rule_id = r.id');
		$query->leftJoin('#__usergroups AS ug ON ug.id = ugrm.group_id');

		$query->group('a.id');

		// Add the list ordering clause.
		$query->order($this->_db->getEscaped($this->getState('list.ordering', 'a.left_id')).' '.$this->_db->getEscaped($this->getState('list.direction', 'ASC')));

		//echo nl2br(str_replace('#__','jos_',$query->toString())).'<hr/>';
		return $query;
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$context	A prefix for the store id.
	 * @return	string		A store id.
	 */
	protected function _getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('list.start');
		$id	.= ':'.$this->getState('list.limit');
		$id	.= ':'.$this->getState('list.ordering');
		$id	.= ':'.$this->getState('list.direction');
		$id	.= ':'.$this->getState('check.state');
		$id	.= ':'.$this->getState('filter.state');
		$id	.= ':'.$this->getState('filter.search');

		return md5($id);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * @return	void
	 */
	protected function _populateState()
	{
		// Initialize variables.
		$app		= &JFactory::getApplication('administrator');
		$user		= &JFactory::getUser();
		$config		= &JFactory::getConfig();
		$params		= JComponentHelper::getParams('com_users');
		$context	= 'com_users.levels.';

		// Load the filter state.
		$this->setState('filter.search', $app->getUserStateFromRequest($context.'filter.search', 'filter_search', ''));
		$this->setState('filter.state', $app->getUserStateFromRequest($context.'filter.state', 'filter_state', 0, 'string'));
		$this->setState('filter.parent_id', $app->getUserStateFromRequest($context.'filter.parent_id', 'filter_parent_id', 0, 'int'));
		$this->setState('filter.section_id', $app->getUserStateFromRequest($context.'filter.section_id', 'filter_section_id', 0, 'int'));

		// Load the list state.
		$this->setState('list.start', $app->getUserStateFromRequest($context.'list.start', 'limitstart', 0, 'int'));
		$this->setState('list.limit', $app->getUserStateFromRequest($context.'list.limit', 'limit', $app->getCfg('list_limit', 25), 'int'));
		$this->setState('list.ordering', 'a.id');
		$this->setState('list.direction', 'ASC');

		// Load the user parameters.
		$this->setState('user',	$user);
		$this->setState('user.id', (int)$user->id);

		// Load the check parameters.
		if ($this->_state->get('filter.state') === '*') {
			$this->setState('check.state', false);
		} else {
			$this->setState('check.state', true);
		}

		// Load the parameters.
		$this->setState('params', $params);
	}
}
