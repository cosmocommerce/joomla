<?php
/**
* @version $Id: content_category.menu.php,v 1.1 2005/08/25 14:14:32 johanjanssens Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $task;
global $cid, $menutype, $option;

switch ($task) {
	case 'content_category':
		// this is the new item, ie, the same name as the menu `type`
		content_category_menu::editCategory( 0, $menutype, $option );
		break;

	case 'edit':
		content_category_menu::editCategory( $cid[0], $menutype, $option );
		break;

	case 'save':
	case 'apply':
		saveMenu( $option, $task );
		break;
}
?>