<?php
/**
 * @version		$Id: default.php 316 2009-05-27 16:14:41Z louis.landry $
 * @package		Joomla.Installation
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

defined('_JEXEC') or die('Invalid Request.');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the JavaScript behaviors.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script language="JavaScript" type="text/javascript">
<!--
	function validateForm(frm, task) {
		Joomla.submitform(task);
	}
// -->
</script>

<div id="stepbar">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	<div class="m">
		<h1><?php echo JText::_('Steps'); ?></h1>
		<div class="step-off">
			1 : <?php echo JText::_('Language'); ?>
		</div>
		<div class="step-off">
			2 : <?php echo JText::_('Pre-Installation check'); ?>
		</div>
		<div class="step-off">
			3 : <?php echo JText::_('License'); ?>
		</div>
		<div class="step-off">
			4 : <?php echo JText::_('Database'); ?>
		</div>
		<div class="step-off">
			5 : <?php echo JText::_('FTP Configuration'); ?>
		</div>
		<div class="step-on">
			6 : <?php echo JText::_('Configuration'); ?>
		</div>
		<div class="step-off">
			7 : <?php echo JText::_('Finish'); ?>
		</div>
		<div class="box"></div>
  	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="right">
	<div id="rightpad">
		<div id="step">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="far-right">
<?php if ($this->document->direction == 'ltr') : ?>
					<div class="button1-right"><div class="prev"><a href="index.php?view=filesystem" title="<?php echo JText::_('Previous'); ?>"><?php echo JText::_('Previous'); ?></a></div></div>
					<div class="button1-left"><div class="next"><a onclick="validateForm(adminForm, 'setup.saveconfig');" title="<?php echo JText::_('Next'); ?>"><?php echo JText::_('Next'); ?></a></div></div>
<?php elseif ($this->document->direction == 'rtl') : ?>
					<div class="button1-right"><div class="prev"><a onclick="validateForm(adminForm, 'setup.saveconfig');" title="<?php echo JText::_('Next'); ?>"><?php echo JText::_('Next'); ?></a></div></div>
					<div class="button1-left"><div class="next"><a href="index.php?view=filesystem" title="<?php echo JText::_('Previous'); ?>"><?php echo JText::_('Previous'); ?></a></div></div>
<?php endif; ?>
				</div>
				<span class="step"><?php echo JText::_('Main Configuration'); ?></span>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
		</div>
		<div id="installer">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<form action="index.php" method="post" name="adminForm">
				<h2><?php echo JText::_('Site Name'); ?></h2>
				<div class="install-text">
					<?php echo JText::_('ENTERSITENAME'); ?>
				</div>
				<div class="install-body">
					<div class="t">
						<div class="t">
							<div class="t"></div>
						</div>
					</div>
					<div class="m">
						<fieldset>
							<table class="content2">
								<tr>
									<td class="item">
										<label for="siteName"><span id="sitenamemsg"><?php echo JText::_('Site Name'); ?></span></label>
									</td>
									<td align="center">
										<input class="inputbox validate required sitename sitenamemsg" type="text" id="siteName" name="vars[siteName]" size="30" value="<?php echo !empty($this->options['siteName']) ? $this->options['siteName'] : ''; ?>" />
									</td>
								</tr>
							</table>
						</fieldset>
					</div>
					<div class="b">
						<div class="b">
							<div class="b"></div>
						</div>
					</div>
					<div class="clr"></div>
				</div>

				<div class="newsection"></div>

				<h2><?php echo JText::_('confTitle'); ?></h2>
				<div class="install-text">
					<?php echo JText::_('tipConfSteps'); ?>
				</div>
				<div class="install-body">
					<div class="t">
						<div class="t">
							<div class="t"></div>
						</div>
					</div>
					<div class="m">
						<fieldset>
							<table class="content2">
								<tr>
									<td class="item">
									<label for="adminEmail">
										<span id="emailmsg"><?php echo JText::_('Your E-mail'); ?></span>
									</label>
									</td>
									<td align="center">
									<input class="inputbox validate required email emailmsg" type="text" id="adminEmail" name="vars[adminEmail]" value="" size="30" />
									</td>
								</tr>
								<tr>
									<td class="item">
									<label for="adminPassword">
										<span id="passwordmsg"><?php echo JText::_('Admin password'); ?></span>
									</label>
									</td>
									<td align="center">
									<input class="inputbox validate required password passwordmsg" type="password" id="adminPassword" name="vars[adminPassword]" value="" size="30"/>
									</td>
								</tr>
								<tr>
									<td class="item">
									<label for="confirmAdminPassword">
										<span id="confirmpasswordmsg"><?php echo JText::_('Confirm admin password'); ?></span>
									</label>
									</td>
									<td align="center">
									<input class="inputbox validate required confirmpassword confirmpasswordmsg" type="password" id="confirmAdminPassword" name="vars[confirmAdminPassword]" value="" size="30"/>
									</td>
								</tr>
							</table>
						</fieldset>
					</div>
					<div class="b">
						<div class="b">
							<div class="b"></div>
						</div>
					</div>
					<div class="clr"></div>
				</div>

				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
			</form>

			<div class="clr"></div>

			<form enctype="multipart/form-data" action="index.php" method="post" name="filename" id="filename">
				<h2><?php echo JText::_('loadSampleOrMigrate'); ?></h2>
				<div class="install-text">
					<p><?php echo JText::_('LOADSQLINSTRUCTIONS1'); ?></p>
					<p><?php echo JText::_('LOADSQLINSTRUCTIONS2'); ?></p>
					<p><?php echo JText::_('LOADSQLINSTRUCTIONS3'); ?></p>
					<p><?php echo JText::_('LOADSQLINSTRUCTIONS7'); ?></p>
				</div>
				<div class="install-body">
				<div class="t">
					<div class="t">
						<div class="t"></div>
					</div>
				</div>
				<div class="m">
					<fieldset>
						<table class="content2">
							<tr>
								<td width="30%"></td>
								<td width="70%"></td>
							</tr>
							<tr>
								<td>
									<span id="theDefault"><input class="button" type="button" name="instDefault" value="<?php echo JText::_('clickToInstallDefault'); ?>" onclick="Install.sampleData(this);"/></span>
								</td>
								<td>
									<em><?php echo JText::_('tipInstallDefault'); ?></em>
								</td>
							</tr>
						</table>
					</fieldset>
				</div>
				<div class="b">
					<div class="b">
						<div class="b"></div>
					</div>
				</div>
			</div>
			<?php echo JHtml::_('form.token'); ?>
  		</form>

		<div class="clr"></div>
		</div>
		<div class="b">
			<div class="b">
				<div class="b"></div>
			</div>
		</div>
		</div>
	</div>
</div>

<div class="clr"></div>
