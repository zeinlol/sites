<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.9.4
 * @author	acyba.com
 * @copyright	(C) 2009-2015 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div id="acy_content">
	<form action="<?php echo JRoute::_('index.php?option=com_acymailing&tmpl=component'); ?>" method="post" name="adminForm" id="adminForm" autocomplete="off">
		<fieldset class="acyheaderarea">
			<div class="acyheader icon-48-acytemplate" style="float: left;"><?php echo JText::_('ACY_CUSTOMTEMPLATE'); ?></div>
			<div class="toolbar" id="toolbar" style="float: right;">
				<table>
					<tr>
						<td><?php include_once(ACYMAILING_BUTTON.DS.'pophelp.php');
							$helpButton = new JButtonPophelp();
							echo $helpButton->fetchButton('Pophelp','plugin-'.$this->help); ?></td>
						<td><span class="divider"></span></td>
						<td><a onclick="javascript:submitbutton('apply'); return false;" href="#" ><span class="icon-32-save" title="<?php echo JText::_('ACY_SAVE',true); ?>"></span><?php echo JText::_('ACY_SAVE'); ?></a></td>
					</tr>
				</table>
			</div>
		</fieldset>
		<div id="iframedoc" style="clear:both;position:relative;"></div>
		<table class="paramlist admintable" width="100%">
			<tr>
				<td class="paramlist_key">
					<label for="subject">
						<?php echo JText::_( 'TEMPLATE_NAME' ); ?>
					</label>
				</td>
				<td class="paramlist_value">
					<?php echo $this->plugin; ?>.php
				</td>
			</tr>
		</table>
		<fieldset class="adminform" style="width:95%;" id="textfieldset">
			<legend><?php echo JText::_('ACY_TEMPLATE'); ?></legend>
			<textarea style="width:99%;" rows="16" name="templatebody" id="templatebody" ><?php echo $this->body; ?></textarea>
		</fieldset>

		<div class="clr"></div>

		<input type="hidden" name="option" value="<?php echo ACYMAILING_COMPONENT; ?>" />
		<input type="hidden" name="ctrl" value="tag" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="plugin" value="<?php echo $this->plugin; ?>" />
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>
