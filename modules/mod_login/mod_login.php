<?php
/**
 * @version		$Id: mod_login.php 11952 2009-06-01 03:21:19Z robs $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$params->def('greeting', 1);

$type 	= modLoginHelper::getType();
$return	= modLoginHelper::getReturnURL($params, $type);

$user = &JFactory::getUser();

require JModuleHelper::getLayoutPath('mod_login');