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

$doc = JFactory::getDocument();
$doc->addScript('modules/'.$module->module.'/assets/js/jquery.pogo-slider.js', 'text/javascript');
$doc->addStyleSheet('modules/'.$module->module.'/assets/css/pogo-slider.css');
$timthumb = JURI::base() . 'modules/'.$module->module.'/libs/timthumb.php?a=c&q=99&z=0&w='.$imageWidth.'&h='.$imageHeight;
?>
<!-- style block -->
<style type="text/css">
#vina-pogo-slider<?php echo $module->id; ?> {
	<?php echo (!empty($moduleWidth)) ? "max-width: {$moduleWidth};" :""; ?>
	<?php echo (!empty($moduleHeight)) ? "max-height: {$moduleHeight};" :""; ?>
}
#vina-pogo-slider<?php echo $module->id; ?> .caption-block {
	<?php echo (!empty($captionStyle)) ? $captionStyle : ""; ?>
}
</style>

<!-- slideshow block -->
<div id="vina-pogo-slider<?php echo $module->id; ?>" class="vina-pogo-slider pogoSlider">
	<?php foreach($slides as $slide) : ?>
	<?php
		$image 	= $slide->img;
		
		if(!empty($image)) {
			$image = (strpos($image, 'http://') === false) ? JURI::base() . $image : $image;
			$image = ($resizeImage) ? $timthumb . "&src=" . $image : $image;
		}
		else {
			$image = "";
		}
		
		if($slider->src == "dir") {
			$name = $slide->img;
			$text = "";
		}
		else {
			$name = $slide->name;
			$text = $slide->text;
		}
	?>
	<div class="pogoSlider-slide">
		<!-- Image Block -->
		<?php if(!empty($image)): ?>
		<img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
		<?php endif; ?>
		
		<!-- Caption Block -->
		<?php if(!empty($text) && $captionBlock): ?>
			<?php echo $text; ?>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>

<!-- Copyright text. You can't remove it!-->
<div class="copyright-text">
© Free <a href="http://vinagecko.com/joomla-modules" title="Free Joomla! 3 Modules">Joomla! 3 Modules</a>- by <a href="http://vinagecko.com/" title="Beautiful Joomla! 3 Templates and Powerful Joomla! 3 Modules, Plugins.">VinaGecko.com</a>
</div>

<!-- javascript block -->
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$('#vina-pogo-slider<?php echo $module->id; ?>').pogoSlider({
		autoplay:					<?php echo $autoplay ? "true" : "false"; ?>,
		autoplayTimeout:			<?php echo $autoplayTimeout; ?>,
		displayProgess:				<?php echo $displayProgess ? "true" : "false"; ?>,
		slideTransition:			'<?php echo $slideTransition; ?>',
		slideTransitionDuration:	<?php echo $slideTransitionDuration; ?>,
		elementTransitionIn:		'<?php echo $elementTransitionIn; ?>',
		elementTransitionOut:		'<?php echo $elementTransitionOut; ?>',
		elementTransitionStart:		<?php echo $elementTransitionStart; ?>,
		elementTransitionDuration:	<?php echo $elementTransitionDuration; ?>,
		generateButtons:			<?php echo $generateButtons ? "true" : "false"; ?>,
		buttonPosition:				'<?php echo $buttonPosition; ?>',
		generateNav:				<?php echo $generateNav ? "true" : "false"; ?>,
		navPosition:				'<?php echo $navPosition; ?>',
		pauseOnHover:				<?php echo $pauseOnHover ? "true" : "false"; ?>,
		targetWidth:				<?php echo (!empty($moduleWidth)) ? intval($moduleWidth) : 940; ?>,
		targetHeight:				<?php echo (!empty($moduleHeight)) ? intval($moduleHeight) : 420; ?>,
		responsive: 				true,
	});
});
</script>