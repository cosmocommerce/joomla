<?php
/**
 * @version		$Id: Template.php 10398 2008-06-07 03:27:27Z roscohead $
 * @package		Joomla
 * @subpackage	Templates
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * @package		Joomla
 * @subpackage	Templates
 */
class TemplatesModelCssedit extends JModel
{
	/**
	 * Template id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Template data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * client object
	 *
	 * @var object
	 */
	var $_client = null;

	/**
	 * filename
	 *
	 * @var string
	 */
	var $_filename = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		$id	= JRequest::getVar('id', '', 'method', 'cmd');
		$this->setId($id);
		$this->_filename	= JRequest::getVar('filename', '', 'method', 'cmd');
		$this->_client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
	}

	/**
	 * Method to set the Template identifier
	 *
	 * @access	public
	 * @param	int Template identifier
	 */
	function setId($id)
	{
		// Set Template id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a Template
	 *
	 * @since 1.6
	 */
	function &getData()
	{
		// Load the data
		if (!$this->_loadData())
			$this->_initData();

		return $this->_data;
	}

	/**
	 * Method to get the client object
	 *
	 * @since 1.6
	 */
	function &getClient()
	{
		return $this->_client;
	}

	function &getTemplate()
	{
		return $this->_id;
	}

	function &getFilename()
	{
		return $this->_filename;
	}

	/**
	 * Method to store the Template
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.6
	 */
	function store($filecontent)
	{
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		$file = $this->_client->path.DS.'templates'.DS.$this->_id.DS.'css'.DS.$this->_filename;

		// Try to make the css file writeable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0755')) {
			$this->setError( JText::_('Could not make the css file writable'));
			return false;
		}

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);

		// Try to make the css file unwriteable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0555')) {
			$this->setError( JText::_('Could not make the css file unwritable'));
			return false;
		}

		if (!$return)
		{
			$this->setError( JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
			return false;
		}

		return true;
	}

	/**
	 * Method to load Template data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.6
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			jimport('joomla.filesystem.file');

			if (JFile::getExt($this->_filename) !== 'css') {
				return JError::raiseWarning( 500, JText::_('Wrong file type given, only CSS files can be edited.') );
			}

			$content = JFile::read($this->_client->path.DS.'templates'.DS.$this->_id.DS.'css'.DS.$this->_filename);

			if ($content === false)
			{
				$this->setError(JText::sprintf('Operation Failed Could not open', $this->_client->path.DS.'templates'.DS.$this->_id.DS.'css'.DS.$this->_filename));
				return false;
			}

			$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');

			$this->_data = $content;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the Template data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.6
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$template = new stdClass();
			$this->_data = $template;
			return (boolean) $this->_data;
		}
		return true;
	}
}