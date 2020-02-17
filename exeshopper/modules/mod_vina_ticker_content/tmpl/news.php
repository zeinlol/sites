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

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_ticker_content/assets/js/jquery.easing.min.js', 'text/javascript');
$doc->addScript('modules/mod_vina_ticker_content/assets/js/jquery.easy-ticker.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_ticker_content/assets/css/style.css');
?>
<style type="text/css">
#vina-ticker-content<?php echo $module->id; ?> {
    width: <?php echo $moduleWidth; ?>;
	border: 1px solid <?php echo $bgColor; ?>;
    border-radius: 3px;
    font-family: Arial,sans-serif;
    font-style: italic;
    padding: <?php echo $modulePadding; ?>;
    position: relative;
	<?php echo ($isItemBgColor) ? 'background-color: ' . $itemBgColor : ''; ?>
}
#vina-ticker-content<?php echo $module->id; ?> a {
	color: <?php echo $itemLinkColor; ?>;
}
#vina-ticker-content<?php echo $module->id; ?>:before {
	background: none repeat scroll 0 0 <?php echo $bgColor; ?>;
    color: <?php echo $headerColor; ?>;
    content: "<?php echo $headerText; ?>";
    display: inline-block;
    font-style: normal;
    font-weight: bold;
    left: 0;
	top: 0;
    padding: <?php echo $itemPadding; ?>;
    position: absolute;
}
#vina-ticker-content<?php echo $module->id; ?> ul li {
    list-style: none outside none;
    padding: <?php echo $itemPadding; ?>;
}
</style>
<div id="vina-ticker-content<?php echo $module->id; ?>" class="vina-ticker-content breaking-news">
	<ul>
		<?php 
			foreach ($list as $key => $item) :
				$title 	= $item->title;
				$link   = $item->link;
		?>
		<li><a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>		
		<?php endforeach; ?>
	</ul>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#vina-ticker-content<?php echo $module->id; ?>').easyTicker({
		direction: 		'<?php echo $direction?>',
		easing: 		'<?php echo $easing?>',
		speed: 			'<?php echo $speed?>',
		interval: 		<?php echo $interval?>,
		height: 		'<?php echo $moduleHeight; ?>',
		visible: 		1,
		mousePause: 	<?php echo $mousePause?>,
	});
});
</script>