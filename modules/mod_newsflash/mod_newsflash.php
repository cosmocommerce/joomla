<?php
/**
 * @version		$Id: mod_newsflash.php 11952 2009-06-01 03:21:19Z robs $
 * @package		Joomla.Site
 * @subpackage	mod_newsflash
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$params->set('intro_only', 1);
$params->set('hide_author', 1);
$params->set('hide_createdate', 0);
$params->set('hide_modifydate', 1);


// Disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;

$list = modNewsFlashHelper::getList($params, $access);

// check if any results returned
$items = count($list);
if (!$items) {
	return;
}

$layout = $params->get('layout', 'default');
$layout = JFilterInput::clean($layout, 'word');
$path = JModuleHelper::getLayoutPath('mod_newsflash', $layout);
if (file_exists($path)) {
	require $path;
}
