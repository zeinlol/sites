<?php
/*
# ------------------------------------------------------------------------
# Module: Vina Treeview for Menus
# ------------------------------------------------------------------------
# Copyright (C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://VinaGecko.com
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="'.$item->anchor_title.'" ' : '';
if($item->menu_image) {
	$item->params->get('menu_text', 1) ?
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else {
	$linktype = $item->title;
}
?>
<span class="separator<?php echo $folder; ?>"<?php echo $title; ?>><?php echo $linktype; ?></span>
