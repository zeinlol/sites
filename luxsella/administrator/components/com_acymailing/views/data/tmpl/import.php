<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.9.4
 * @author	acyba.com
 * @copyright	(C) 2009-2015 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div id="acy_content" >
<div id="iframedoc"></div>
<form action="<?php echo JRoute::_('index.php?option='.ACYMAILING_COMPONENT); ?>" method="post" name="adminForm" enctype="multipart/form-data" id="adminForm" >
	<input type="hidden" name="option" value="<?php echo ACYMAILING_COMPONENT; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ctrl" value="<?php echo JRequest::getCmd('ctrl'); ?>" />
	<?php if(!empty($this->Itemid)) echo '<input type="hidden" name="Itemid" value="'.$this->Itemid.'" />';
	echo JHTML::_( 'form.token' ); ?>
	<style>
		#acy_content .oneBlock{
		<?php if(JFactory::getApplication()->isAdmin()){ ?>
			float: left;
			width: 49%;
			padding: 5px;
			min-width: 500px;
		<?php }else{ ?>
			width: 100%;
		<?php } ?>
		}
	</style>
	<div style="width:100%;">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'IMPORT_FROM' ); ?></legend>
			<?php echo JHTML::_('acyselect.radiolist',   $this->importvalues, 'importfrom', 'class="inputbox" size="1" onclick="updateImport(this.value);"', 'value', 'text',JRequest::getCmd('importfrom','textarea')); ?>
		</fieldset>
		<div class="oneBlock">
			<div>
			<?php foreach($this->importdata as $div => $name){
				echo '<div id="'.$div.'"';
				if($div != JRequest::getCmd('importfrom','textarea')) echo ' style="display:none"';
				echo '>';
				echo '<fieldset class="adminform">';
				echo '<legend>'.$name.'</legend>';
				include(dirname(__FILE__).DS.$div.'.php');
				echo '</fieldset>';
				echo '</div>';
				}?>
			</div>
		</div>
		<div class="oneBlock">
			<fieldset class="adminform" id="importlists">
				<legend><?php echo JText::_( 'IMPORT_SUBSCRIBE' ); ?></legend>
				<?php if(acymailing_isAllowed($this->config->get('acl_lists_manage','all'))){ ?>
				<table class="adminlist table table-striped" cellpadding="1">
					<tr class="<?php echo "row1"; ?>" id="importcreatelist">
						<td colspan="2">
							<?php echo JText::_('IMPORT_SUBSCRIBE_CREATE').' : <input type="text" name="createlist" placeholder="'.JText::_('LIST_NAME').'" />'; ?>
						</td>
					</tr>
				</table>
				<?php }
					$currentPage = 'import';
					$currentValues = JRequest::getVar('importlists');
					$listid = JRequest::getInt('listid');
					include_once(ACYMAILING_BACK.'views'.DS.'list'.DS.'tmpl'.DS.'filter.lists.php');
				?>
			</fieldset>
		</div>
	</div>
</form>
</div>
