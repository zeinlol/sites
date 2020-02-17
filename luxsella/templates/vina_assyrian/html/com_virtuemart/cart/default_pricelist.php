<fieldset class="vm-fieldset-pricelist">
	<table class="cart-summary" style="cellspacing:0; cellpadding:0; width:100%; ">
		<!-- Table Header -->
		<thead>
			<tr class="first last">
				<?php if(VmConfig::get ('oncheckout_show_images', 1)) { ?>
					<th class="tb-image" style="width: 15%"><span class="nobr"><?php echo vmText::_ ('VM_LANG_CART_IMAGE') ?></span></th>
					<th class="tb-name" style="width: 25%"><span class="nobr"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></span></th>
					<th class="tb-sku" style="width: 10%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
					<th class="tb-price a-center" style="width: 10%"><span class="nobr"><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></span></th>
					<th class="tb-quantity a-center" style="width: 15%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?> / <?php echo vmText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
					<?php if (VmConfig::get ('show_tax')) { ?>
					<th style="width:5%;align:right;text-align:center" ><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') . '</span>' ?></th>
					<?php } ?>
					<th style="width:5%;align:right;text-align:center" ><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></th>
					<th class="tb-subtotal a-center" style="width: 15%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>					
				<?php } else { ?>					
					<th class="tb-name" style="width: 35%"><span class="nobr"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></span></th>
					<th class="tb-sku" style="width: 10%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
					<th class="tb-price a-center" style="width: 10%"><span class="nobr"><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></span></th>
					<th class="tb-quantity a-center" style="width: 15%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?> / <?php echo vmText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
					<?php if (VmConfig::get ('show_tax')) { ?>
					<th style="width:5%;text-align:center" ><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') . '</span>' ?></th>
					<?php } ?>
					<th style="width:5%;text-align:center" ><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></th>
					<th class="tb-subtotal a-center" style="width: 20%"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>					
				<?php } ?>			
				
			</tr>
		</thead>
		
		<!-- Table Body -->
		<tbody>
			<?php
			$i = 1;
			foreach ($this->cart->products as $pkey => $prow) { ?>
				<tr class="sectiontableentry<?php echo $i ?>">
					<?php if(VmConfig::get ('oncheckout_show_images', 1)) { ?>						
						<td>
							<?php if ($prow->virtuemart_media_id) { ?>
								<span class="cart-images">
									<?php if (!empty($prow->images[0])) {
										echo $prow->images[0]->displayMediaThumb ('', FALSE);
									} ?>	
								</span>
							<?php } ?>
						</td>
					<?php } ?>
					<td>
						<div class="product-name">
							<?php 
								echo JHtml::link ($prow->url, $prow->product_name);
								echo $this->customfieldsModel->CustomsFieldCartDisplay ($prow);
							?>
						</div>
					</td>
					<td><?php  echo $prow->product_sku ?></td>
					<td><?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, 1) ?></td>		
					<!-- inclusive price starts here -->
					<td>
						<?php
							if ($prow->step_order_level) $step=$prow->step_order_level;
							else $step=1;
							if($step==0)
								$step=1;
						?>
						<div class="vir_quantity">
							<input type="text"
								onblur="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								onclick="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								onchange="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								onsubmit="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />
							<button type="submit" class="fa fa-refresh vm2-add_quantity_cart" name="updatecart.<?php echo $pkey ?>" title="<?php echo  vmText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>"></button>
							<button type="submit" class="fa fa-trash-o vm2-remove_from_cart" name="delete.<?php echo $pkey ?>" title="<?php echo vmText::_ ('COM_VIRTUEMART_CART_DELETE') ?>"></button>
						</div>
					</td>
					
					<?php if (VmConfig::get ('show_tax')) { ?>
					<td style="text-align:center;"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
					<?php } ?>
					<td style="text-align:center;"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
					<!--Sub total starts here -->
					<td class="last">
					<?php					
					if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
					}
					elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
					}
					echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?>
					</td>					
				</tr>		
			<?php 
				$i = ($i==1) ? 2 : 1; 				
			?>
			<?php } ?>
			
			<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
			<?php if (VmConfig::get ('oncheckout_show_images', 1)) {
				$colspan = 8;
			} else {
				$colspan = 7;
			} ?>			
			<tr class="tb-total">
				<td colspan="<?php echo $colspan; ?>" class="total-title">
					<div class="vm-continue-shopping col-md-6">
						<?php // Continue Shopping Button
						if (!empty($this->continue_link_html)) {
							echo $this->continue_link_html;
						} ?>
					</div>
					<div class="total col-md-6">												
						<?php
						/*$discountAmount_check = 0;
						$taxAmount_check = 0;
						foreach ($this->cart->products as $pkey => $prow) {							
							if (!empty($prow->prices['taxAmount'])) {									
								$taxAmount_check = 1;
								$discountAmount_check = 1; continue;
							}
						} ?>
						<?php if ($taxAmount_check == 1 && VmConfig::get ('show_tax')) { ?>
							<?php echo "<div  class='price'>" . JText::_("COM_VIRTUEMART_PRODUCT_TAX_AMOUNT") . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE) . "</div>";?>
						<?php } ?>
						
						<?php if($discountAmount_check == 1) {
							echo "<div  class='price'>" . JText::_("COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT") . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE) . "</div>";
						} */?>							
						<div class="price">
							<?php echo vmText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL').': '; ?>
							
							<?php if (VmConfig::get ('show_tax')) { ?>
								<div><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE) . "</span>" ?></div>
							<?php } ?>
							<div><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE) . "</span>" ?></div>
							
							<?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->cartPrices, FALSE); ?>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>

<!-- Table Footer -->
<div class="table-footer">
	<?php if (VmConfig::get ('coupons_enable')) { ?>
		<div class="row sectiontableentry2">
			<div class="col-md-12">
				<div class="coupon-inner block-border">
					<div class="coupon-code">
						<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
							echo $this->loadTemplate ('coupon');
						} ?>
					<?php 
					if (!empty($this->cart->cartData['couponCode'])) {					
						echo $this->cart->cartData['couponCode'];
						echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
					?>
					</div>
						<?php if (VmConfig::get ('show_tax')) { ?>
							<?php if($this->cart->cartPrices['couponTax']) { ?>
								<div class="price-coupon">
									<span><?php echo JText::_("VM_LANG_COUPON_TAX");?> </span>
									<?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> 
								</div>
							<?php } ?>
						<?php } ?>
						<?php if($this->cart->cartPrices['salesPriceCoupon']) { ?>
							<div class="price-coupon">
								<span><?php echo JText::_("VM_LANG_SALES_PRICE_COUPON");?></span>
								<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?>
							</div>
						<?php } ?>
				</div>				
				<?php } else { ?>
					</div>
				</div>				
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	
	<!-- DBTax Rules Bill -->
	<?php foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) { ?>
		<div class="row sectiontableentry<?php echo $i ?>">
			<div class="col-md-12">
				<div class="sectiontableentry-inner block-border">
					<div class="calc_name"><?php echo $rule['calc_name'] ?> </div>					
					<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></div>
					<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
				</div>
			</div>
		</div>
		<?php 
			if ($i) { $i = 1;} 
			else { $i = 0;}
		?>
	<?php } ?>
	
	<?php foreach ($this->cart->cartData['taxRulesBill'] as $rule) { ?>
		<div class="row sectiontableentry<?php echo $i ?>">
			<div class="col-md-12">
				<div class="sectiontableentry-inner block-border">
					<div class="calc_name"><?php echo $rule['calc_name'] ?> </div>
					<?php if (VmConfig::get ('show_tax')) { ?>
						<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
					<?php } ?>			
					<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
				</div>
			</div>
		</div>
		<?php
		if ($i) {
			$i = 1;
		} else {
			$i = 0;
		}
	} ?>
	<?php foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) { ?>
		<div class="row sectiontableentry<?php echo $i ?>">
			<div class="col-md-12">
				<div class="sectiontableentry-inner block-border">
					<div><?php echo   $rule['calc_name'] ?> </div>					
					<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </div>
					<div class="vm_calc"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
				</div>
			</div>
		</div>
		<?php
		if ($i) {
			$i = 1;
		} else {
			$i = 0;
		}
	} ?>
	<?php if ( 	VmConfig::get('oncheckout_opc',true) or !VmConfig::get('oncheckout_show_steps',false) or (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and !empty($this->cart->virtuemart_shipmentmethod_id))) { ?>
		<div class="row sectiontableentry1">
			<?php if (!$this->cart->automaticSelectedShipment) { ?>
				<div class="shipment col-md-12">
					<div class="sectiontableentry1-inner block-border">
						<?php
						echo $this->cart->cartData['shipmentName'].'<br/>';
						if (!empty($this->layoutName) and $this->layoutName == 'default') {
							if (VmConfig::get('oncheckout_opc', 0)) {
								$previouslayout = $this->setLayout('select');
								echo $this->loadTemplate('shipment');
								$this->setLayout($previouslayout);
							} else {
								echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
							}
						} else {
							echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING');
						} ?>
						<?php if (VmConfig::get ('show_tax') && $this->cart->cartPrices['shipmentTax']) { ?>
							<div class="shipment-tax"><?php echo "<span  class='priceColor2'>" . JText::_('VM_LANG_CART_SHIPMENT_TAX') . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE) . "</span>"; ?> </div>
						<?php } ?>
						<?php if ($this->cart->cartPrices['salesPriceShipment']) { ?>
							<div class="shipment-sale-price"><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo JText::_('VM_LANG_CART_SHIPMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></div>
							<div class="shipment-sale-price"><?php echo JText::_('VM_LANG_CART_SHIPMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?> </div>
						<?php } ?>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-md-12">
					<div class="sectiontableentry1-inner block-border">
					<?php echo $this->cart->cartData['shipmentName']; ?>
					<?php if (VmConfig::get ('show_tax') && $this->cart->cartPrices['shipmentTax']) { ?>
						<div class="shipment-tax"><?php echo "<span  class='priceColor2'>" . JText::_('VM_LANG_CART_SHIPMENT_TAX') . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE) . "</span>"; ?> </div>
					<?php } ?>
					<?php if ($this->cart->cartPrices['salesPriceShipment']) { ?>
						<div class="shipment-sale-price"><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo JText::_('VM_LANG_CART_SHIPMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></div>
						<div class="shipment-sale-price"><?php echo JText::_('VM_LANG_CART_SHIPMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?> </div>
					<?php } ?>
					</div>
				</div>
			<?php } ?>			
		</div>
	<?php } ?>
	<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and (VmConfig::get('oncheckout_opc',true) or !VmConfig::get('oncheckout_show_steps',false) or ( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id)))) { ?>
		<div class="row sectiontableentry1">
			<?php if (!$this->cart->automaticSelectedPayment) { ?>
				<div class="payment col-md-12">
					<div class="sectiontableentry1-inner block-border">			
						<div class="sectiontableentry1_paymentname">
							<?php echo $this->cart->cartData['paymentName'].'<br/>';?>
						</div>
						<?php
						if (!empty($this->layoutName) && $this->layoutName == 'default') { ?>
							<div class="sectiontableentry1_paymentname">
								<?php 
								if (VmConfig::get('oncheckout_opc', 0)) {
									$previouslayout = $this->setLayout('select');
									echo $this->loadTemplate('payment');
									$this->setLayout($previouslayout);
								} else {
									echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
								} ?>
							</div>
						<?php } else { ?>
							<div class="paymentshow_cart_payment" >
								<?php echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT'); ?>
							</div>
						<?php } ?>
						<?php if (VmConfig::get ('show_tax') && $this->cart->cartPrices['paymentTax']) { ?>
							<div class="paymentshow_tax"><?php echo "<span  class='priceColor2'>" .JText::_('VM_LANG_CART_PAYMENT_TAX'). $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; ?> </div>
						<?php } ?>
						<?php if ($this->cart->cartPrices['salesPricePayment']) { ?>
							<div class="paymentsalesprice"><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo JText::_('VM_LANG_CART_PAYMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?></div>
							<div class="paymentsalesprice"><?php  echo JText::_('VM_LANG_CART_PAYMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </div>
						<?php } ?>
					</div>
				</div>		
			<?php } else { ?>
				<div class="col-md-12">
					<div class="sectiontableentry1-inner block-border">
						<div class="sectiontableentry1_paymentname">
							<?php echo $this->cart->cartData['paymentName']; ?>
						</div>
						<?php if (VmConfig::get ('show_tax') && $this->cart->cartPrices['paymentTax']) { ?>
							<div class="paymentshow_tax"><?php echo "<span  class='priceColor2'>" . JText::_('VM_LANG_CART_PAYMENT_TAX') . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; ?> </div>
						<?php } ?>
						<?php if ($this->cart->cartPrices['salesPricePayment']) { ?>
							<div class="paymentsalesprice"><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo JText::_('VM_LANG_CART_PAYMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?></div>
							<div class="paymentsalesprice"><?php  echo JText::_('VM_LANG_CART_PAYMENT_SALES_PRICE') . $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </div>
						<?php } ?>
					</div>
				</div>					
			<?php } ?>
		</div>
	<?php  } ?>			
	<?php if ($this->totalInPaymentCurrency) { ?>
		<div class="row sectiontableentry2">
			<div class="col-md-12">
				<div class="sectiontableentry2-inner block-border">
					<div><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</div>					
					<div class="text-right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="row sectiontableentry2">
		<div class="col-md-12">
			<div class="sectiontableentry2-inner block-border total-block">	
				<?php if (VmConfig::get ('show_tax') && !empty($this->cart->cartPrices['billTaxAmount'])) { ?>			
				<?php echo "<span  class='priceColor2'><span class='title'>" . vmText::_ ('COM_VIRTUEMART_PRODUCT_TAX_AMOUNT') .':</span>'. $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE) . "</span>" ?>				
				<?php } ?>
				
				<?php if(!empty($this->cart->cartPrices['billDiscountAmount'])) { ?>
					<?php echo "<span  class='priceColor2'><span class='title'>" . vmText::_ ('COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT') .':</span>'. $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE) . "</span>" ?>				
				<?php } ?>
				
				<span class="title"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?> :</span>	
				<?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?>							
			</div>
		</div>
	</div>
</div>