<?php defined('_JEXEC') or die('Restricted access');

$related = $viewData['related'];
$customfield = $viewData['customfield'];
$thumb = $viewData['thumb'];
//$showRating = $viewData['rating'];
$ratingModel = VmModel::getModel('ratings');
$rating = $ratingModel->getRatingByProduct($related->virtuemart_product_id);
$reviews = $ratingModel->getReviewsByProduct($related->virtuemart_product_id);
// Show Label Sale Or New
// Get New Products
$db     = JFactory::getDBO();
$query  = "SELECT virtuemart_product_id FROM #__virtuemart_products ORDER BY virtuemart_product_id DESC LIMIT 0, 10";
$db->setQuery($query);
$newIds = $db->loadColumn();
// Show Label Sale Or New


$isSaleLabel = (!empty($related->prices['discountAmount'])) ? 1 : 0;
$pid = $related->virtuemart_product_id;
$isNewLabel = in_array($pid, $newIds);


$pLink = $related->link.$related->virtuemart_product_id;

//juri::root() For whatever reason, we used this here, maybe it was for the mails
?>


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
	<?php echo JHtml::link ($pLink, $thumb .' <span class="shadow"></span> ' , array('title' => $related->product_name,'target'=>'_self')); ?>
	
	<div class="price-rate">
		
<!-- Rating Block -->
		<div class="product-rating">
			<?php 
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
						<?php echo JHtml::link(JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $related->virtuemart_product_id . '&virtuemart_category_id=' . $related->virtuemart_category_id), $count_review.' '.JText::_('VINA_VIRTUEMART_REVIEW'),'target = "_self"'); ?>
					</span>
			<?php } ?>
		</div>

		<!-- Product Price -->

				<?php
			if($customfield->wPrice){
				$currency = calculationHelper::getInstance()->_currencyDisplay;
				?>
				<div class="related-price-box" id="productPrice<?php echo $related->virtuemart_product_id ?>">
					<div class="related-product-price">
					<?php
						echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $related->prices);
						if ($isSaleLabel) {
							echo '<div class="price-crossed" >'.$currency->createPriceDiv ('basePrice', 'COM_VIRTUEMART_PRODUCT_BASEPRICE', $related->prices).'</div>';	
						}				
					?>
					</div>
				</div>
			<?php
			}
			?>
	
		
	</div>

</div>

<div class="des-container">
					<!-- Title Product-->
	<h2 class="product-name">
	<?php echo JHtml::link ($pLink, $related->product_name, array('title' => $related->product_name,'target'=>'_self')); ?>
	</h2>
	
		<?php
	if($customfield->wDescr){
		echo '<div class="product-description">'.$related->product_s_desc.'</div>';
	}
	?>
	
</div>
