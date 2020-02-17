<?php
/**
* sublayout products
*
* @package	VirtueMart
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
* @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
*/

defined('_JEXEC') or die('Restricted access');

$product = $viewData['product'];
$position = $viewData['position'];
$customTitle = isset($viewData['customTitle'])? $viewData['customTitle']: false;;
if(isset($viewData['class'])){
	$class = $viewData['class'];
} else {
	$class = 'product-fields';
}

if (!empty($product->customfieldsSorted[$position])) {
	?>
	<div class="related_prd <?php echo $class?>">
	
		<?php
		if($customTitle and isset($product->customfieldsSorted[$position][0])){
			$field = $product->customfieldsSorted[$position][0]; ?>
			<div class="product-fields-title-wrapper">
				<h2><?php echo vmText::_ ($field->custom_title) ?></h2>
			</div>
		<?php } ?>		
		

		<div class="related_slider">
			<div id="related_caroufredsel" class="vmproduct">			
				<?php					
				$custom_title = null;
				foreach ($product->customfieldsSorted[$position] as $field) {
					if ( $field->is_hidden ) //OSP http://forum.virtuemart.net/index.php?topic=99320.0
					continue;
					?>																		
					<?php if (!$customTitle and $field->custom_title != $custom_title and $field->show_title) { ?>
						<?php echo vmText::_ ($field->custom_title) ?>
					<?php }
					if (!empty($field->display)){
						?>
						<div class="item vina-vmproduct">
							<div class="item-inner">							
									<?php echo $field->display ?>								
							</div>
						</div>
					<?php
					}
					if (!empty($field->custom_desc)){ ?>
						<!-- <div class="product-field-desc"><?php echo vmText::_($field->custom_desc) ?></div> -->
					<?php } ?>							
				
					<?php $custom_title = $field->custom_title;					
				} ?>
			</div>
		</div>
	</div>	
<?php } ?>
<?php 
// swallow add Js carouFredSel --------------------------------------------------------------------------
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
		jQuery(document).ready(function($){			
			$('#related_caroufredsel').lightSlider({
				item: 4,
				slideMargin: 30,
				//rtl: true,
				loop: true,
				pager: false,
				enableTouch:false,
		 
				responsive : [
					{
						breakpoint:1200,
						settings: {
							item:4,
							slideMove:1,
							slideMargin:6,
						}
					},
					{
						breakpoint:800,
						settings: {
							item:3,
							slideMove:1
						}
					},
					{
						breakpoint:480,
						settings: {
							item:2,
							slideMove:1
						}
					},
					{
						breakpoint:320,
						settings: {
							item:1,
							slideMove:1
						}
					},
				]
			});
		});	
	");
?>