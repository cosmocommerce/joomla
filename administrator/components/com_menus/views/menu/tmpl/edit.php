<?php
/**
 * @version		$Id: edit.php 13031 2009-10-02 21:54:22Z louis $
 * @package		Joomla.Administrator
 * @subpackage	com_menus
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
<!--
	function submitbutton(task)
	{
		if (task == 'menu.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			submitform(task);
		}
	}
// -->
</script>

<form action="<?php JRoute::_('index.php?option=com_menus'); ?>" method="post" name="adminForm" id="item-form">
<div class="width-40">
	<fieldset>
		<legend><?php echo JText::_('Menus_Menu_Details');?></legend>

				<?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?>

				<?php echo $this->form->getLabel('menutype'); ?>
				<?php echo $this->form->getInput('menutype'); ?>

				<?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?>

	</fieldset>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="clr"></div>
