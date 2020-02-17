<?php
/*
# ------------------------------------------------------------------------
# Vina Vertical News Ticker for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum: http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once dirname(__FILE__) . '/helper.php';

$input 		= JFactory::getApplication()->input;
$idbase 	= $params->get('catid');
$cacheid 	= md5(serialize(array ($idbase, $module->module)));

$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class 	= 'ModVinaTickerContentHelper';
$cacheparams->method 	= 'getList';
$cacheparams->methodparams 	= $params;
$cacheparams->modeparams 	= $cacheid;

$list = JModuleHelper::moduleCache($module, $params, $cacheparams);

if(empty($list))
{
	echo 'No item found! Please check your config!';
	return;
}

// get params
$moduleclass_sfx 	= $params->get('moduleclass_sfx', '');
$showImage			= $params->get('showImage', 1);
$resizeImage		= $params->get('resizeImage', 1);
$imagegWidth		= $params->get('imagegWidth', 100);
$imagegHeight		= $params->get('imagegHeight', 100);
$showTitle			= $params->get('showTitle', 1);
$showCreatedDate	= $params->get('show_date', 0);
$showCategory		= $params->get('show_category', 0);
$showHits			= $params->get('show_hits', 0);
$introText			= $params->get('show_introtext', 1);
$readmore			= $params->get('show_readmore', 1);

$moduleWidth	= $params->get('moduleWidth', '300px');
$moduleHeight	= $params->get('moduleHeight', 'auto');
$bgImage		 = $params->get('bgImage', NULL);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor		= $params->get('isBgColor', 1);
$bgColor		= $params->get('bgColor', '#43609C');
$modulePadding	= $params->get('modulePadding', '10px');

$headerBlock	= $params->get('headerBlock', 1);
$headerText		= $params->get('headerText', '');
$headerColor	= $params->get('headerTextColor', '#FFFFFF');
$controlButtons	= $params->get('controlButtons', 1);

$isItemBgColor	= $params->get('isItemBgColor', 1);
$itemBgColor	= $params->get('itemBgColor', '#FFFFFF');
$itemPadding	= $params->get('itemPadding', '10px');
$itemTextColor	= $params->get('itemTextColor', '#141823');
$itemLinkColor	= $params->get('itemLinkColor', '#3B5998');

$direction		= $params->get('direction', 'up');
$easing			= $params->get('easing', 'jswing');
$speed			= $params->get('speed', 'slow');
$interval		= $params->get('interval', 5000);
$visible		= $params->get('visible', 2);
$mousePause		= $params->get('mousePause', 1);

$thumb = JURI::base() . 'modules/mod_vina_ticker_content/libs/timthumb.php?a=c&q=99&z=0&w='.$imagegWidth.'&h='.$imagegHeight;

// include layout
require JModuleHelper::getLayoutPath('mod_vina_ticker_content', $params->get('layout', 'default'));