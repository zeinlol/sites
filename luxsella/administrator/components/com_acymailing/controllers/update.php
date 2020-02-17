<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.9.4
 * @author	acyba.com
 * @copyright	(C) 2009-2015 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

class UpdateController extends acymailingController{

	function __construct($config = array()){
		parent::__construct($config);
		$this->registerDefaultTask('update');
	}

	function listing(){
		return $this->update();
	}

	function install(){
		acymailing_increasePerf();

		$newConfig = new stdClass();
		$newConfig->installcomplete = 1;
		$config = acymailing_config();

		$updateHelper = acymailing_get('helper.update');

		if(!$config->save($newConfig)){
			$updateHelper->installTables();
			return;
		}

		jimport('joomla.filesystem.folder');
		$frontLanguages = JFolder::folders(JPATH_ROOT.DS.'language', '-');
		$backLanguages = JFolder::folders(JPATH_ADMINISTRATOR.DS.'language', '-');
		$installedLanguages = array_unique(array_merge($frontLanguages, $backLanguages));
		if(($key = array_search('en-GB', $installedLanguages)) !== false) unset($installedLanguages[$key]);

		if(!empty($installedLanguages)){
			$langText = JText::_('ACY_INSTALL_LANGUAGES');
			if($langText == 'ACY_INSTALL_LANGUAGES') $langText = 'Click here to install the new language files';
			JHTML::_('behavior.modal', 'a.modal');
			acymailing_display('<a class="modal btn" rel="{handler: \'iframe\', size: {x: 600, y: 250}}" href="'.JURI::base().'index.php?option=com_acymailing&ctrl=file&task=installLanguages&tmpl=component&languages='.implode(',', $installedLanguages).'">'.$langText.'</a>', 'info');
		}

		$updateHelper->initList();
		$updateHelper->installTemplates();
		$updateHelper->installNotifications();
		$updateHelper->installMenu();
		$updateHelper->installExtensions();
		$updateHelper->installBounceRules();
		$updateHelper->fixDoubleExtension();
		$updateHelper->addUpdateSite();
		$updateHelper->fixMenu();

		if(ACYMAILING_J30) JFile::move(ACYMAILING_BACK.'acymailing_j3.xml', ACYMAILING_BACK.'acymailing.xml');

		acymailing_setTitle('AcyMailing','acymailing','dashboard');

		$this->_iframe(ACYMAILING_UPDATEURL.'install&fromversion='.JRequest::getCmd('fromversion'));
	}

	function update(){

		$config = acymailing_config();
		if(!acymailing_isAllowed($config->get('acl_config_manage','all'))){
			acymailing_display(JText::_('ACY_NOTALLOWED'),'error');
			return false;
		}

		acymailing_setTitle(JText::_('UPDATE_ABOUT'),'acyupdate','update');

		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', 'cancel', JText::_('ACY_CLOSE'), acymailing_completeLink('dashboard') );

		return $this->_iframe(ACYMAILING_UPDATEURL.'update');
	}

	function _iframe($url){

		$config = acymailing_config();
		$url .= '&version='.$config->get('version').'&level='.$config->get('level').'&component=acymailing';
?>
				<div id="acymailing_div">
					<iframe allowtransparency="true" scrolling="auto" height="650px" frameborder="0" width="100%" name="acymailing_frame" id="acymailing_frame" src="<?php echo $url; ?>">
					</iframe>
				</div>
<?php
	}
}
