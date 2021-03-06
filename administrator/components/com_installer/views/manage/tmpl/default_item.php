<?php
/**
 * @version		$Id$
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$lang = &JFactory::getLanguage();
$lang->load($this->item->name, JPATH_ADMINISTRATOR);
$lang->load($this->item->name, JPATH_SITE);
?>
<tr class="<?php echo "row".$this->item->index % 2; ?>" <?php echo $this->item->style; ?>>
	<td><?php echo $this->pagination->getRowOffset($this->item->index); ?></td>
	<td>
		<input type="checkbox" id="cb<?php echo $this->item->index;?>" name="eid[]" value="<?php echo $this->item->extension_id; ?>" onclick="isChecked(this.checked);" <?php echo $this->item->cbd; ?> />
		<span class="bold"><?php echo stripslashes(JText::_($this->item->name)); ?></span>
	</td>
	<td>
		<?php echo $this->item->type ?>
	</td>
	<td class="center">
		<?php if (!$this->item->element) : ?>
		<strong>X</strong>
		<?php else : ?>
		<a href="index.php?option=com_installer&amp;type=manage&amp;task=<?php echo $this->item->task; ?>&amp;eid[]=<?php echo $this->item->extension_id; ?>&amp;limitstart=<?php echo $this->pagination->limitstart; ?>&amp;<?php echo JUtility::getToken();?>=1"><?php echo JHTML::_('image', 'images/'.$this->item->img, $this->item->alt, array( 'border' => 0, 'title' => $this->item->action)); ?></a>
		<?php endif; ?>
	</td>
	<td class="center"><?php echo @$this->item->version != '' ? $this->item->version : '&nbsp;'; ?></td>
	<td><?php echo @$this->item->creationdate != '' ? $this->item->creationdate : '&nbsp;'; ?></td>
	<td class="center"><?php echo @$this->item->folder != '' ? $this->item->folder : 'N/A'; ?></td>
	<td class="center"><?php echo @$this->item->client != '' ? $this->item->client : 'N/A'; ?></td>
	<td>
		<span class="editlinktip hasTip" title="<?php echo JText::_('AUTHOR_INFORMATION');?>::<?php echo $this->item->author_info; ?>">
			<?php echo @$this->item->author != '' ? $this->item->author : '&nbsp;'; ?>
		</span>
	</td>
	<td><?php echo $this->item->extension_id ?></td>
</tr>
