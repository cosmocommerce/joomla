<?php

/**
 * @version		$Id$
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldPassword extends JFormField
{

	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Password';

	/**
	 * Method to get the field input.
	 *
	 * @return	string		The field input.
	 */
	protected function _getInput()
	{
		$size = (string)$this->_element->attributes()->size ? ' size="'.$this->_element->attributes()->size.'"' : '';
		$class = (string)$this->_element->attributes()->class ? ' class="'.$this->_element->attributes()->class.'"' : ' class="text_area"';
		$auto = (string)$this->_element->attributes()->autocomplete == 'off' ? 'autocomplete="off"' : '';

		return '<input type="password" name="'.$this->inputName.'" id="'.$this->inputId.'" value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"'.$auto.$class.$size.'/>';
	}
}
