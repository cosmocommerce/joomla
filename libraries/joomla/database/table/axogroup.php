<?php
/**
* @version		$Id$
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

require_once(dirname(__FILE__).DS.'tree.php');

/**
 * AroGroup table
 *
 * @package 		Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class JTableAXOGroup extends JTableTree
{
	/** @var int Primary key */
	protected $id			= null;

	protected $name		= null;

	protected $value		= null;

	/**
	 * Constructor
	 *
	 * @param	JDatabase	$db
	 */
	protected function __construct( &$db )
	{
		parent::__construct( '#__core_acl_axo_groups', 'id', $db );
	}
}