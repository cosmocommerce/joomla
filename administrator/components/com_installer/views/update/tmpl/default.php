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
?>
<form action="index.php" method="post" name="adminForm">
	<?php if ($this->showMessage) : ?>
		<?php echo $this->loadTemplate('message'); ?>
	<?php endif; ?>

	<?php if ($this->ftp) : ?>
		<?php echo $this->loadTemplate('ftp'); ?>
	<?php endif; ?>

	<?php if (count($this->items)) : ?>
	<table class="adminlist" cellspacing="1">
		<thead>
			<tr>
				<th width="10"><?php echo JText::_('Num'); ?></th>
				<th class="nowrap"><?php echo JText::_('Extension'); ?></th>
				<th><?php echo JText::_('INSTALL_TYPE') ?></th>
				<th><?php echo JText::_('EXTENSION_TYPE') ?></th>
				<th width="10%" class="center"><?php echo JText::_('Version'); ?></th>
				<th><?php echo JText::_('Folder') ?></th>
				<th><?php echo JText::_('JClient') ?></th>
				<th width="25%"><?php echo JText::_('DETAILS_URL'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
			<td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php for ($i=0, $n=count($this->items), $rc=0; $i < $n; $i++, $rc = 1 - $rc) : ?>
			<?php
				$this->loadItem($i);
				echo $this->loadTemplate('item');
			?>
		<?php endfor; ?>
		</tbody>
	</table>
	<?php else : ?>
		<p class="nowarning"><?php echo JText::_('ERRNOUPDATES'); ?></p>
	<?php endif; ?>

	<input type="hidden" name="view" value="update" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_installer" />
	<?php echo JHTML::_('form.token'); ?>
</form>