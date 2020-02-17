<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2016 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 3.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AkeebaToolbar extends F0FToolbar
{
	/**
	 * Disable rendering a toolbar.
	 *
	 * @return array
	 */
	protected function getMyViews()
	{
		return array();
	}

	public function onAlices()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA_TITLE_ALICES'),'akeeba');
		JToolbarHelper::back('JTOOLBAR_BACK', 'index.php?option=com_akeeba&view=cpanel');
	}

	public function onCpanelsAdd()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').' :: <small>'.JText::_('COM_AKEEBA_CONTROLPANEL').'</small>','akeeba');

		// $this->_renderDefaultSubmenus('cpanel');
	}

	public function onBackups()
	{
		// Add some buttons
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::spacer();

		// $this->_renderDefaultSubmenus('backup');
	}

	public function onConfwizsAdd()
	{
		// Set the toolbar title
		JToolbarHelper::title(JText::_('COM_AKEEBA').':: <small>'.JText::_('COM_AKEEBA_CONFWIZ').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onProfilesBrowse()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_PROFILES').'</small>','akeeba');

		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::spacer();
		JToolbarHelper::addNew();
		JToolbarHelper::custom('copy', 'copy.png', 'copy_f2.png', 'COM_AKEEBA_LBL_BATCH_COPY', false);
		JToolbarHelper::spacer();
		JToolbarHelper::deleteList();
		JToolbarHelper::spacer();
	}

	public function onProfilesEdit()
	{
		parent::onEdit();
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_PROFILES_PAGETITLE_EDIT').'</small>','akeeba');
	}

	public function onProfilesAdd()
	{
		parent::onAdd();
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_PROFILES_PAGETITLE_NEW').'</small>','akeeba');
	}

	public function onConfigsAdd()
	{
		// Toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').':: <small>'.JText::_('COM_AKEEBA_CONFIG').'</small>','akeeba');
		JToolbarHelper::preferences('com_akeeba', '500', '660');
		JToolbarHelper::spacer();
		JToolbarHelper::apply();
		JToolbarHelper::save();
		JToolbarHelper::spacer();
		JToolbarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		JToolbarHelper::cancel();
		JToolbarHelper::spacer();

		// Configuration wizard button. We apply styling to it.
		$icon = version_compare(JVERSION, '3.0.0', 'ge') ? 'lightning' : 'default';

		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Link', $icon, '<strong>' . JText::_('COM_AKEEBA_CONFWIZ') . '</strong>', 'index.php?option=com_akeeba&view=confwiz');

		$js = <<< JS
;;

jQuery(document).ready(function(){
	jQuery('#toolbar-lightning>button').addClass('btn-primary');
});

JS;
		JFactory::getDocument()->addScriptDeclaration($js);


		// $this->_renderDefaultSubmenus('config');
	}

	public function onStatisticsBrowse()
	{
		$this->onBuadminsBrowse();
	}

	public function onBuadminsBrowse()
	{
		$session = JFactory::getSession();
		$task = $session->get('buadmin.task', 'default', 'akeeba');

		switch($task)
		{
			case 'default':
			default:
				JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_BUADMIN').'</small>','akeeba');
				break;
		}

		JToolbarHelper::spacer();
		JToolbarHelper::deleteList();
		JToolbarHelper::custom( 'deletefiles', 'delete.png', 'delete_f2.png', JText::_('COM_AKEEBA_BUADMIN_LABEL_DELETEFILES'), true );
		JToolbarHelper::spacer();
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');

		//$this->_renderDefaultSubmenus('buadmin');
	}

	public function onBuadminsEdit()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_BUADMIN').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::save();
		JToolbarHelper::cancel();

		//$this->_renderDefaultSubmenus('buadmin');
	}

	public function onDiscoversBrowse()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_DISCOVER').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onDiscoversDiscover()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_DISCOVER').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onS3importsBrowse()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_S3IMPORT').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onS3importsDltoserver()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_S3IMPORT').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onRemotefilesListactions()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA_REMOTEFILES'),'akeeba');
	}

	public function onRemotefilesDltoserver()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA_REMOTEFILES'),'akeeba');
	}

	public function onLogsBrowse()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_LOG').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::spacer();

		// $this->_renderDefaultSubmenus('log');
	}

	public function onFsfiltersBrowse()
	{
		// Add toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_FILEFILTERS').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onDbefsBrowse()
	{
		// Add toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_DBFILTER').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onMultidbsBrowse()
	{
		// Add toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_MULTIDB').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onRegexfsfiltersBrowse()
	{
		// Add toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_REGEXFSFILTERS').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onRegexdbfiltersBrowse()
	{
		// Add toolbar buttons
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_REGEXDBFILTERS').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onEffsBrowse()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_INCLUDEFOLDER').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::spacer();
	}

	public function onRestores()
	{
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_RESTORE').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
		JToolbarHelper::spacer();
	}

	public function onSchedules()
	{
		// Set the toolbar title
		JToolbarHelper::title(JText::_('COM_AKEEBA').':: <small>'.JText::_('COM_AKEEBA_SCHEDULE').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	public function onTransfers()
	{
		// Set the toolbar title
		JToolbarHelper::title(JText::_('COM_AKEEBA').': <small>'.JText::_('COM_AKEEBA_TRANSFER').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');

		$icon = version_compare(JVERSION, '3.0.0', 'ge') ? 'loop' : 'restore';

		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Link', $icon, 'COM_AKEEBA_TRANSFER_BTN_RESET', 'index.php?option=com_akeeba&view=transfer&task=reset');
	}

	public function onUpdates()
	{
		// Set the toolbar title
		JToolbarHelper::title(JText::_('COM_AKEEBA').':: <small>'.JText::_('LIVEUPDATE').'</small>','akeeba');
		JToolbarHelper::back('COM_AKEEBA_CONTROLPANEL', 'index.php?option=com_akeeba');
	}

	private function _renderDefaultSubmenus($active = '')
	{
		$submenus = array(
			'cpanel'		=>	'COM_AKEEBA_CONTROLPANEL',
			'config'		=>	'COM_AKEEBA_CONFIG',
			'backup'		=>	'COM_AKEEBA_BACKUP',
			'buadmin'		=>	'COM_AKEEBA_BUADMIN',
			'log'			=>	'COM_AKEEBA_LOG',
		);

		foreach($submenus as $view => $key) {
			$link = JUri::base().'index.php?option='.$this->component.'&view='.$view;
			$this->appendLink(JText::_($key), $link, $view == $active);
		}
	}
}