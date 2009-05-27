<?php
/**
 * @version		$Id: vote.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

// no direct access
defined('_JEXEC') or die;

$mainframe->registerEvent('onBeforeDisplayContent', 'plgContentVote');

function plgContentVote(&$row, &$params, $page=0)
{
	$uri = & JFactory::getURI();

	$id 	= $row->id;
	$html 	= '';

	if (isset($row->rating_count) && $params->get('show_vote') && !$params->get('popup'))
	{
		JPlugin::loadLanguage('plg_content_vote');
		$html .= '<form method="post" action="' . $uri->toString() . '">';
		$img = '';

		// look for images in template if available
		$starImageOn 	= JHtml::_('image.site',  'rating_star.png', '/images/M_images/');
		$starImageOff 	= JHtml::_('image.site',  'rating_star_blank.png', '/images/M_images/');

		for ($i=0; $i < $row->rating; $i++) {
			$img .= $starImageOn;
		}
		for ($i=$row->rating; $i < 5; $i++) {
			$img .= $starImageOff;
		}
		$html .= '<span class="content_rating">';
		$html .= JText::_('User Rating') .':'. $img .'&nbsp;/&nbsp;';
		$html .= intval($row->rating_count);
		$html .= "</span>\n<br />\n";

		if (!$params->get('intro_only'))
		{
			$html .= '<span class="content_vote">';
			$html .= JText::_('Poor');
			$html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
			$html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
			$html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
			$html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
			$html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
			$html .= JText::_('Best');
			$html .= '&nbsp;<input class="button" type="submit" name="submit_vote" value="'. JText::_('Rate') .'" />';
			$html .= '<input type="hidden" name="task" value="vote" />';
			$html .= '<input type="hidden" name="option" value="com_content" />';
			$html .= '<input type="hidden" name="cid" value="'. $id .'" />';
			$html .= '<input type="hidden" name="url" value="'.  $uri->toString() .'" />';
			$html .= '</span>';
		}
		$html .= '</form>';
	}
	return $html;
}