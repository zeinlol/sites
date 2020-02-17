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
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? 'background: url('.$bgImage.') top center no-repeat;' : ''; ?>
	<?php echo ($isBgColor) ? 'background-color: ' . $bgColor : ''; ?>
}
#vina-ticker-content<?php echo $module->id; ?> .vina-item {
	padding: <?php echo $itemPadding; ?>;
	color: <?php echo $itemTextColor; ?>;
	border-top: solid 1px <?php echo $bgColor; ?>;
	<?php echo ($isItemBgColor) ? 'background-color: ' . $itemBgColor : ''; ?>
}
#vina-ticker-content<?php echo $module->id; ?> .vina-item a {
	color: <?php echo $itemLinkColor; ?>;
}
#vina-ticker-content<?php echo $module->id; ?> .header-block {
	color: <?php echo $headerColor; ?>;
	margin-bottom: <?php echo $modulePadding; ?>;
}
</style>
<div id="vina-ticker-content<?php echo $module->id; ?>" class="vina-ticker-content">

<!-- Header Buttons Block -->
	<?php if($headerBlock) : ?>
	<div class="header-block">
		<div class="row-fluid">
			<?php if(!empty($headerText)) : ?>
			<div class="span<?php echo ($controlButtons) ? 7 : 12; ?>">
				<h3><?php echo $headerText; ?></h3>
			</div>
			<?php endif; ?>
			
			<?php if($controlButtons) : ?>
			<div class="span<?php echo empty($headerText) ? 12 : 5; ?>">
				<div class="control-block pull-right">
					<span class="up">UP</span>
					<span class="toggle">TOGGLE</span>
					<span class="down">DOWN</span>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

<!-- Items Block -->	
	<div class="vina-items-wrapper">
		<div class="vina-items">
			<?php 
				foreach ($list as $key => $item) :
					$title 	= $item->title;
					$link   = $item->link;
					$images = json_decode($item->images);
					$category 	 = $item->displayCategoryTitle;
					$hits  		 = $item->displayHits;
					$description = $item->displayIntrotext;
					$created   	 = $item->displayDate;
					$image = $images->image_fulltext;
					$image = (empty($image)) ? $images->image_intro : $image;
					if(!empty($image)) {
						$image = (strpos($image, 'http://') === FALSE) ? JURI::base() . $image : $image;
						$image = ($resizeImage) ? $thumb . '&src=' . $image : $image;
					}
			?>
			<div class="vina-item">
				<div class="row-fluid">
					<!-- Image Block -->
					<?php if(!empty($image) && $showImage) : ?>
					<div class="span<?php echo ($showTitle || $showCategory || $showCreatedDate || $showHits || $introText || $readmore) ? 4 : 12; ?>">
						<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
							<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" />
						</a>
					</div>
					<?php endif; ?>
					
					<?php if($showTitle || $showCategory || $showCreatedDate || $showHits || $introText || $readmore) : ?>
					<div class="span<?php echo (!empty($image) && $showImage) ? 8 : 12; ?>">
						<div class="text-block">
							<!-- Title Block -->
							<?php if($showTitle) :?>
							<h4 class="title">
								<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
							</h4>
							<?php endif; ?>
							
							<!-- Info Block -->
							<?php if($showCategory || $showCreatedDate || $showHits) : ?>
							<div class="info">
								<?php if($showCreatedDate) : ?>
								<span><?php echo JTEXT::_('VINA_PUBLISHED'); ?>: <?php echo JHTML::_('date', $created, 'F d, Y');?></span>
								<?php endif; ?>
								
								<?php if($showCategory) : ?>
								<span><?php echo JTEXT::_('VINA_CATEGORY'); ?>: <?php echo $category; ?></span>
								<?php endif; ?>
								
								<?php if($showHits) : ?>
								<span><?php echo JTEXT::_('VINA_HITS'); ?>: <?php echo $hits; ?></span>
								<?php endif; ?>
							</div>
							<?php endif; ?>
							
							<!-- Intro text Block -->
							<?php if($introText) : ?>
							<div class="introtext"><?php echo $description; ?></div>
							<?php endif; ?>
							
							<!-- Readmore Block -->
							<?php if($readmore) : ?>
							<div class="readmore">
								<a class="buttonlight morebutton" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
									<?php echo JText::_('VINA_READ_MORE'); ?>
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#vina-ticker-content<?php echo $module->id; ?> .vina-items-wrapper').easyTicker({
		direction: 		'<?php echo $direction?>',
		easing: 		'<?php echo $easing?>',
		speed: 			'<?php echo $speed?>',
		interval: 		<?php echo $interval?>,
		height: 		'<?php echo $moduleHeight; ?>',
		visible: 		<?php echo $visible?>,
		mousePause: 	<?php echo $mousePause?>,
		
		<?php if($controlButtons) : ?>
		controls: {
			up: '#vina-ticker-content<?php echo $module->id; ?> .up',
			down: '#vina-ticker-content<?php echo $module->id; ?> .down',
			toggle: '#vina-ticker-content<?php echo $module->id; ?> .toggle',
			playText: 'Play',
			stopText: 'Stop'
		},
		<?php endif; ?>
	});
});
</script>