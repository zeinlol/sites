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
$products_per_row = $viewData['products_per_row'];
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator 	= " vertical-separator";
$clearrow			= " clearrow"; 

// Show Label Sale Or New
// Get New Products
$db     = JFactory::getDBO();
$query  = "SELECT virtuemart_product_id FROM #__virtuemart_products ORDER BY virtuemart_product_id DESC LIMIT 0, 10";
$db->setQuery($query);
$newIds = $db->loadColumn();

JHtml::_('behavior.modal');  

$products_per_row_1 = $products_per_row + 1;
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

$productModel = VmModel::getModel('product');

foreach ($viewData['products'] as $type => $products ) {
	$productModel->addImages($products,2);
	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);

	if(!empty($type) and count($products)>0){
		$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>
<div class="<?php echo $type ?>-view">
  <h4><?php echo $productTitle ?></h4>
		<?php // Start the Output
    }

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);
	
	$col = 1;
	$nb = 1;
	$row = 1;

	echo "<div class='row'>";
	foreach ( $products as $product ) {

		// Show the horizontal seperator
		if ($col == 1 && $nb > $products_per_row) { ?>
		<?php }

		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) { ?>

		<?php }

		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = $verticalseparator;
		} else {
			$show_vertical_separator = '';
		}		
		
		// Show Class Clearrow
		if (($nb % $products_per_row) == 1) {
			$show_clearrow 	 	= $clearrow;
		} else {
			$show_clearrow 		= '';
		}

		
		if($products_per_row < 6) {
			switch ($products_per_row) {
				case 1:
					$vina_products_per_row = 12;
					break;
				case 2:
					$vina_products_per_row = 6;
					break;
				case 3:
					$vina_products_per_row = 4;
					break;	
				case 4:
					$vina_products_per_row = 3;
					break;
				default:
					$vina_products_per_row = 4;
			}
		}
		else {
			$vina_products_per_row = 4;	
		}
		
		//Link product detail
		
		$pName  = $product->product_name;
		$pLink	=	$product->link;

		//Quick View Link
		$quickview = $pLink.'&amp;tmpl=component';
		
		$pPrice = shopFunctionsF::renderVmSubLayout('prices', array('product' => $product, 'currency' => $currency));
		$sPrice = $currency->createPriceDiv('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);

		// Show Label Sale Or New
		$isSaleLabel = (!empty($product->prices['discountAmount'])) ? 1 : 0;
		
		$pid = $product->virtuemart_product_id;
		$isNewLabel = in_array($pid, $newIds);
		?>
	<?php // Show Products ?>

	<div class="vina-vmproduct item vm-col<?php echo ' vm-col-' . $products_per_row . $show_vertical_separator. $show_clearrow ?> col-md-<?php echo $vina_products_per_row;?> col-xs-6">
		<div class="item-i round-corners">
			<div class="item-inner">
				<div class="list-col4">
					<!-- Check Product Label -->
					<?php if($isSaleLabel != 0) : ?>
						<div class="label-pro sale">
							<span class="label-bg"></span>
							<span class="label-text"><?php echo JTEXT::_('VM_LANG_SALE'); ?></span>
						</div>
					<?php endif; ?>
					<?php if($isNewLabel && $isSaleLabel != 0) : ?>
					<div class="label-pro sale-new">
						<span class="label-bg"></span>
						<span class="label-text"><?php echo JTEXT::_('VM_LANG_NEW'); ?></span>
					</div>
					<?php endif; ?>
					<?php if($isNewLabel && $isSaleLabel == 0) : ?>
					<div class="label-pro new">
						<span class="label-bg"></span>
						<span class="label-text"><?php echo JTEXT::_('VM_LANG_NEW'); ?></span>
					</div>
					<?php endif; ?>	
				
					<div class="product-image">
						<?php

							$image = $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
							if(!empty($product->images[1])){
								$image2 = $product->images[1]->displayMediaThumb('class="browseProductImage"', false);
								echo JHTML::_('link', $product->link.$ItemidStr,'<span class="pro-image first-image">'.$image.'</span><span class="pro-image second-image">'.$image2.'</span><span class="shadow"></span>','title="'.$product->product_name.'"');
							} else {
								echo JHTML::_('link', $product->link.$ItemidStr,'<span class="pro-image">'.$image.'</span><span class="shadow"></span>','title="'.$product->product_name.'"');
							}
							
						?>
					
						<div class="price-rate gridview">
						
							<div class="product-rating">
								<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product));
								if ( VmConfig::get ('display_stock', 1)) { ?>
									<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
								<?php }		
								?>
							</div>
							
							<!-- Product Price -->
							<div class="price-box">
								<?php if($isSaleLabel!= 0) : ?>
										<?php echo $pPrice; ?>
								<?php else : ?>
									<?php echo $sPrice; ?>
								<?php endif; ?>
							</div>
							
						</div>
						
						<div class="actions gridview">
							
							<div class="action-buttons">
								<div class="add-to-cart jutooltip" title="<?php echo JText::_( 'VM_LANG_ADDTOCART_BUTTON' ); ?>" >
									<?php echo shopFunctionsF::renderVmSubLayout('addtocart_nocustom',array('product'=>$product)); ?>
								</div>
							</div>
							
							<div class="add-to-links">
							
								<div class="quick-view">
									<a href="<?php echo $quickview; ?>" class="vina-quickview modal jutooltip" title="<?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?>">
										<i class="fa fa-search-plus"></i>
										<span><?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?></span>
									</a>
								</div>
							
								<!-- Add Wishlist Button -->
								<?php if(is_dir(JPATH_BASE . "/components/com_wishlist/")) :
									$app = JFactory::getApplication();
								?>
								<div class="link-wishlist second">
									<div class="btn-wishlist">
										<?php require(JPATH_BASE . "/templates/".$app->getTemplate()."/html/wishlist.php"); ?>
									</div>
								</div>
								<?php else: ?>		
								<div class="link-review addtocart-area second">
									<a href="<?php echo $pLink; ?>#vina-tab" title="<?php echo JTEXT::_('VM_LANG_REVIEWS'); ?>" class="product-review jutooltip"><i class="fa fa-star"></i><span><?php echo JText::_('VM_LANG_REVIEWS');?></span></a>
								</div>
								
								<?php endif; ?>
							
							</div>
							
						</div>
					
					</div>
				</div>
			
			
				<div class="des-container gridview">
					
					<h2 class="product-name"><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h2>
					
					<?php echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$product)); ?>

					
				</div>
			
				<div class="list-col8 listview">
			
					<div class="product-rating">
						<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product));
						if ( VmConfig::get ('display_stock', 1)) { ?>
							<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
						<?php }		
						?>
					</div>
				
					<!-- Product Price -->
					<div class="price-box">
						<?php if($isSaleLabel!= 0) : ?>
								<?php echo $pPrice; ?>
						<?php else : ?>
							<?php echo $sPrice; ?>
						<?php endif; ?>
					</div>
				
					<h2 class="product-name"><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h2>
				
					<?php if(!empty($rowsHeight[$row]['product_s_desc'])){
							?>
							<div class="product-description">
								<?php // Product Short Description
								if (!empty($product->product_s_desc)) {
									echo $product->product_s_desc; ?>
								<?php } ?>
							</div>
					<?php  } ?>
					
					<div class="actions">
						
						<div class="action-buttons">
							<div class="add-to-cart jutooltip" title="<?php echo JText::_( 'VM_LANG_ADDTOCART_BUTTON' ); ?>" >
								<?php echo shopFunctionsF::renderVmSubLayout('addtocart_nocustom',array('product'=>$product)); ?>
							</div>
						</div>
						
						<div class="add-to-links">
						
							<div class="quick-view">
								<a href="<?php echo $quickview; ?>" class="vina-quickview modal jutooltip" title="<?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?>">
									<i class="fa fa-search-plus"></i>
									<span><?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?></span>
								</a>
							</div>
						
							<!-- Add Wishlist Button -->
							<?php if(is_dir(JPATH_BASE . "/components/com_wishlist/")) :
								$app = JFactory::getApplication();
							?>
							<div class="link-wishlist second">
								<div class="btn-wishlist">
									<?php require(JPATH_BASE . "/templates/".$app->getTemplate()."/html/wishlist.php"); ?>
								</div>
							</div>
							<?php else: ?>		
							<div class="link-review addtocart-area second">
								<a href="<?php echo $pLink; ?>#vina-tab" title="<?php echo JTEXT::_('VM_LANG_REVIEWS'); ?>" class="product-review jutooltip"><i class="fa fa-star"></i><span><?php echo JText::_('VM_LANG_REVIEWS');?></span></a>
							</div>
							
							<?php endif; ?>
						
						</div>
						
					</div>
					
				</div>
				
			
			</div>	
		</div>
	</div>

	<?php
    $nb ++;

      // Do we need to close the current row now?
      if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>

      <?php
      	$col = 1;
		$row++;
    } else {
      $col ++;
    }
  }

      if(!empty($type)and count($products)>0){
        // Do we need a final closing row tag?
        //if ($col != 1) {
      ?>
    <div class="clear"></div>
  </div>
    <?php
    // }
    }
  }
