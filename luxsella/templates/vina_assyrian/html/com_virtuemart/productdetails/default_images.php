<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 8508 2014-10-22 18:57:14Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if(VmConfig::get('usefancy',1)){
	vmJsApi::addJScript( 'fancybox/jquery.fancybox-1.3.4.pack', false);
	vmJsApi::css('jquery.fancybox-1.3.4');
	$document = JFactory::getDocument ();
	$imageJS = '
	if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
		jQuery(document).ready(function() {
			Virtuemart.updateImageEventListeners()
		});
		Virtuemart.updateImageEventListeners = function() {
			jQuery("a[class=vm-additional-images]").fancybox({
				"titlePosition" 	: "inside",
				"transitionIn"	:	"fade",
				"transitionOut"	:	"fade"
			});
			jQuery(".additional-images a.product-image.image-0").removeAttr("rel");
			jQuery(".additional-images img.product-image").click(function() {
				jQuery(".additional-images a.product-image").attr("rel","vm-additional-images" );
				jQuery(this).parent().children("a.product-image").removeAttr("rel");
				var src = jQuery(this).parent().children("a.product-image").attr("href");
				jQuery(".main-image img").attr("src",src);
				
				jQuery(".main-image img").attr("alt",this.alt);
				jQuery(".main-image a").attr("href",src);
				jQuery(".main-image a").attr("title",this.alt);
				jQuery(".main-image .vm-img-desc").html(this.alt);
				
				/* HieuJa add code */
				jQuery(".zoomContainer").remove();
				jQuery("#medium-image").elevateZoom();
				/* HieuJa end */
			});
		}
	}
	';
} else {
	vmJsApi::addJScript( 'facebox',false );
	vmJsApi::css( 'facebox' );
	$document = JFactory::getDocument ();
	$imageJS = '
	jQuery(document).ready(function() {
		Virtuemart.updateImageEventListeners()
	});
	Virtuemart.updateImageEventListeners = function() {
		jQuery("a[rel=vm-additional-images]").facebox();
		var imgtitle = jQuery("span.vm-img-desc").text();
		jQuery("#facebox span").html(imgtitle);
	}
	';
}
vmJsApi::addJScript('imagepopup',$imageJS);

// HieuJa add code --------------------------------------------------------------------------
$document = JFactory::getDocument();
$app 	  = JFactory::getApplication();
$template = $app->getTemplate();
$document->addScript(JURI::base() . 'templates/' . $template . '/js/jquery.elevatezoom.js');

$zoomJs = '
	if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
	jQuery(document).ready(function() {
		jQuery(".medium-image").elevateZoom({
			cursor: "pointer" , 
			zoomWindowPosition: 1, 
			zoomWindowOffetx: 2,
			 zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 500,
			lensFadeIn: 500,
			lensFadeOut: 500,
			showLens:true,
			zoomType: "window",
			containLensZoom :false,
			 easing : true, 
			 galleryActiveClass: "zoomThumbActive active", 
		});
	});
	}';

$document->addScriptDeclaration($zoomJs);
// HieuJa end ---------------------------------------------------------------------------------


if (!empty($this->product->images)) {
	$image = $this->product->images[0];
	$zoom  = JURI::base() . $image->file_url;
	?>

			<?php echo $this->product->images[0]->displayMediaFull('class="medium-image" id="medium-image"', true, "class='vm-additional-images'"); ?>
	<?php
}
?>
