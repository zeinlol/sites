<?php // no direct access
defined('_JEXEC') or die('Restricted access');

vmJsApi::removeJScript("/modules/mod_virtuemart_cart/assets/js/update_cart.js");

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
	<?php if ($show_product_list) { ?>
		<div class="block-mini-cart">			                       		
			<div class="mini-cart mini-cart-body">
				<a class="mini-cart-title" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>">
					<i class="fa fa-shopping-cart"></i>
					<!--<span class="item-cart">					
						<span class="total"><?php echo $data->billTotal; ?></span>
					</span>	 -->

					<?php
						if ($data->totalProduct > 0 ) {
							$CART_TITLE = JText::sprintf('VM_LANG_HAVE_CART', htmlspecialchars($data->totalProduct));
						}
						else {
							$CART_TITLE = JText::_('VM_LANG_NO_CART');
						}
						
						echo "<div class='cart-title'>". $CART_TITLE ."</div>";
					?>
				</a>
				<div id="hiddencontainer" style=" display: none; ">
					<div class="vmcontainer">
						<div class="product_row">
							<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>

						<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
							<div class="subtotal_with_tax" style="float: right;"></div>
						<?php } ?>
						<div class="customProductData"></div><br>
						</div>
					</div>
				</div>
				<div class="mini-cart-content">	
					<div class="vm_cart_products">
						<div class="vmcontainer">
							<?php if(empty($data->products)) { ?>
								<p class="empty"><?php echo JText::_('VM_LANG_CART_EMPTY')?></p>
							<?php } else { ?>
								<?php foreach ($data->products as $product){ ?>
									<div class="product_row">									
										<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
										<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
											<div class="subtotal_with_tax" style="float: right;"><?php echo $product['subtotal_with_tax'] ?></div>
										<?php } ?>
										<?php if ( !empty($product['customProductData']) ) { ?>
											<div class="customProductData"><?php echo $product['customProductData'] ?></div><br>
										<?php } ?>					
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>			
					<div class="total">						
						<?php echo $data->billTotal; ?>						
					</div>			
					<div class="show_cart">
						<?php //if ($data->totalProduct) ?>
						<?php echo  $data->cart_show; ?>
					</div>
					<div style="clear:both;"></div>
					<div class="payments_signin_button" ></div>
				</div>
			</div>			
		</div>					
	<?php } ?>
	<noscript>
		<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
	</noscript>	
</div>

<script type="text/javascript">
;
(function (jQuery) {

    jQuery.fn.updateVirtueMartCartModule = function (arg) {

        var options = jQuery.extend({}, jQuery.fn.updateVirtueMartCartModule.defaults, arg);

        return this.each(function () {

            // Local Variables
            var $this = jQuery(this);

            jQuery.ajaxSetup({ cache: false })
            jQuery.getJSON(window.vmSiteurl + "index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json" + window.vmLang,
                function (datas, textStatus) {
					if (datas.totalProduct > 0) {
                        $this.find(".vm_cart_products").html("");
                        jQuery.each(datas.products, function (key, val) {
                            //jQuery("#hiddencontainer .vmcontainer").clone().appendTo(".vmcontainer .vm_cart_products");
                            jQuery("#hiddencontainer .vmcontainer").clone().appendTo(".vmCartModule .vm_cart_products");
                            jQuery.each(val, function (key, val) {
                                if (jQuery("#hiddencontainer .vmcontainer ." + key)) $this.find(".vm_cart_products ." + key + ":last").html(val);
                            });
                        });
                    }
                    $this.find(".show_cart").html(datas.cart_show);
                    $this.find(".total_products").html(datas.totalProductTxt);
                    $this.find(".total").html(datas.billTotal);
                    $this.find(".number").html(datas.totalProduct);
                }
            );
        });
    };

    // Definition Of Defaults
    jQuery.fn.updateVirtueMartCartModule.defaults = {
        name1: 'value1'
    };

})(jQuery);
</script>