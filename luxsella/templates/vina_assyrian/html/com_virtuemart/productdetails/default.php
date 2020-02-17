<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz, Max Galt
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

// Show Label Sale Or New
// Get New Products
$db     = JFactory::getDBO();
$query  = "SELECT virtuemart_product_id FROM #__virtuemart_products ORDER BY virtuemart_product_id DESC LIMIT 0, 10";
$db->setQuery($query);
$newIds = $db->loadColumn();

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));

$isSaleLabel = (!empty($this->product->prices['discountAmount'])) ? 1 : 0;

$pid = $this->product->virtuemart_product_id;
$isNewLabel = in_array($pid, $newIds);

if(vRequest::getInt('print',false)){ ?>
<body onload="javascript:print();">
<?php } ?>

<div class="productdetails-view productdetails">
	
    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>
	
	<div class="row">
		<div class="col-xs-12 col-lg-7 col-md-7 col-sm-12">
	
			<div class="product-img-box">
				<div class="vm-product-media-container image-block">
					<div class="main-image">
						<div class="img-large">
							<?php
							echo $this->loadTemplate('images');
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
							
						</div>
					</div>
				</div>
			
				<?php 
						
					$count_images = count ($this->product->images);
					if ($count_images > 1) {
						echo $this->loadTemplate('images_additional');
					}
					
				?>
				
			</div>
	
		</div>
		
		<div class="col-xs-12 col-lg-5 col-md-5 col-sm-12 vina-des-wrapper">
			
			<div class="product-nav">
			
											<?php // Back To Category Button
				if ($this->product->virtuemart_category_id) {
					$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
					$categoryName = $this->product->category_name ;
				} else {
					$catURL =  JRoute::_('index.php?option=com_virtuemart');
					$categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME') ;
				}
				?>
				<div class="back-category">
					<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><i class="fa fa-angle-left"></i><?php echo vmText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
				</div>

				  <?php
				// Product Navigation
				if (VmConfig::get('product_navigation', 1)) {
				?>
					<div class="product-neighbours">
					<?php
					if (!empty($this->product->neighbours ['previous'][0])) {
					$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
					echo JHtml::_('link', $prev_link, $this->product->neighbours ['previous'][0]
						['product_name'], array('rel'=>'prev', 'class' => 'previous-page','data-dynamic-update' => '1'));
					}
					if (!empty($this->product->neighbours ['next'][0])) {
					$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
					echo JHtml::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page','data-dynamic-update' => '1'));
					}
					?>
					<div class="clear"></div>
					</div>
				<?php } // Product Navigation END
				?>
			
			</div>
			
			<?php // Product Title   ?>
			<h2 class="product-name clearfix"><?php echo $this->product->product_name ?></h2>
			<?php // Product Title END   ?>
			
						
			<?php // afterDisplayTitle Event
			echo $this->product->event->afterDisplayTitle ?>
			
			<!-- Product Price -->
			<div class="price-box">
				<?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$this->product,'currency'=>$this->currency)); ?>
			</div>
			
			<div class="box-container2">
				<p class="availability out-of-stock title-box2 pull-right">
					<?php echo JText::_('VM_LANG_AVAILABILITY');?>
					<?php if($this->product->product_in_stock > 0) {
						echo "<span>".JText::_('VM_LANG_IN_STOCK')."</span>";
					}
					else {
						echo "<span>".JText::_('VM_LANG_OUT_OF_STOCK')."</span>";
					}?>		
				</p>
				
				<?php // Show sku ?>
				<p class="sku title-box2 pull-left">
					<?php echo JText::_('VM_LANG_SKU_TITLE');?>
					<span class="sku-title"><?php echo $this->product->product_sku; ?></span>
				</p>

			<?php if(VmConfig::get('showReviewFor', 'none') != 'none') { ?>
			<?php // Show Rating ?>
				<div class="product-rating">
					<?php 
						echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating,'product'=>$this->product)); 
					?>	
					<span class="separator">|</span>
					<span class="add_review"><a href="javascript:void(0)" class="to_review"><?php echo JText::_('VM_LANG_ADD_YOUR_REVIEW'); ?></a></span>
				</div>
			</div>
			<?php } ?>
			
			<?php
				
				    // Product Short Description
				if (!empty($this->product->product_s_desc)) {
				?>
					<div class="product-short-description">
					<?php
					/** @todo Test if content plugins modify the product description */
					echo nl2br($this->product->product_s_desc);
					?>
					</div>
				<?php
				} // Product Short Description END
				
			?>			
			
			<div class="vm-product-container">



			<div class="vm-product-addtocart">
				<div class="spacer-buy-area">

				<?php
				// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
				/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
				  $text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
				  echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
				 */
				?>

				<?php
				

				if (is_array($this->productDisplayShipments)) {
					foreach ($this->productDisplayShipments as $productDisplayShipment) {
					//echo $productDisplayShipment . '<br />';
					}
				}
				if (is_array($this->productDisplayPayments)) {
					foreach ($this->productDisplayPayments as $productDisplayPayment) {
					echo $productDisplayPayment . '<br />';
					}
				}

				//In case you are not happy using everywhere the same price display fromat, just create your own layout
				//in override /html/fields and use as first parameter the name of your file
				
				?> <div class="clear"></div><?php
				echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$this->product));

				echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
				
				?>

				<?php
				// Manufacturer of the Product
				if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
					echo $this->loadTemplate('manufacturer');
				}
				?>
					
				</div>
			</div>
			<div class="clear"></div>


			</div>
			
				<?php if(is_dir(JPATH_BASE . "/components/com_wishlist/") || is_dir(JPATH_BASE . "/components/com_virtuemartproductcompare/") || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon') || VmConfig::get('show_emailfriend')) :?>
				<div class="icons add-to-box-2">
				
					<!-- Add Wishlist Button -->
					<?php if(is_dir(JPATH_BASE . "/components/com_wishlist/")) : 
						$app = JFactory::getApplication();	
					?>
						<div class="btn-wishlist" title="<?php echo JText::_('VM_LANG_ADD_TO_WISHLIST'); ?>">
							<?php require(JPATH_BASE . "/templates/".$app->getTemplate()."/html/wishlist.php"); ?>									
						</div>
					<?php endif; ?>
				
					<div style="display: inline-block;float:left;" class="jutooltip" title="<?php echo JText::_('ADD_TO_COMPARE'); ?>">
						<span class="vm-btn-compare"></span>
					</div>

					
					<?php if(VmConfig::get('show_emailfriend')) :  ?>
					<!-- Email to friend -->						
					<?php
					$link = 'index.php?tmpl=component&amp;option=com_virtuemart&amp;view=productdetails&amp;virtuemart_product_id=' . $this->product->virtuemart_product_id;

					//echo $this->linkIcon($link . '&amp;format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);					
					//echo $this->linkIcon($link . '&amp;print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon',false,true,false,'class="printModal"');					
					$MailLink = 'index.php?option=com_virtuemart&amp;view=productdetails&amp;task=recommend&amp;virtuemart_product_id=' . $this->product->virtuemart_product_id . '&amp;virtuemart_category_id=' . $this->product->virtuemart_category_id . '&amp;tmpl=component';
					//echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
					?>
					<a class="email-friend recommened-to-friend icon-envelope jutooltip" href="<?php echo $MailLink; ?>" title="<?php echo JText::_('VM_LANG_EMAIL_TITLE'); ?>">
						<span><?php echo vmText::_('COM_VIRTUEMART_EMAIL'); ?></span>
					</a>
					
					<?php endif;?>
					
					<?php if(VmConfig::get('show_printicon')) :  ?>
					
					<a class="print printModal icon-print jutooltip" href="<?php echo $link . '&amp;print=1' ?>" title="<?php echo JText::_('VM_LANG_PRINT_TITLE'); ?>">
						<span><?php echo vmText::_('COM_VIRTUEMART_PRINT'); ?></span>
					</a>	

					<?php endif;?>
					
					<?php
					// Ask a question about this product
					if (VmConfig::get('ask_question', 0) == 1) {
						$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
					?>						
						<a class="ask-a-question fa fa-question jutooltip" href="<?php echo $askquestion_url ?>" title="<?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL'); ?>" ><span><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL'); ?></span></a>					
					<?php } ?>
					
					
					
				</div>
				<?php endif; ?>
			
			
			<!-- Social Button -->																	
			<div class="link-share">
				<!-- AddThis Button BEGIN -->					
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like at300b" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet at300b"></a>
					<a class="addthis_button_google_plusone at300b" g:plusone:size="medium"></a>
					<a class="addthis_counter addthis_pill_style addthis_nonzero" href="#"></a>
				</div>
				<!-- AddThis Button END --> 
			</div>	
			<!-- End Social Button -->
			
		</div>
		
	</div>
	
<?php


	// event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

	<!-- Tabs Full Description + Review + comment -->
	<div class="tab-block" id="vina-tab">
		<ul class="nav nav-pills" id="tabs-detail-product">
			<?php if (!empty($this->product->product_desc)) {?>
			<li class="active">
				<a data-toggle="tab" href="#vina-description"><?php echo JText::_('VM_LANG_FULL_DESCRIPTION'); ?></a>
			</li>
			<?php }?>		
			<li class="tab_review"><a data-toggle="tab" href="#vina-reviews"><?php echo JText::_('VM_LANG_OVERVIEWS'); ?></a></li>			
		</ul>
		<div id="vinaTabContent" class="tab-content">			
			<?php // Product Description
			if (!empty($this->product->product_desc)) { ?>
				<div id="vina-description" class="tab-pane product-description active">
					<?php echo $this->product->product_desc; ?>
				</div>
			<?php } // Product Description END ?>		
			
			<div id="vina-reviews" class="tab-pane product-review">
				<?php
					echo $this->loadTemplate('reviews');
				?>
			</div>			
		</div>
	</div>
	
	
	<?php 

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal'));

    // Product Packaging
    $product_packaging = '';
	if ($this->product->product_box) {
	?>
        <div class="product-box">
	    <?php
	        echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END ?>

    <?php 
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));

    echo shopFunctionsF::renderVmSubLayout('customfields_related',array('product'=>$this->product,'position'=>'related_products','class'=> 'product-related-products','customTitle' => true ));

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_categories','class'=> 'product-related-categories'));
	?>

<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent;

echo $this->loadTemplate('reviews');

// Show child categories
if (VmConfig::get('showCategory', 1)) {
	echo $this->loadTemplate('showcategory');
}

$j = 'jQuery(document).ready(function($) {
	Virtuemart.product(jQuery("form.product"));

	$("form.js-recalculate").each(function(){
		if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
			var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
			Virtuemart.setproducttype($(this),id);

		}
	});
});';
//vmJsApi::addJScript('recalcReady',$j);

/** GALT
	 * Notice for Template Developers!
	 * Templates must set a Virtuemart.container variable as it takes part in
	 * dynamic content update.
	 * This variable points to a topmost element that holds other content.
	 */
$j = "Virtuemart.container = jQuery('.productdetails-view');
Virtuemart.containerSelector = '.productdetails-view';";

vmJsApi::addJScript('ajaxContent',$j);

echo vmJsApi::writeJS();
?> </div>

<?php
	// swallow add Js carouFredSel --------------------------------------------------------------------------
	$document = JFactory::getDocument();
	$app 	  = JFactory::getApplication();
	$template = $app->getTemplate();
	$document->addStyleSheet(JURI::base() . 'templates/' . $template . '/css/lightslider.min.css');
	$document->addScript(JURI::base() . 'templates/' . $template . '/js/lightslider.min.js');
	$document->addScriptDeclaration("
		jQuery(function($) {							
			$('.to_review, .count_review').click(function() {
				$('html, body').animate({
					scrollTop: ($('#vina-tab').offset().top - 120)
				},500);									
				$('#tabs-detail-product li').removeClass('active');
				$('#tabs-detail-product li.tab_review').addClass('active');
				$('#vinaTabContent >div').removeClass('active');
				$('#vinaTabContent #vina-reviews').addClass('active');
			});
		})
	");
 ?>
 
<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script>
