<?php
/**
 * @version $Id: mod_newsflash.php,v 1.2 2005/08/29 15:52:20 alekandreev Exp $
 * @package Mambo
 * @subpackage Modules
 * @copyright (C) 2000 - 2005 Miro International Pty Ltd
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Mambo is Free Software
 */

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class modNewsflashData {

	function &getRows( &$params ) {
		global $my, $mainframe, $database;
		global $mosConfig_shownoauth, $mosConfig_zero_date, $acl;

		$now = $mainframe->getDateTime();

		$catid 				= intval( $params->get( 'catid' ) );
		$style 				= $params->get( 'style' );
		$image 				= $params->get( 'image' );
		$readmore 			= $params->get( 'readmore' );
		$items 				= intval( $params->get( 'items' ) );
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );

		$params->set( 'intro_only', 		1 );
		$params->set( 'hide_author', 		1 );
		$params->set( 'hide_createdate', 	0 );
		$params->set( 'hide_modifydate', 	1 );

		if ( ( $items ) && ( $style != 'flash' ) && ( $style != 'random' ) ) {
			$limit = $items;
		} else {
			$limit = null;
		}

		$noauth = !$mainframe->getCfg( 'shownoauth' );

		// query to determine article count
		$query = "SELECT a.id"
		."\n FROM #__content AS a"
		."\n INNER JOIN #__categories AS b ON b.id = a.catid"
		."\n WHERE a.active = 1 AND a.state = 1"
		. ( $noauth ? "\n AND a.access <= '$my->gid' AND b.access <= '$my->gid'" : '' )
		."\n AND ( a.publish_up = '$mosConfig_zero_date' OR a.publish_up <= '$now' )"
		."\n AND ( a.publish_down = '$mosConfig_zero_date' OR a.publish_down >= '$now' )"
		."\n AND catid = '$catid'"
		."\n ORDER BY a.ordering"
		;
		$database->setQuery( $query, 0, $limit );
		$rows = $database->loadResultArray();
		$nrows = count( $rows );

		$row = new mosContent( $database );

		//mosFS::load( 'components/com_content/content.html.php' );

		if ($nrows > 0) {
			if ($style == '' || $style == 'random') {
				$id = rand( 0, $nrows - 1 );
				$rows = array( $rows[$id] );
			}

			$query = 'SELECT *' .
					' FROM #__content' .
					' WHERE active = 1 AND id=' . implode( ' OR id=', $rows );
			$database->setQuery( $query, 0, $limit );
			$rows = $database->loadObjectList();

			return $rows;
		}
	}
}

/**
 * @package Mambo
 * @subpackage Modules
 */
class modNewsflash {

	function show ( &$params ) {
		global $my;

		$cache  = mosFactory::getCache( "mod_newsflash" );

		$cache->setCaching($params->get('cache', 1));
		$cache->setLifeTime($params->get('cache_time', 900));
		$cache->setCacheValidation(true);

		$cache->callId( "modNewsflash::_display", array( $params ), "mod_newsflash".$my->gid );
	}

	function _display( &$params ) {
		global $_MAMBOTS;

		$rows = modNewsflashData::getRows( $params );

		$tmpl =& moduleScreens::createTemplate( 'mod_newsflash.html' );

		// process the new bots
		$_MAMBOTS->loadBotGroup( 'content' );

		$nrows = count( $rows );
		for ($i = 0; $i < $nrows; $i++) {
			$row =& $rows[$i];
			$row->text 		= $row->introtext;
			$row->groups 	= '';
			$_MAMBOTS->trigger( 'onPrepareContent', array( &$row, &$params ), true );
		}

		$tmpl->addVar( 'mod_newsflash', 'class', $params->get( 'moduleclass_sfx' ) );
		$tmpl->addObject( 'mod_newsflash-items', $rows, 'row_' );
		$tmpl->addObject( 'mod_newsflash', $params->toObject(), 'p_' );

		$tmpl->displayParsedTemplate( 'mod_newsflash' );
	}
}

modNewsflash::show( $params );
?>