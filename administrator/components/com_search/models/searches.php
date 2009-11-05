<?php
/**
 * @version		$Id$
 * @package		Joomla.Administrator
 * @subpackage	Search
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.database.query');

/**
 * Methods supporting a list of search terms.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_search
 * @since		1.6
 */
class SearchModelSearches extends JModelList
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_searches.searches';

	/**
	 * Method to auto-populate the model state.
	 */
	protected function _populateState()
	{
		// Initialize variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->_context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$showResults = $app->getUserStateFromRequest($this->_context.'.filter.results', 'filter_results', null, 'int');
		$this->setState('filter.results', $showResults);

		// List state information.
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->getUserStateFromRequest($this->_context.'.limitstart', 'limitstart', 0);
		$this->setState('list.start', $limitstart);

		$orderCol = $app->getUserStateFromRequest($this->_context.'.ordercol', 'filter_order', 'a.hits');
		$this->setState('list.ordering', $orderCol);

		$orderDirn = $app->getUserStateFromRequest($this->_context.'.orderdirn', 'filter_order_Dir', 'asc');
		$this->setState('list.direction', $orderDirn);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_search');
		$this->setState('params', $params);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 */
	protected function _getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('list.start');
		$id	.= ':'.$this->getState('list.limit');
		$id	.= ':'.$this->getState('list.ordering');
		$id	.= ':'.$this->getState('list.direction');
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.results');

		return md5($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JQuery
	 */
	protected function _getListQuery()
	{
		// Create a new query object.
		$query = new JQuery;

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('`#__core_log_searches` AS a');

		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
			$query->where('a.access = '.(int) $access);
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $this->_db->Quote('%'.$this->_db->getEscaped($search, true).'%');
			$query->where('a.search_term LIKE '.$search);
		}

		// Add the list ordering clause.
		$query->order($this->_db->getEscaped($this->getState('list.ordering', 'a.hits')).' '.$this->_db->getEscaped($this->getState('list.direction', 'ASC')));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}

	/**
	 * Override the parnet getItems to inject optional data.
	 *
	 * @return	mixed	An array of objects on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		// Determine if number of results for search item should be calculated
		// by default it is `off` as it is highly query intensive
		if ($this->getState('filter.results'))
		{
			JPluginHelper::importPlugin('search');
			$app = JFactory::getApplication();

			if (!class_exists('JSite'))
			{
				// This fools the routers in the search plugins into thinking it's in the frontend
				require_once JPATH_COMPONENT.'/helpers/site.php';
			}

			foreach ($items as &$item)
			{
				$results = $app->triggerEvent('onSearch', array($item->search_term));
				$item->returns = 0;
				foreach ($results as $result) {
					$item->returns += count($result);
				}
			}
		}

		return $items;
	}

	/**
	 * Method to reset the seach log table.
	 *
	 * @return	boolean
	 */
	public function reset()
	{
		$db = $this->getDbo();
		$db->setQuery(
			'DELETE FROM #__core_log_searches'
		);
		if (!$db->query())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}

		return true;
	}
}