<?php
/**
 * @version		$Id: default_system.php 12885 2009-09-28 18:13:26Z severdia $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div class="width-100">
	<fieldset class="adminform">
		<legend><?php echo JText::_('System Settings'); ?></legend>
			<?php
			foreach ($this->form->getFields('system') as $field):
			?>
				<?php echo $field->label; ?>
				<?php echo $field->input; ?>
			<?php
			endforeach;
			?>
	</fieldset>
</div>