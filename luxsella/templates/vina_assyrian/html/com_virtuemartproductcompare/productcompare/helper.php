<?php
/*------------------------------------------------------------------------
# com_virtuemartproductcompare - Virtuemart Product Compare For Virtuemart
# ------------------------------------------------------------------------
# author    Webkul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://webkul.com
# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena-------------------------------------------------------------------------*/

defined ('_JEXEC') or  die('Direct Access to ' . basename (__FILE__) . ' is not allowed.');
	
if (!class_exists ('VmConfig')) {
	require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
}
VmConfig::loadConfig ();

// Load the language file of com_virtuemart.
JFactory::getLanguage ()->load ('com_virtuemart');
if (!class_exists ('calculationHelper')) {
	require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'calculationh.php');
}
	if (!class_exists ('CurrencyDisplay')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
	}
	if (!class_exists ('VirtueMartModelVendor')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' . DS . 'vendor.php');
	}
	if (!class_exists ('VmImage')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'image.php');
	}
	if (!class_exists ('shopFunctionsF')) {
		require(JPATH_SITE . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'shopfunctionsf.php');
	}
	if (!class_exists ('calculationHelper')) {
		require(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'cart.php');
	}
	if (!class_exists ('VirtueMartModelProduct')) {
		JLoader::import ('product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models');
	}


class com_compare_product {

	static function addtocart ($product) {

		

	
	
		if (!VmConfig::get ('use_as_catalog', 0)) {
			$stockhandle = VmConfig::get ('stockhandle', 'none');
			if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) {
				
				$button_lbl = JText::_ ('COM_VIRTUEMART_CART_NOTIFY');
				$button_cls = 'notify-button';
				$button_name = 'notifycustomer';
				?>
				<div style="display:inline-block;">
			<a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
				</div>
			<?php
			} else { 
				?>
			<div class="addtocart-area">
				<form method="post" class="product js-recalculate" action="?option=com_virtuemart&nosef=1&view=cart&task=addJS">
					<div class="addtocart-bar">
						<?php
						// Add the button
						$button_lbl = JText::_ ('COM_VIRTUEMART_CART_ADD_TO');
						$button_cls = ''; //$button_cls = 'addtocart_button';
						?>
						<?php // Display the add to cart button ?>
						<span class="addtocart-button">
							<?php echo shopFunctionsF::getAddToCartButton(1); ?>
						</span>

						<div class="clear"></div>
					</div>
					<input type="hidden" class="quantity-input" name="quantity[]" value="1"/>
					<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
					<input type="hidden" name="option" value="com_virtuemart"/>
					<input type="hidden" name="view" value="cart"/>
					<noscript><input type="hidden" name="task" value="add"/></noscript>
					<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
					<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>"/>
					
					
					
					
				</form>
				<div class="clear"></div>
			</div>
<?php
			}
		}
	}
}

?>