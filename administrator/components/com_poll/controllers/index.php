<?php
/**
 * @version $Id$
 * @package Joomla
 * @subpackage Config
 * @copyright Copyright (C) 2005 - 2006 Open Source Matters. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport( 'joomla.application.controller' );

/**
 * @package Joomla
 * @subpackage Config
 */
class JPollGlobalController extends JController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default )
	{
		parent::__construct( $default );
		$this->registerTask( 'new', 'editPoll' );
		$this->registerTask( 'edit', 'editPoll' );

		$this->registerTask( 'save', 'savePoll');
		$this->registerTask( 'apply', 'savePoll');

		$this->registerTask( 'remove', 'removePoll');
		$this->registerTask( 'publish', 'publishPolls');
		$this->registerTask( 'unpublish', 'publishPolls');

		$this->registerTask( 'cancel', 'cancelPoll');
		$this->registerTask( 'preview', 'previewPoll');
	}

	function showPolls()
	{
		global $mainframe, $option;

		$db					=& JFactory::getDBO();
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order", 		'filter_order', 	'm.id' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'' );
		$filter_state 		= $mainframe->getUserStateFromRequest( "$option.filter_state", 		'filter_state', 	'' );
		$limit 				= $mainframe->getUserStateFromRequest( "limit", 					'limit', 			$mainframe->getCfg('list_limit') );
		$limitstart 		= $mainframe->getUserStateFromRequest( "$option.limitstart", 		'limitstart', 		0 );
		$search 			= $mainframe->getUserStateFromRequest( "$option.search", 			'search', 			'' );
		$search 			= $db->getEscaped( trim( JString::strtolower( $search ) ) );

		$where = array();

		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = "m.published = 1";
			} else if ($filter_state == 'U' ) {
				$where[] = "m.published = 0";
			}
		}
		if ($search) {
			$where[] = "LOWER(m.title) LIKE '%$search%'";
		}

		$where 		= ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' );
		$orderby 	= "\n ORDER BY $filter_order $filter_order_Dir";

		$query = "SELECT COUNT(m.id)"
		. "\n FROM #__polls AS m"
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.presentation.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$query = "SELECT m.*, u.name AS editor, COUNT(d.id) AS numoptions"
		. "\n FROM #__polls AS m"
		. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
		. "\n LEFT JOIN #__poll_data AS d ON d.pollid = m.id AND d.text <> ''"
		. $where
		. "\n GROUP BY m.id"
		. $orderby
		;
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();

		if ($db->getErrorNum()) {
			echo $db->stderr();
			return false;
		}

		// state filter
		$lists['state']	= mosCommonHTML::selectState( $filter_state );

		// table ordering
		if ( $filter_order_Dir == 'DESC' ) {
			$lists['order_Dir'] = 'ASC';
		} else {
			$lists['order_Dir'] = 'DESC';
		}
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		JPollView::showPolls( $rows, $pageNav, $option, $lists );
	}

	function editPoll( )
	{
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();

		$cid 	= JRequest::getVar( 'cid', array(0));
		$option = JRequest::getVar( 'option');
		if (!is_array( $cid )) {
			$cid = array(0);
		}
		$uid 	= $cid[0];

		$row =& JTable::getInstance('poll', $db, 'Table');
		// load the row from the db table
		$row->load( $uid );

		// fail if checked out not by 'me'
		if ($row->isCheckedOut( $user->get('id') )) {
	    	$msg = sprintf( JText::_( 'DESCBEINGEDITTED' ), JText::_( 'The poll' ), $row->title );
			$this->setRedirect( 'index.php?option='. $option, $msg );
		}

		$options = array();

		if ($uid) {
			$row->checkout( $user->get('id') );
			$query = "SELECT id, text"
			. "\n FROM #__poll_data"
			. "\n WHERE pollid = $uid"
			. "\n ORDER BY id"
			;
			$db->setQuery($query);
			$options = $db->loadObjectList();
		} else {
			$row->lag = 3600*24;
		}

		// get selected pages
		if ( $uid ) {
			$query = "SELECT menuid AS value"
			. "\n FROM #__poll_menu"
			. "\n WHERE pollid = $row->id"
			;
			$db->setQuery( $query );
			$lookup = $db->loadObjectList();
		} else {
			$lookup = array( mosHTML::makeOption( 0, JText::_( 'All' ) ) );
		}

		// build the html select list
		$lists['select'] = mosAdminMenus::MenuLinks( $lookup, 1, 1 );

		JPollView::editPoll($row, $options, $lists );
	}

	function savePoll()
	{
		$db =& JFactory::getDBO();
		// save the poll parent information
		$row =& JTable::getInstance('poll', $db, 'Table');
		if (!$row->bind( $_POST )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$isNew = ($row->id == 0);

		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->checkin();
		// save the poll options
		$options = JRequest::getVar( 'polloption', array(), 'post', 'array' );

		foreach ($options as $i=>$text) {
			$text = $db->Quote($text);
			if ($isNew) {
				$query = "INSERT INTO #__poll_data"
				. "\n ( pollid, text )"
				. "\n VALUES ( $row->id, $text )"
				;
				$db->setQuery( $query );
				$db->query();
			} else {
				$query = "UPDATE #__poll_data"
				. "\n SET text = $text"
				. "\n WHERE id = $i"
				. "\n AND pollid = $row->id"
				;
				$db->setQuery( $query );
				$db->query();
			}
		}

		// update the menu visibility
		$selections = JRequest::getVar( 'selections', array(), 'post', 'array' );

		$query = "DELETE FROM #__poll_menu"
		. "\n WHERE pollid = $row->id"
		;
		$db->setQuery( $query );
		$db->query();

		for ($i=0, $n=count($selections); $i < $n; $i++) {
			$query = "INSERT INTO #__poll_menu"
			. "\n SET pollid = $row->id, menuid = ". $selections[$i]
			;
			$db->setQuery( $query );
			$db->query();
		}

		switch ($this->_task) {
			case 'apply':
				$link = 'index.php?option=com_poll&task=editA&id='. $row->id .'&hidemainmenu=1';
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_poll';
				break;
		}

		$this->setRedirect($link);
	}

	function removePoll()
	{
		$db =& JFactory::getDBO();

		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$option = JRequest::getVar( 'option', 'com_poll', '', 'string' );
		$msg = '';
		for ($i=0, $n=count($cid); $i < $n; $i++) {
			$poll =& JTable::getInstance('poll', $db, 'Table');
			if (!$poll->delete( $cid[$i] )) {
				$msg .= $poll->getError();
			}
		}
		$this->setRedirect( 'index.php?option='. $option, $msg );
	}

	/**
	* Publishes or Unpublishes one or more records
	* @param array An array of unique category id numbers
	* @param integer 0 if unpublishing, 1 if publishing
	* @param string The current url option
	*/
	function publishPolls()
	{
		global $mainframe;

		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();

		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$publish = ( $this->_task == 'publish' ? 1 : 0 );
		$option = JRequest::getVar( 'option', 'com_poll', '', 'string' );
		$catid = JRequest::getVar( 'catid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('". JText::_( 'Select an item to', true ) ." ". $action ."'); window.history.go(-1);</script>\n";
			exit;
		}

		$cids = implode( ',', $cid );

		$query = "UPDATE #__polls"
		. "\n SET published = " . intval( $publish )
		. "\n WHERE id IN ( $cids )"
		. "\n AND ( checked_out = 0 OR ( checked_out = " .$user->get('id'). " ) )"
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (count( $cid ) == 1) {
			$row =& JTable::getInstance('poll', $db, 'Table');
			$row->checkin( $cid[0] );
		}
		$mainframe->redirect( 'index.php?option='. $option );
	}

	function cancelPoll()
	{
		global $option;

		$db =& JFactory::getDBO();
		$row =& JTable::getInstance('poll', $db, 'Table');
		$row->bind( $_POST );
		$row->checkin();
		$this->setRedirect( 'index.php?option='. $option );
	}

	function previewPoll()
	{
		global $mainframe;

		$mainframe->setPageTitle(JText::_('Poll Preview'));

		$db 	=& JFactory::getDBO();
		$pollid = JRequest::getVar( 'pollid', 0, '', 'int' );
		$css = JRequest::getVar( 't', '' );

		$query = "SELECT title"
			. "\n FROM #__polls"
			. "\n WHERE id = $pollid"
		;
		$db->setQuery( $query );
		$title = $db->loadResult();

		$query = "SELECT text"
			. "\n FROM #__poll_data"
			. "\n WHERE pollid = $pollid"
			. "\n ORDER BY id"
		;
		$db->setQuery( $query );
		$options = $db->loadResultArray();

		JPollView::previewPoll($title, $options);
	}
}
?>