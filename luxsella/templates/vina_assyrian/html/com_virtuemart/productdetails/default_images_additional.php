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
 * @version $Id: default_images.php 7784 2014-03-25 00:18:44Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<div class="additional-images">
	
	<!--<div class="additional-images-inner">-->
		<ul id="additional_images_gallery">
		<?php
			$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
			for ($i = $start_image; $i < count($this->product->images); $i++) {
				$image = $this->product->images[$i];
				?>
				<li>
					<div class="item-inner">
						<?php
						if(VmConfig::get('add_img_main', 1)) {
							echo $image->displayMediaThumb('class="product-image" style="cursor: pointer"',false,$image->file_description);
							echo '<a href="'. $image->file_url .'"  class="product-image image-'. $i .'" style="display:none;" title="'. $image->file_meta .'" data-rel="vm-additional-images"></a>';
						} else {
							echo $image->displayMediaThumb("",true,"data-rel='vm-additional-images'",true,$image->file_description);
						}
						?>						
					</div>
				</li>
			<?php } ?>
		</ul>
		<?php  if(count($this->product->images) > 4) :?>
		<script>
		
		</script>
	<?php endif; ?>

</div>

<?php
	// swallow add Js carouFredSel --------------------------------------------------------------------------
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
		jQuery(function($) {
			$(document).ready(function($){	
				$(window).on('load', function() {
					var medium_image = $('.productdetails-view #medium-image').height() + 11;
					$('#additional_images_gallery').lightSlider({
						item: 4,				
						//speed: 200, //ms'
						slideMargin: 54,
						vertical:true,
						verticalHeight: medium_image,
						adaptiveHeight: false,
						vThumbWidth:90,
						pager: false,
						easing: 'linear',
						loop: true,
						enableTouch:false,
				 
						responsive : [
							{
								breakpoint:1200,
								settings: {
									item:3,
									slideMove:1,
									thumbMargin: 60,
								}
							},
							{
								breakpoint:979,
								settings: {
									item:4,
									slideMove:1,
									thumbMargin: 75,
								}
							},		
							{
								breakpoint:766,
								settings: {
									item:4,
									slideMove:1,
									thumbMargin: 60,
								}
							},	
							{
								breakpoint:600,
								settings: {
									item:3,
									slideMove:1,
									thumbMargin: 30,
								}
							},	
							{
								breakpoint:480,
								settings: {
									item:3,
									slideMove:1,
									thumbMargin: 8,
								}
							},
							{
								breakpoint:320,
								settings: {
									item:2,
									slideMove:1,
									thumbMargin: 8,
								}
							}
						]
					});					
				});
			});	
		});
	");
 ?>

