<?php
/**
 * @version		$Id$
 * @package  	Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Banners Controller
 *
 * @package  	Joomla
 * @subpackage	Banners
 * @since		1.5
 */
class BannersController extends JController
{
	function click()
	{
		$bid = JRequest::getInt('bid', 0);
		if ($bid)
		{
			$model = &$this->getModel('Banner');
			$model->click($bid);
			$this->setRedirect($model->getUrl($bid));
		}
	}
}