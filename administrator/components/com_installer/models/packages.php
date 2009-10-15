<?php
/**
 * @version		$Id: packages.php 12490 2009-07-06 11:57:32Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).DS.'extension.php';
jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.installer.packagemanifest');

/**
 * JPackageMan Default Model (List)
 *
 * @package    JPackageMan
 * @subpackage Models
 */
class InstallerModelPackages extends InstallerModel
{
	/**
	 * Extension Type
	 * @var string
	 */
	var $_type = 'package';

	/**
	 * Overridden constructor
	 * @access	protected
	 */
	function __construct()
	{
		$app	= &JFactory::getApplication();

		// Call the parent constructor
		parent::__construct();

		// Set state variables from the request
		$this->setState('filter.string', $app->getUserStateFromRequest("com_installer.packages.string", 'filter', '', 'string'));
		$this->setState('filter.client', $app->getUserStateFromRequest("com_installer.packages.client", 'client', -1, 'int'));
	}

	/**
	 * Load the data
	 */
	function _loadItems() {
		$rows = $this->listLibraries();
		$this->setState('pagination.total', count($rows));
		// if the offset is greater than the total, then can the offset
		if ($this->_state->get('pagination.offset') > $this->_state->get('pagination.total')) {
			$this->setState('pagination.offset',0);
		}

		if ($this->_state->get('pagination.limit') > 0) {
			$this->_items = array_slice($rows, $this->_state->get('pagination.offset'), $this->_state->get('pagination.limit'));
		} else {
			$this->_items = $rows;
		}
		return $this->_items;
	}

    function &listLibraries() {
		$files =  JFolder::files(JPATH_MANIFESTS.DS.'packages');
		$retval = Array();
		$file = $files[0];

		foreach($files as $file) {
			if (strtolower(JFile::getExt($file)) == 'xml') {
				$retval[] = new JPackageManifest(JPATH_MANIFESTS.DS.'packages' . DS . $file);
			}
		}
		return $retval;

    }


    function uninstall($packid) {
    	// Get an installer object for the extension type
		jimport('joomla.installer.installer');
		$installer = & JInstaller::getInstance();
		return $installer->uninstall('package', $packid, 0);
    }

    function removeManifest($packid) {
    	return JFile::delete(JPATH_MANIFESTS.DS.'packages' . DS . $packid .'.xml');
    }

    function &getDetails($file) {
		$package = new JPackageManifest();
		$retval = false;
		$package->manifest_filename = $file;
		if ($package->loadManifestFromXML(JPATH_MANIFESTS.DS.'packages' . DS . $file . '.xml'))
			return $package;
		else
			return $retval;
    }
}
