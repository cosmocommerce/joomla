<?php
/**
 * @version		$Id: helper.php 11952 2009-06-01 03:21:19Z robs $
 * @package		Joomla.Site
 * @subpackage	mod_syndicate
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modSyndicateHelper
{
	function getLink(&$params)
	{
		$document = &JFactory::getDocument();

		foreach($document->_links as $link)
		{
			if (strpos($link, 'application/'.$params->get('format').'+xml')) {
				preg_match("#href=\"(.*?)\"#s", $link, $matches);
				return $matches[1];
			}
		}

	}
}