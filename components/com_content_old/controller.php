<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Content Component Controller
 *
 * @package		Joomla.Site
 * @subpackage	Content
 * @since 1.5
 */
class ContentController extends JController
{
	/**
	 * Method to show an article as the main page display
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		// Set a default view if none exists
		if (! JRequest::getCmd('view')) {
			$default	= JRequest::getInt('id') ? 'article' : 'frontpage';
			JRequest::setVar('view', $default);
		}

		// View caching logic -- simple... are we logged in?
		$user = &JFactory::getUser();
		if ($user->get('id') || (JRequest::getVar('view') == 'category' && JRequest::getVar('layout') != 'blog')) {
			parent::display(false);
		} else {
			parent::display(true);
		}
	}

	/**
	* Edits an article
	*
	* @access	public
	* @since	1.5
	*/
	function edit()
	{
		$user	= &JFactory::getUser();

		// Create the view
		$view = & $this->getView('article', 'html');

		// Get/Create the model
		$model = & $this->getModel('Article');

		// Create a user access object for the user
		$access = new stdClass();
		$access->canEdit	= $user->authorise('com_content.article.edit_article');
		$access->canEditOwn	= $user->authorise('com_content.article.edit_own') && ($model->get('id') == 0 || $user->get('id') == $model->get('created_by'));
		$access->canPublish	= $user->authorise('com_content.article.publish');
		$access->canManage	= $user->authorise('com_content.manage');

		// Check the user's access to edit the article.
		if (!$access->canEdit && !$access->canEditOwn && !$access->canPublish && !$access->canManage) {
			JError::raiseError(403, JText::_('ALERTNOTAUTH'));
			return false;
		}

		if ($model->isCheckedOut($user->get('id')))
		{
			$msg = JText::sprintf('DESCBEINGEDITTED', JText::_('The item'), $model->get('title'));
			$this->setRedirect(JRoute::_('index.php?view=article&id='.$model->get('id'), false), $msg);
			return;
		}

		//Checkout the article
		$model->checkout();

		// Push the model into the view (as default)
		$view->setModel($model, true);

		// Set the layout
		$view->setLayout('form');

		// Display the view
		$view->display();
	}

	/**
	* Saves the content item an edit form submit
	*
	* @todo
	*/
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Initialize variables
		$db			= & JFactory::getDbo();
		$user		= & JFactory::getUser();
		$task		= JRequest::getVar('task', null, 'default', 'cmd');

		//get data from the request
		$model = $this->getModel('article');

		//get data from request
		$post = JRequest::get('post');
		$post['text'] = JRequest::getVar('text', '', 'post', 'string', JREQUEST_ALLOWRAW);

		//preform access checks
		$isNew = ((int) $post['id'] < 1);

		// Create a user access object for the user
		$access = new stdClass();
		$access->canEdit	= $user->authorise('com_content.article.edit_article');
		$access->canEditOwn	= $user->authorise('com_content.article.edit_own') && ($isNew || $user->get('id') == $model->get('created_by'));
		$access->canPublish	= $user->authorise('com_content.article.publish');
		$access->canManage	= $user->authorise('com_content.manage');

		// Check the user's access to edit the article.
		if (!$access->canEdit && !$access->canEditOwn && !$access->canPublish && !$access->canManage) {
			JError::raiseError(403, JText::_('ALERTNOTAUTH'));
			return false;
		}

		if ($model->store($post)) {
			$msg = JText::_('Article Saved');

			if ($isNew) {
				$post['id'] = (int) $model->get('id');
			}
		} else {
			$msg = JText::_('Error Saving Article');
			JError::raiseError(500, $model->getError());
		}

		// manage frontpage items
		//TODO : Move this into a frontpage model
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontpage'.DS.'tables'.DS.'frontpage.php');
		$fp = new TableFrontPage($db);

		if (JRequest::getVar('frontpage', false, '', 'boolean'))
		{
			// toggles go to first place
			if (!$fp->load($post['id']))
			{
				// new entry
				$query = 'INSERT INTO #__content_frontpage' .
						' VALUES ('.(int) $post['id'].', 1)';
				$db->setQuery($query);
				if (!$db->query()) {
					JError::raiseError(500, $db->stderr());
				}
				$fp->ordering = 1;
			}
		}
		else
		{
			// no frontpage mask
			if (!$fp->delete($post['id'])) {
				$msg .= $fp->stderr();
			}
			$fp->ordering = 0;
		}
		$fp->reorder();

		$model->checkin();

		// gets section name of item
		$query = 'SELECT s.title' .
				' FROM #__sections AS s' .
				' WHERE s.scope = "content"' .
				' AND s.id = ' . (int) $post['sectionid'];
		$db->setQuery($query);
		// gets category name of item
		$section = $db->loadResult();

		$query = 'SELECT c.title' .
				' FROM #__categories AS c' .
				' WHERE c.id = ' . (int) $post['catid'];
		$db->setQuery($query);
		$category = $db->loadResult();

		if ($isNew)
		{
			// messaging for new items
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_messages'.DS.'tables'.DS.'message.php');

			// load language for messaging
			$lang = &JFactory::getLanguage();
			$lang->load('com_messages');

			$query = 'SELECT id' .
					' FROM #__users' .
					' WHERE sendEmail = 1';
			$db->setQuery($query);
			$users = $db->loadResultArray();
			foreach ($users as $user_id)
			{
				$msg = new TableMessage($db);
				$msg->send($user->get('id'), $user_id, JText::_('New Item'), JText::sprintf('ON_NEW_CONTENT', $user->get('username'), $post['title'], $section, $category));
			}
		} else {
			// If the article isn't new, then we need to clean the cache so that our changes appear realtime :)
			$cache = &JFactory::getCache('com_content');
			$cache->clean();
		}

		if ($access->canPublish)
		{
			// Publishers, admins, etc just get the stock msg
			$msg = JText::_('Item successfully saved.');
		}
		else
		{
			$msg = $isNew ? JText::_('THANK_SUB') : JText::_('Item successfully saved.');
		}

		$referer = JRequest::getString('ret',  base64_encode(JURI::base()), 'get');
		$referer = base64_decode($referer);
		if (!JURI::isInternal($referer)) {
			$referer = '';
		}
		$this->setRedirect($referer, $msg);
	}

	/**
	* Cancels an edit article operation
	*
	* @access	public
	* @since	1.5
	*/
	function cancel()
	{
		// Initialize some variables
		$db		= & JFactory::getDbo();
		$user	= & JFactory::getUser();

		// Get an article table object and bind post variabes to it [We don't need a full model here]
		$article = & JTable::getInstance('content');
		$article->bind(JRequest::get('post'));

		if ($user->authorize('com_content.article.edit_article') || ($user->authorize('com_content.article.edit_own') && $article->created_by == $user->get('id'))) {
			$article->checkin();
		}

		// If the task was edit or cancel, we go back to the content item
		$referer = JRequest::getString('ret', base64_encode(JURI::base()), 'get');
		$referer = base64_decode($referer);
		if (!JURI::isInternal($referer)) {
			$referer = '';
		}
		$this->setRedirect($referer);
	}

	/**
	* Rates an article
	*
	* @access	public
	* @since	1.5
	*/
	function vote()
	{
		$url	= JRequest::getVar('url', '', 'default', 'string');
		$rating	= JRequest::getVar('user_rating', 0, '', 'int');
		$id		= JRequest::getVar('cid', 0, '', 'int');

		// Get/Create the model
		$model = & $this->getModel('Article');

		$model->setId($id);

		if (!JURI::isInternal($url)) {
			$url = JRoute::_('index.php?option=com_content&view=article&id='.$id);
		}

		if ($model->storeVote($rating)) {
			$this->setRedirect($url, JText::_('Thanks for rating!'));
		} else {
			$this->setRedirect($url, JText::_('You already rated this article today!'));
		}
	}

	/**
	 * Searches for an item by a key parameter
	 *
	 * @access	public
	 * @since	1.5
	 */
	function findkey()
	{
		// Initialize variables
		$db		= & JFactory::getDbo();
		$keyref	= JRequest::getVar('keyref', null, 'default', 'cmd');
		JRequest::setVar('keyref', $keyref);

		// If no keyref left, throw 404
		if (empty($keyref) === true) {
			JError::raiseError(404, JText::_("Key Not Found"));
		}

		$keyref	= $db->Quote('%keyref='.$db->getEscaped($keyref, true).'%', false);
		$query	= 'SELECT id' .
				' FROM #__content' .
				' WHERE attribs LIKE '.$keyref;
		$db->setQuery($query);
		$id = (int) $db->loadResult();

		if ($id > 0)
		{
			// Create the view
			$view = &$this->getView('article', 'html');

			// Get/Create the model
			$model = &$this->getModel('Article');

			// Set the id of the article to display
			$model->setId($id);

			// Push the model into the view (as default)
			$view->setModel($model, true);

			// Display the view
			$view->display();
		}
		else {
			JError::raiseError(404, JText::_('Key Not Found'));
		}
	}

	/**
	 * Output the pagebreak dialog
	 *
	 * @access 	public
	 * @since 	1.5
	 */
	function ins_pagebreak()
	{
		// Create the view
		$view = & $this->getView('article', 'html');

		// Set the layout
		$view->setLayout('pagebreak');

		// Display the view
		$view->display();
	}
}