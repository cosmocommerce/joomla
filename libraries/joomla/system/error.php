<?php
/**
* @version $Id$
* @package JoomlaFramework
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport('pattemplate.patErrorManager');

/**
 * Error Handling Class
 *
 * This class is an proxy of the patError class
 *
 * @static
 * @package JoomlaFramework
 * @since 1.1
 */
class JError extends patErrorManager {

	/**
	* method for checking whether the return value of a pat application method is a pat
	* error object.
	*
	* @static
	* @access	public
	* @param	mixed	&$object
	* @return	boolean $result	True if argument is a JError-object, false otherwise.
	*/
    function isError( &$object ) {
		return JError::isError($object);
    }

   /**
	* wrapper for the {@link raise()} method where you do not have to specify the
	* error level - a {@link patError} object with error level E_ERROR will be returned.
	*
	* @static
	* @access	public
	* @param	string	$code	The application-internal error code for this error
	* @param	string	$msg	The error message, which may also be shown the user if need be.
	* @param	mixed	$info	Optional: Additional error information (usually only developer-relevant information that the user should never see, like a database DSN).
	* @return	object	$error	The configured JError object
	* @see		patErrorManager
	*/
	function &raiseError( $code, $msg, $info = null ) {
		return JError::raise( E_ERROR, $code, $msg, $info );
	}

   /**
	* wrapper for the {@link raise()} method where you do not have to specify the
	* error level - a {@link patError} object with error level E_WARNING will be returned.
	*
	* @static
	* @access	public
	* @param	string	$code	The application-internal error code for this error
	* @param	string	$msg	The error message, which may also be shown the user if need be.
	* @param	mixed	$info	Optional: Additional error information (usually only developer-relevant information that the user should never see, like a database DSN).
	* @return	object	$error	The configured JError object
	* @see		patErrorManager
	*/
	function &raiseWarning( $code, $msg, $info = null ) {
		return JError::raise( E_WARNING, $code, $msg, $info );
	}

   /**
	* wrapper for the {@link raise()} method where you do not have to specify the
	* error level - a {@link patError} object with error level E_NOTICE will be returned.
	*
	* @static
	* @access	public
	* @param	string	$code	The application-internal error code for this error
	* @param	string	$msg	The error message, which may also be shown the user if need be.
	* @param	mixed	$info	Optional: Additional error information (usually only developer-relevant information that the user should never see, like a database DSN).
	* @return	object	$error	The configured JError object
	* @see		patErrorManager
	*/
	function &raiseNotice( $code, $msg, $info = null ) {
		return JError::raise( E_NOTICE, $code, $msg, $info );
	}

	/**
	* creates a new patError object given the specified information.
	*
	* @access	public
	* @param	int		$level	The error level - use any of PHP's own error levels for this: E_ERROR, E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE.
	* @param	string	$code	The application-internal error code for this error
	* @param	string	$msg	The error message, which may also be shown the user if need be.
	* @param	mixed	$info	Optional: Additional error information (usually only developer-relevant information that the user should never see, like a database DSN).
	* @return	mixed	$error	The configured patError object or false if this error should be ignored
	* @see		patError
	*/
    function &raise( $level, $code, $msg, $info = null )
    {
		// ignore this error?
		if( in_array( $code, $GLOBALS['_pat_errorIgnores'] ) )
		{
			return false;
		}

		// this error was expected
		if( !empty( $GLOBALS['_pat_errorExpects'] ) )
		{
			$expected =	array_pop( $GLOBALS['_pat_errorExpects'] );
			if( in_array( $code, $expected ) )
			{
				return false;
			}
		}

		// need patError
		$class	=	$GLOBALS['_pat_errorClass'];
		if( !class_exists( $class ) )
		{
			jimport('pattemplate.patError');
		}

		// build error object
		$error			=&	new	$class( $level, $code, $msg, $info );

		// see what to do with this kind of error
		$handling	=	patErrorManager::getErrorHandling( $level );

		$function	=	'handleError' . ucfirst( $handling['mode'] );
		return JError::$function( $error, $handling );
    }

   /**
	* handleError: Echo
	* display error message
	*
	* @access private
	* @param object $error patError-Object
	* @param array $options options for handler
	* @return object $error error-object
	* @see raise()
	*/
    function &handleErrorEcho( &$error, $options )
    {
		$level_human	=	patErrorManager::translateErrorLevel( $error->getLevel() );

		if( isset( $_SERVER['HTTP_HOST'] ) )
		{
			// output as html
			echo "<br /><b>jos-$level_human</b>: " . $error->getMessage() . "<br />\n";
		}
		else
		{
			// output as simple text
			if( defined( 'STDERR' ) )
			{
				fwrite( STDERR, "jos-$level_human: " . $error->getMessage() . "\n" );
			}
			else
			{
				echo "jos-$level_human: " . $error->getMessage() . "\n";
			}
		}
		return $error;
    }

   /**
	* handleError: Verbose
	* display verbose output for developing purpose
	*
	* @access private
	* @param object $error patError-Object
	* @param array $options options for handler
	* @return object $error error-object
	* @see raise()
	*/
    function &handleErrorVerbose( &$error, $options )
    {
		$level_human	=	patErrorManager::translateErrorLevel( $error->getLevel() );
		$info			=	$error->getInfo();

		if( isset( $_SERVER['HTTP_HOST'] ) )
		{
			// output as html
			echo "<br /><b>jos-$level_human</b>: " . $error->getMessage() . "<br />\n";
			if( $info != null )
			{
				echo "&nbsp;&nbsp;&nbsp;" . $error->getInfo() . "<br />\n";
			}
			echo $error->getBacktrace( true );
		}
		else
		{
			// output as simple text
			echo "jos-$level_human: " . $error->getMessage() . "\n";
			if( $info != null )
			{
				echo "    " . $error->getInfo() . "\n";
			}

		}
		return $error;
    }

   /**
	* handleError: die
	* display error-message and die
	*
	* @access private
	* @param object $error patError-Object
	* @param array $options options for handler
	* @return object $error error-object
	* @see raise()
	*/
    function &handleErrorDie( &$error, $options )
    {
		$level_human	=	patErrorManager::translateErrorLevel( $error->getLevel() );

		if( isset( $_SERVER['HTTP_HOST'] ) )
		{
			// output as html
			die( "<br /><b>jos-$level_human</b> " . $error->getMessage() . "<br />\n" );
		}
		else
		{
			// output as simple text
			if( defined( 'STDERR' ) )
			{
				fwrite( STDERR, "jos-$level_human " . $error->getMessage() . "\n" );
			}
			else
			{
				die( "jos-$level_human " . $error->getMessage() . "\n" );
			}
		}
		return $error;
    }
}

?>