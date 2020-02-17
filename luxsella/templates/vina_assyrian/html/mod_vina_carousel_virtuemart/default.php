
<?php
/*
# ------------------------------------------------------------------------
# Vina Product Carousel for VirtueMart for Joomla 3
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
JHtml::_('behavior.modal');
$doc = JFactory::getDocument();
$doc->addScript('modules/' . $module->module . '/assets/js/owl.carousel.js', 'text/javascript');
$doc->addStyleSheet('modules/' . $module->module . '/assets/css/owl.carousel.css');
$doc->addStyleSheet('modules/' . $module->module . '/assets/css/owl.theme.css');
$doc->addStyleSheet('modules/' . $module->module . '/assets/css/custom.css');

// Timthumb Class Path
$timthumb = 'modules/'.$module->module.'/libs/timthumb.php?a=c&amp;q=99&amp;z=0&amp;w='.$imageWidth.'&amp;h='.$imageHeight;
$timthumb = JURI::base() . $timthumb;

// Get New Products
$db     = JFactory::getDBO();
$query  = "SELECT virtuemart_product_id FROM #__virtuemart_products ORDER BY virtuemart_product_id DESC LIMIT 0, 10";
$db->setQuery($query);
$newIds = $db->loadColumn();

?>
<div>
<!-- CSS Block -->
<style type="text/css" scoped>
#vina-carousel-virtuemart<?php echo $module->id; ?> {
	width: <?php echo $moduleWidth; ?>;
	height: <?php echo $moduleHeight; ?>;
	margin: <?php echo $moduleMargin; ?>;
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? "background: url({$bgImage}) repeat scroll 0 0;" : ''; ?>
	<?php echo ($isBgColor) ? "background-color: {$bgColor};" : '';?>
	overflow: hidden;
}
#vina-carousel-virtuemart<?php echo $module->id; ?> .item {
	<?php echo ($isItemBgColor) ? "background-color: {$itemBgColor};" : ""; ?>;
	color: <?php echo $itemTextColor; ?>;
	padding: <?php echo $itemPadding; ?>;
	margin: <?php echo $itemMargin; ?>;
}
#vina-carousel-virtuemart<?php echo $module->id; ?> .item a {
	color: <?php echo $itemLinkColor; ?>;
}
</style>
<!-- HTML Block -->

<?php 
	$ratingModel = VmModel::getModel('ratings'); 
	$ItemidStr = '';
	$Itemid = shopFunctionsF::getLastVisitedItemId();
	if(!empty($Itemid)){
		$ItemidStr = '&amp;Itemid='.$Itemid;
	}
?>


<!-- HTML Block -->
<div id="vina-carousel-virtuemart<?php echo $module->id; ?>" class="vina-carousel-virtuemart owl-carousel <?php echo $classSuffix; ?>">
	<?php
		$totalRow  = $itemInCol;
		$totalLoop = ceil(count($products)/$totalRow);
		$keyLoop   = 0;
		for($i = 0; $i < $totalLoop; $i ++) :
	?>
	
	<div class="vina-vmproduct item">
		<?php 
		for($m = 0; $m < $totalRow; $m ++) : 
			$product = $products[$keyLoop];
			$keyLoop = $keyLoop + 1;
			if(!empty($product)) :
		?>
		<?php		
			$image  = $product->images[0];
			$pImage = (!empty($image)) ? JURI::base() . $image->file_url : '';
			$pImage = (!empty($pImage) && $resizeImage) ? $timthumb . '&amp;src=' . $pImage : $pImage;				

			if(!is_null($product->images[1])) {
				$image_second = $product->images[1];
				$pImage_second = (!empty($image_second)) ? JURI::base() . $image_second->file_url : $pImage;
				$pImage_second = (!empty($pImage_second) && $resizeImage) ? $timthumb . '&amp;src=' . $pImage_second : $pImage_second;	
			}
			
			$pLink  = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id;
			$pName  = $product->product_name;
			$rating = shopFunctionsF::renderVmSubLayout('rating', array('showRating' => $productRating, 'product' => $product));
			$sDesc  = $product->product_s_desc;
			$pDesc  = (!empty($sDesc)) ? shopFunctionsF::limitStringByWord($sDesc, 105, ' ...') : '';
			$detail = JHTML::link($pLink, vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $pName, 'class' => 'product-details'));
			$stock  = $productModel->getStockIndicator($product);
			$sLevel = $stock->stock_level;
			$sTip   = $stock->stock_tip;
			$handle = shopFunctionsF::renderVmSubLayout('stockhandle', array('product' => $product));
			$pPrice = shopFunctionsF::renderVmSubLayout('prices', array('product' => $product, 'currency' => $currency));
			$sPrice = $currency->createPriceDiv('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
			$dPrice = $currency->createPriceDiv('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
			
			//Quick View Link
			$quickview = $pLink.'&amp;tmpl=component';

			// Show Label Sale Or New
			
			$isSaleLabel = (!empty($product->prices['discountAmount'])) ? 1 : 0;
			$pid = $product->virtuemart_product_id;
			$isNewLabel = in_array($pid, $newIds);
		?>
		<div class="item-i round-corners">
			<div class="item-inner">
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
				
				<!-- Image Block -->
				<?php if($productImage && !empty($pImage) || $viewDetails) : ?>
				<div class="product-image">
					<a href="<?php echo $pLink; ?>" title="<?php echo $pName; ?>">
						<?php if(!empty($product->images[1])) :?>
							<div class="pro-image first-image">
								<img class="browseProductImage" src="<?php echo $pImage; ?>" alt="<?php echo $pName; ?>" title="<?php echo $pName; ?>" />
							</div>
							<div class="pro-image second-image">
								<img class="browseProductImage" src="<?php echo $pImage_second; ?>" alt="<?php echo $pName; ?>" title="<?php echo $pName; ?>" />				
							</div>			
						<?php else: ?>
							<div class="pro-image">
								<img class="browseProductImage" src="<?php echo $pImage; ?>" alt="<?php echo $pName; ?>" title="<?php echo $pName; ?>" />
							</div>
						<?php endif;?>
						<span class="shadow"></span>
					</a>
					
					<?php if($productPrice || $productRating) : ?>
					<div class="price-rate">
						
						<!-- Product Rating -->
						<?php if ($productRating) { ?>
							<div class="product-rating">
							<?php
								$maxrating = VmConfig::get('vm_maximum_rating_scale',5);
								$rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
								$reviews = $ratingModel->getReviewsByProduct($product->virtuemart_product_id);
								if(empty($rating->rating)) { ?>						
									<div class="ratingbox dummy" title="<?php echo vmText::_('COM_VIRTUEMART_UNRATED'); ?>" >
									</div>
								<?php } else {						
									$ratingwidth = $rating->rating * 20; ?>
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
										<a href="<?php echo $pLink.'#vina-tab'; ?>" target="_blank" ><?php echo $count_review.' '.JText::_('VM_LANG_REVIEWS');?></a>
									</span>
								<?php } ?>
							</div>
						<?php } ?>

						<!-- Product Price -->
						<?php if($productPrice) : ?>
						<div class="price-box">
							<?php if($isSaleLabel!= 0) : ?>
									<?php echo $pPrice; ?>
							<?php else : ?>
								<?php echo $sPrice; ?>
							<?php endif; ?>
						</div>
						<?php endif; ?>
						
					</div>
					<?php endif; ?>
					
					
					<?php if($addtocart || $viewDetails ) : ?>
					<div class="actions">
						<div class="action-buttons">
							<!-- Add to Cart Button-->
							<?php if($addtocart) : ?>
							<div class="add-to-cart jutooltip" title="<?php echo JText::_( 'VM_LANG_ADDTOCART_BUTTON' ); ?>" >
								<?php modVinaCarouselVirtueMartHelper::addtocart($product); ?>
							</div>
							<?php endif; ?>
							
							<div class="add-to-links">
								<?php if($viewDetails) :?>
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
										<a href="<?php echo $product->link; ?>#vina-tab" title="<?php echo JTEXT::_('VM_LANG_REVIEWS'); ?>" class="product-review jutooltip"><i class="fa fa-star"></i><span><?php echo JText::_('VM_LANG_REVIEWS');?></span></a>
									</div>
						
									<?php endif; ?>
								
								<?php endif; ?>
							</div>
							
							
						</div>
					</div>
					<?php endif; ?>
					
					
				</div>
				<?php endif; ?>
				
				<?php if($productName || $productStock || ($productDesc && !empty($pDesc))) : ?>
				<div class="des-container">
				
					<!-- Product Name -->
					<?php if($productName) : ?>
					<h2 class="product-name">
						<a href="<?php echo $pLink; ?>" title="<?php echo $pName; ?>"><?php echo $pName; ?>
						</a>
					</h2>
					<?php endif; ?>
				
						<!-- Product Stock -->
					<?php if($productStock) : ?>
					<div class="product-stock">
						<span class="vmicon vm2-<?php echo $sLevel; ?>" title="<?php echo $sTip; ?>"></span>
						<?php echo $handle; ?>
					</div>
					<?php endif; ?>
					
					<!-- Product Description -->
					<?php if($productDesc && !empty($pDesc)) : ?>
					<div class="product-description"><?php echo $pDesc; ?></div>
					<?php endif; ?>
				
				</div>
				<?php endif; ?>
				
			</div>
		</div>
		<?php endif; endfor; ?>
	</div>
	<?php endfor; ?>
</div>

<!-- Javascript Block -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#vina-carousel-virtuemart<?php echo $module->id; ?>").owlCarousel({
		items : 			<?php echo $itemsVisible; ?>,
        itemsDesktop : 		<?php echo $itemsDesktop; ?>,
        itemsDesktopSmall : <?php echo $itemsDesktopSmall; ?>,
        itemsTablet : 		<?php echo $itemsTablet; ?>,
        itemsTabletSmall : 	<?php echo $itemsTabletSmall; ?>,
        itemsMobile : 		<?php echo $itemsMobile; ?>,
        singleItem : 		<?php echo ($singleItem) ? 'true' : 'false'; ?>,
        itemsScaleUp : 		<?php echo ($itemsScaleUp) ? 'true' : 'false'; ?>,

        slideSpeed : 		<?php echo $slideSpeed; ?>,
        paginationSpeed : 	<?php echo $paginationSpeed; ?>,
        rewindSpeed : 		<?php echo $rewindSpeed; ?>,

        autoPlay : 		<?php echo $autoPlay; ?>,
        stopOnHover : 	<?php echo ($stopOnHover) ? 'true' : 'false'; ?>,

        navigation : 	<?php echo ($navigation) ? 'true' : 'false'; ?>,
        rewindNav : 	<?php echo ($rewindNav) ? 'true' : 'false'; ?>,
        scrollPerPage : <?php echo ($scrollPerPage) ? 'true' : 'false'; ?>,

        pagination : 		<?php echo ($pagination) ? 'true' : 'false'; ?>,
        paginationNumbers : <?php echo ($paginationNumbers) ? 'true' : 'false'; ?>,

        responsive : 	<?php echo ($responsive) ? 'true' : 'false'; ?>,
        autoHeight : 	<?php echo ($autoHeight) ? 'true' : 'false'; ?>,
        mouseDrag : 	<?php echo ($mouseDrag) ? 'true' : 'false'; ?>,
        touchDrag : 	<?php echo ($touchDrag) ? 'true' : 'false'; ?>,
		leftOffSet: 	<?php echo $leftOffSet; ?>,
	});
}); 
</script>
</div>