<?php
/**
* @package VinaGecko Template
* @author VinaGecko http://www.vinagecko.com
* @copyright Copyright (c) 2010 - 2015 VinaGecko
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/	

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');

class plgSystemVinaGecko extends JPlugin
{
	
    function onAfterRoute()
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
			return;
		}
		
		$preset = JRequest::getVar('preset');
		if(!is_null($preset)) {
			$template 	= JFactory::getApplication()->getTemplate();
			$name 		= $template . '_preset';
			setcookie($name, $preset);
			if($preset != $_COOKIE[$name]) {
				header("Refresh:0");
			}
		}
    }
	
	function onAfterRender()
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
			return;
		}
		$body = JResponse::getBody();
		$body = str_replace("&w=", "&amp;w=", $body);
		$body = str_replace("&h=", "&amp;h=", $body);
		$body = str_replace("&src=", "&amp;src=", $body);
		$body = str_replace("&q=", "&amp;q=", $body);
		$body = str_replace("&z=", "&amp;z=", $body);
		$body = str_replace("&libraries=", "&amp;libraries=", $body);
		
		JResponse::setBody($body);
		return true;
	}
	
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
			return;
		}
		
		$template 		= $this->params->get('cookieName', 'vina_template');
		$loadTemplateId = JRequest::getVar('templateid', '', 'get', 'int');
		
		if($loadTemplateId) {
			setcookie($template . '_id', $loadTemplateId);
			if($loadTemplateId != $_COOKIE[$template . '_id']) {
				header("Refresh:0");
			}
		}
		
		$template_style_id = JRequest::getVar($template . '_id', '', 'cookie', 'int');
				
		if($template_style_id < 1){
			return;
		}
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('template, params');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `id`= '. (int)$template_style_id);
		$query->order('`id` ASC');
		$db->setQuery( $query );
		$row = $db->loadObject();
		if(!$row){
			return;
		}

		if(empty($row->template)){
			return;
		}
		
		$current = plgSystemVinaGecko::getCurrentTemplate();
		
		if($current != $template_style_id && file_exists(JPATH_THEMES. '/'. $row->template)){
			$app->setTemplate($row->template, (new JRegistry($row->params)));
		}
	}
	
	public static function getCurrentTemplate()
	{
		$app 	= JFactory::getApplication();
		$menus 	= $app->getMenu('site');
		$menu 	= $menus->getActive();
		
		if($menu){
			$template_style_id = (int)$menu->params->get('template_style_id');
			if($template_style_id > 0){
				return $template_style_id;
			}
		}

		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);
		$query->select('id');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `home` = 1');
		$db->setQuery($query);
		
		return intval($db->loadResult());
	}
}