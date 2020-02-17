<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();


$col = 1;
$pwidth = ' width' . floor (100 / $products_per_row);
if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}

$productModel 	= VmModel::getModel('Product');
$ratingModel = VmModel::getModel('ratings');
$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

// Get New Products
$db     = JFactory::getDBO();
$query  = "SELECT virtuemart_product_id FROM #__virtuemart_products ORDER BY virtuemart_product_id DESC LIMIT 0, 10";
$db->setQuery($query);
$newIds = $db->loadColumn();
?>
<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?>">

	<?php if ($headerText) { ?>
		<div class="vmheader"><?php echo $headerText ?></div>
	<?php } ?>
	
	<?php if ($display_style == "div") { ?>		
		<div class="vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php foreach ($products as $product) {
				$stock  = $productModel->getStockIndicator($product);
				$sLevel = $stock->stock_level;
				$sTip   = $stock->stock_tip;
				$handle = shopFunctionsF::renderVmSubLayout('stockhandle', array('product' => $product));
				
				// Price
				$basePrice = shopFunctionsF::renderVmSubLayout('prices', array('product' => $product, 'currency' => $currency));				
				$dPrice = $currency->createPriceDiv('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
				$salesPrice = $currency->createPriceDiv('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
				$basePriceWithTax = $currency->createPriceDiv('basePriceWithTax', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
				
				// Show Label Sale Or New				
				$isSaleLabel = (!empty($product->prices['discountAmount'])) ? 1 : 0;
				
				$pid = $product->virtuemart_product_id;
				$isNewLabel = in_array($pid, $newIds);
			?>
			<div class="<?php echo $pwidth ?> <?php echo $float ?>">
				<div class="spacer">
					<?php
					if (!empty($product->images[0])) {
						$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
					} else {
						$image = '';
					}
					echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
					echo '<div class="clear"></div>';
					$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
						$product->virtuemart_category_id); ?>
					<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a><?php echo '<div class="clear"></div>';

					if ($show_price) {
						// 		echo $currency->priceDisplay($product->prices['salesPrice']);
						if (!empty($product->prices['salesPrice'])) {
							echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						}
						// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
						if (!empty($product->prices['salesPriceWithDiscount'])) {
							echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
						}
					}
					if ($show_addtocart) {
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
					}
					?>
				</div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $col < $totalProd) {
				echo "	</div><div style='clear:both;'>";
				$col = 1;
			} else {
				$col++;
			}
		} ?>
		</div>
		<br style='clear:both;'/>

		<?php
	} else {
		$last = count ($products) - 1;
		?>

		<ul class="mage-products row vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php foreach ($products as $product) :
				$stock  = $productModel->getStockIndicator($product);
				$sLevel = $stock->stock_level;
				$sTip   = $stock->stock_tip;
				$handle = shopFunctionsF::renderVmSubLayout('stockhandle', array('product' => $product));
				
				// Price
				$basePrice = shopFunctionsF::renderVmSubLayout('prices', array('product' => $product, 'currency' => $currency));				
				$dPrice = $currency->createPriceDiv('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
				$salesPrice = $currency->createPriceDiv('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
				$basePriceWithTax = $currency->createPriceDiv('basePriceWithTax', '', $product->prices, FALSE, FALSE, 1.0, TRUE);				
				
				// Show Label Sale Or New				
				$isSaleLabel = (!empty($product->prices['discountAmount'])) ? 1 : 0;
				
				$pid = $product->virtuemart_product_id;
				$isNewLabel = in_array($pid, $newIds);
			?>
			<li class="product <?php echo $pwidth ?> <?php echo $float ?>">
				<div class="product-inner">
					<div class="product-box">
						<?php
						if (!empty($product->images[0])) {
							$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
						} else {
							$image = '';
						}
						?>
						<div class="pull-left">
							<div class="vm-product-media-container">
								<?php echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));?>
							</div>
						</div>
						
						<div class="media-body text-block">						
							<!-- Product Rating -->
							<?php if ($ratingModel) { ?>
								<div class="vm-product-rating-container">
									<?php
									$maxrating = VmConfig::get('vm_maximum_rating_scale',5);
									$rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
									$reviews = $ratingModel->getReviewsByProduct($product->virtuemart_product_id);
									if(empty($rating->rating)) { ?>						
										<div class="ratingbox dummy" title="<?php echo vmText::_('COM_VIRTUEMART_UNRATED'); ?>" >
										</div>
									<?php } else {						
										$ratingwidth = $rating->rating * 14; ?>
										<div title=" <?php echo (vmText::_("COM_VIRTUEMART_RATING_TITLE") . round($rating->rating) . '/' . $maxrating) ?>" class="ratingbox" >
										  <div class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>"></div>
										</div>
									<?php } ?> 
									<?php if(!empty($reviews)) {					
										$count_review = 0;
										foreach($reviews as $k=>$review) {
											$count_review ++;
										}										
									?>
										<span class="amount">
											<a href="<?php echo $url; ?>" target="_blank" ><?php echo $count_review.' '.JText::_('VM_LANG_REVIEWS');?></a>
										</span>
									<?php } ?>								
								</div>
							<?php } ?>
							
							<!-- Product Title -->
							<?php
								$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
								$product->virtuemart_category_id);
							?>
							<h3 class="product-title"><a href="<?php echo $url ?>"><?php echo $product->product_name ?></a></h3>
					
							<!-- Product Price -->
							<?php if ($show_price) : ?>							
								<div class="product-price">
									<?php if($isSaleLabel!= 0) : ?>
											<?php echo $basePrice; ?>
									<?php else : ?>
										<?php echo $salesPrice; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							
							<?php
							if ($show_addtocart) {
								echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
							}
							?>
						</div>
					</div>
				</div>
			</li>
			<?php
			if ($col == $products_per_row && $products_per_row && $last) {
				echo '
		</ul>
		<div class="clear"></div>
		<ul class="mage-products row vmproduct' . $params->get ('moduleclass_sfx') . ' productdetails">';
				$col = 1;
			} else {
				$col++;
			}
			$last--;
		endforeach; ?>
		</ul>
		<div class="clear"></div>

		<?php
	}
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>