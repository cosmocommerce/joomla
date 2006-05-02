<?php
/**
* @version $Id: offlinebar.php,v 1.1 2005/08/25 14:24:07 johanjanssens Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( 'includes/mambo.php' );

global $option, $database;
global $mosConfig_live_site;

$_LANG = mosFactory::getLanguage( $option );
$_LANG->debug( $mosConfig_debug );

// gets template for page
$query = "SELECT template"
. "\n FROM #__templates_menu"
. "\n WHERE client_id = '0'"
;
@$database->setQuery( $query );
$cur_template =  @$database->loadResult();
if ( !$cur_template ) {
	$cur_template = 'rhuk_solarflare_ii';
}

// HTML Output

// xml prolog
echo '<?xml version="1.0" encoding="'. $_LANG->iso() .'"?' .'>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
table.moswarning {
	font-size: 200%;
	background-color: #c00; 
	color: #fff; 
	border-bottom: 2px solid #600
}

table.moswarning h2 {
	padding: 0;
	margin: 0;	
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_LANG->iso(); ?>" />
<title><?php echo $mosConfig_sitename; ?> - Offline</title>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/templates/<?php echo $cur_template;?>/css/template_css.css" type="text/css" />
</head>
<body style="margin: 0px; padding: 0px;">
<table width="100%" align="center" class="moswarning">
	<?php if ( $mosConfig_offline == 1 ) { ?>
	<tr>
		<td>
		<h2>
	<?php	
		echo $mosConfig_sitename;
		echo ' - '; 
		echo $mosConfig_offline_message;
	?>
		</h2>
	</td></tr>
	<?php
	}
	else if (@$mosSystemError){
	?>
	<tr> 
		<td>
		<h2>
		<?php echo $mosConfig_error_message; ?>
		</h2>
		<?php echo $mosSystemError; ?>
		</td>
	</tr>
	<?php
} else {
	?>
	<tr> 
		<td>
		<h2>
		<?php echo $_LANG->_( 'INSTALL_WARN' ); ?>
		</h2>
		</td>
	</tr>
	<?php
}
?>
</table>

</body>
</html>