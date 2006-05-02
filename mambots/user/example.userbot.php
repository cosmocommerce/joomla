<?php
/**
* @version $Id: example.userbot.php,v 1.1 2005/08/25 14:23:44 johanjanssens Exp $
* @package Mambo
* @subpackage Mambots
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/*
 * User management events
 *
 * Mambo triggers two user management events u can use to sync the database of Mambo
 * with a third party application.
 */

 //Store User events
$_MAMBOTS->registerFunction( 'onBeforeStoreUser', 'botExampleBeforeStoreUser' );
$_MAMBOTS->registerFunction( 'onAfterStoreUser' , 'botExampleAfterStoreUser'  );

//Delete User events
$_MAMBOTS->registerFunction( 'onBeforeDeleteUser', 'botExampleBeforeDeleteUser' );
$_MAMBOTS->registerFunction( 'onAfterDeleteUser' , 'botExampleAfterDeleteUser'  );

/*
 * User session events
 *
 * Mambo triggers two user session events u can use to authenticate users with
 * external services, like for example LDAP.
 */

 //Login User event
$_MAMBOTS->registerFunction( 'onLoginUser', 'botMamboLoginUser' );

//Logout User event
$_MAMBOTS->registerFunction( 'onLogoutUser', 'botMamboLogoutUser' );

/**
* Example store user method
* Method is called before user data is stored in the database
* @param 	array	  	holds the user data
* @param 	boolean		true if a new user is stored
*/
function botExampleBeforeStoreUser($user, $isnew)
{
	global $mosConfig_db;

	//Make sure
	 mysql_select_db($mosConfig_db);
}

/**
* Example store user method
* Method is called after user data is stored in the database
* @param 	array	  	holds the user data
* @param 	boolean		true if a new user is stored
* @param	boolean		true if user was succesfully stored in the database
* @param	string		message
*/
function botExampleAfterStoreUser($user, $isnew, $succes, $msg)
{
	global $mosConfig_db;

	/*
	 * convert the user parameters passed to the event to a format the
	 * external appliction understands
	 */

	$args = array();
	$args['username'] = $user['username'];
	$args['email'] 	  = $user['email'];
	$args['fullname'] = $user['name'];
	$args['password'] = $user['password'];

	if($isnew) {
		// Call a function in the external app to create the user
		// ThirdPartyApp::createUser($user['id'], $args);
	} else {
		// Call a function in the external app to update the user
		// ThirdPartyApp::updateUser($user['id'], $args);
	}

	//Make sure
	 mysql_select_db($mosConfig_db);
}

/**
* Example store user method
* Method is called before user data is deleted from the database
* @param 	array	  	holds the user data
*/
function botExampleBeforeDeleteUser($user)
{
	global $mosConfig_db;

	//Make sure
	 mysql_select_db($mosConfig_db);
}

/**
* Example store user method
* Method is called after user data is deleted from the database
* @param 	array	  	holds the user data
* @param	boolean		true if user was succesfully stored in the database
* @param	string		message
*/
function botExampleAfterDeleteUser($user, $succes, $msg)
{
	global $mosConfig_db;

	/*
	 * only the $user['id'] exists and carries valid information
	 */

	// Call a function in the external app to delete the user
	// ThirdPartyApp::deleteUser($user['id']);

	//Make sure
	 mysql_select_db($mosConfig_db);
}


/**
* Example login user method
* Method is called when a user is login in
* @param 	string	The user name
* @param	string	The password
* @return	int		The id of the user
*/
function botExampleLoginUser( $username, $password )
{
	global $mainframe, $_LANG;

	/*
	 * function can be used in two ways
	 * 	1. Authenticate user using an external protocol
	 *  2. Log the user on a external app
	 */

	// 1. Call a function in the external app to authenticate the user and
	//    ThirdPartyApp::authenticateUser($user->username, $user->password);

	if ($authenticated) {
		//Add the user to the mambo database and return the userid
		return $userid;
	} else {
		return 0;
	}

	// 2. Call a function in the external app to authenticate the user and
	//    ThirdPartyApp::loginUser($user->username, $user->password);
}

/**
* Example login user method
* Method is called when a user is login out
* @param 	array	  	holds the user data
*/
function botExampleLogoutUser( $user )
{
	// Call a function in the external app log the user out
	// ThirdPartyApp::logoutUser($user->username, $user->password);
}
?>