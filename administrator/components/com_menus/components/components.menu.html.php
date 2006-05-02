<?php
/**
* @version $Id: components.menu.html.php,v 1.1 2005/08/25 14:14:28 johanjanssens Exp $
* @package Mambo
* @subpackage Menus
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Writes the edit form for new and existing content item
*
* A new record is defined when <var>$row</var> is passed with the <var>id</var>
* property set to 0.
* @package Mambo
* @subpackage Menus
*/
class components_menu_html {

	function edit( &$menu, &$components, &$lists, &$params, $option ) {
  		global $_LANG;

		if ( $menu->id ) {
			$title = '[ '. $lists['componentname'] .' ]';
		} else {
			$title = '';
		}
		
		mosCommonHTML::loadOverlib();
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			var comp_links = new Array;
			<?php
			foreach ($components as $row) {
				?>
				comp_links[ <?php echo $row->value;?> ] = 'index.php?<?php echo addslashes( $row->link );?>';
				<?php
			}
			?>
			if ( form.id.value == 0 ) {
				var comp_id = getSelectedValue( 'adminForm', 'componentid' );
				form.link.value = comp_links[comp_id];
			} else {
				form.link.value = comp_links[form.componentid.value];
			}

			if ( trim( form.name.value ) == "" ){
				alert( "<?php echo $_LANG->_( 'Item must have a name' ); ?>" );
			} else if (form.componentid.value == ""){
				alert( "<?php echo $_LANG->_( 'Please select a Component' ); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<?php
		$type = 2;
		if ( !$menu->id ) {
			$type 	= 0;
			$params = '<strong>'. $_LANG->_( 'TIPPARAMLISTAVAILABLEONCESAVENEWMENUITEM' ) .'</strong>';
		}
		$text = 'Component - '. $title;		
		
		mosMenuFactory::formStart( $text );
		
		mosMenuFactory::tableStart();
		mosMenuFactory::formElementName( $menu->name );
		
		mosMenuFactory::formElement( $lists['componentid'], $_LANG->_( 'Component' ) );

		mosMenuFactory::formElement( $lists['link'], 		'URL' );
		mosMenuFactory::formElement( $lists['target'], 		'TAR' );
		mosMenuFactory::formElement( $lists['parent'], 		'PAR' );
		mosMenuFactory::formElement( $lists['ordering'], 	'ORD' );
		mosMenuFactory::formElement( $lists['access'], 		'ACC' );
		mosMenuFactory::formElement( $lists['published'], 	'PUB' );
		mosMenuFactory::tableEnd();
		
		mosMenuFactory::formParams( $params, $type );		
		?>
		<input type="hidden" name="link" value="" />		
		<?php
		mosMenuFactory::formElementHdden( $menu, $option );
	}

}
?>