<?php
/**
 * @version		$Id: controller.php 12685 2009-09-10 14:14:04Z pentacle $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of plugin records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_plugins
 * @since		1.6
 */
class PluginsModelPlugins extends JModelList
{
	/**
	 * Model context string.
	 *
	 * @var	string
	 */
	protected $_context = 'com_plugins.plugins';

	/**
	 * Method to auto-populate the model state.
	 */
	protected function _populateState()
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->_context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$accessId = $app->getUserStateFromRequest($this->_context.'.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$state = $app->getUserStateFromRequest($this->_context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		$folder = $app->getUserStateFromRequest($this->_context.'.filter.folder', 'filter_folder', null, 'cmd');
		$this->setState('filter.folder', $folder);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_plugins');
		$this->setState('params', $params);

		// List state information.
		parent::_populateState('a.folder', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string	A prefix for the store id.
	 *
	 * @return	string	A store id.
	 */
	protected function _getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.state');
		$id	.= ':'.$this->getState('filter.folder');

		return parent::_getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JQuery
	 */
	protected function _getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.extension_id, a.name, a.element, a.folder, a.checked_out, a.checked_out_time,' .
				' a.enabled, a.access, a.ordering'
			)
		);
		$query->from('`#__extensions` AS a');

		$query->where('`type` = '.$db->quote('plugin'));

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
			$query->where('a.access = '.(int) $access);
		}

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.enabled = '.(int) $published);
		} else if ($published === '') {
			$query->where('(a.enabled IN (0, 1))');
		}

		// Filter by folder.
		if ($folder = $this->getState('filter.folder')) {
			$query->where('a.folder = '.$db->quote($folder));
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('a.name LIKE '.$search);
			}
		}

		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'a.name')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
}
