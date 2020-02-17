<?php
/*
# ------------------------------------------------------------------------
# Vina Pogo Image Slider for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2015 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once dirname(__FILE__) . '/helper.php';

// load json code
$slider = json_decode($params->get('slides', ''));

// check if don't have any slide
if(!$slider) {
	echo "You don't have any slide!";
	return;
}

// load data
$slides = modVinaPogoImageSliderHelper::getSildes($slider);

// get params
$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));
$moduleWidth		= $params->get('moduleWidth', '');
$moduleHeight		= $params->get('moduleHeight', '');
$resizeImage		= $params->get('resizeImage', 0);
$imageWidth			= $params->get('imageWidth', 1000);
$imageHeight		= $params->get('imageHeight', 500);
$captionBlock		= $params->get('captionBlock', 1);
$captionStyle		= $params->get('captionStyle', '');

$autoplay					= $params->get('autoplay', 1);
$autoplayTimeout			= $params->get('autoplayTimeout', 4000);
$displayProgess				= $params->get('displayProgess', 1);
$slideTransition			= $params->get('slideTransition', 'fade');
$slideTransitionDuration	= $params->get('slideTransitionDuration', 1000);
$elementTransitionIn		= $params->get('elementTransitionIn', 'slideUp');
$elementTransitionOut		= $params->get('elementTransitionOut', 'slideDown');
$elementTransitionStart		= $params->get('elementTransitionStart', 500);
$elementTransitionDuration	= $params->get('elementTransitionDuration', 1000);
$generateButtons			= $params->get('generateButtons', 1);
$buttonPosition				= $params->get('buttonPosition', 'CenterHorizontal');
$generateNav				= $params->get('generateNav', 0);
$navPosition				= $params->get('navPosition', 'Bottom');
$pauseOnHover				= $params->get('pauseOnHover', 1);

// display layout
require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));