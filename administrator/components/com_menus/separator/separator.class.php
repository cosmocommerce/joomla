<?php
/**
* @version $Id: separator.class.php,v 1.1 2005/08/25 14:14:33 johanjanssens Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Menus
*/
class separator_menu {

	/**
	* @param database A database connector object
	* @param integer The unique id of the category to edit (0 if new)
	*/
	function edit( $uid, $menutype, $option ) {
		global $database, $my, $mainframe;
		global $_LANG;

		$menu = new mosMenu( $database );
		$menu->load( $uid );

		// fail if checked out not by 'me'
		if ($menu->checked_out && $menu->checked_out <> $my->id) {
			mosErrorAlert( $_LANG->_( 'The module' ) .' '. $menu->title .' '. $_LANG->_( 'descBeingEditted' ) );
		}

		if ($uid) {
			// do stuff for existing item
			$menu->checkout( $my->id );

		} else {
			// do stuff for new item
			$menu->type 		= 'separator';
			mosMenuFactory::setValues( $menu, $menutype );
		}

		if ( empty( $menu->name ) ) {
			$menu->name = '- - - - - - -';
		}

		// build common lists
		mosMenuFactory::buildLists( $lists, $menu, $uid );

		// get params definitions
		$params =& new mosParameters( $menu->params, $mainframe->getPath( 'menu_xml', $menu->type ), 'menu' );

		separator_menu_html::edit( $menu, $lists, $params, $option );
	}
}
?>