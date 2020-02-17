<input type="hidden" name="p_id" value="<?php echo $product_id; ?>" />
<?php
switch($parameter) {
	case "seo":
	case "tag":
	case "name": ?>
		<div class="row-fluid">
			<div class="col-sm-12">
		<?php foreach ($languages as $language) { ?>
				<div class="input-group multi-row">
					<span class="input-group-addon" title="<?php echo $language['name']; ?>"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span>
					<input type="text" name="value[<?php echo $language['language_id']; ?>]" class="form-control" value="<?php echo isset($value[$language['language_id']] ) ? $value[$language['language_id']] : ''; ?>" />
				</div>
		<?php } ?>
			</div>
		</div>
		<?php break;
	case "category": ?>
		<select name="p_c" multiple="multiple" size="10" class="form-control">
		<?php foreach ($categories as $category) { ?>
		<option value="<?php echo $category['category_id']; ?>"<?php echo (in_array($category['category_id'], $product_category)) ? ' selected="selected"': ''; ?>><?php echo $category['name']; ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "store": ?>
		<select name="p_s" multiple="multiple" size="10" class="form-control">
		<?php foreach ($stores as $store) { ?>
		<option value="<?php echo $store['store_id']; ?>"<?php echo (in_array($store['store_id'], $product_store)) ? ' selected="selected"': ''; ?>><?php echo $store['name']; ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "filter": ?>
		<select name="p_f" multiple="multiple" size="10" class="form-control">
		<?php foreach ($filters as $filter) { ?>
		<option value="<?php echo $filter['filter_id']; ?>"<?php echo (in_array($filter['filter_id'], $product_filter)) ? ' selected="selected"': ''; ?>><?php echo strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')); ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "filters": ?>
		<select name="product_filters" multiple="multiple" size="10" class="form-control">
		<?php foreach ($filters as $filter) { ?>
		<option value="<?php echo $filter['filter_id']; ?>"<?php echo (in_array($filter['filter_id'], $product_filter)) ? ' selected="selected"': ''; ?>><?php echo strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')); ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "download_old": ?>
		<select name="p_d" multiple="multiple" size="10" class="form-control">
		<?php foreach ($downloads as $download) { ?>
		<option value="<?php echo $download['download_id']; ?>"<?php echo (in_array($download['download_id'], $product_download)) ? ' selected="selected"': ''; ?>><?php echo $download['name']; ?></option>
		<?php } ?>
		</select>
		<?php break;
	case 'attributes': ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="attributes">
			<thead>
				<tr>
					<td class="text-left"><?php echo $entry_attribute; ?></td>
					<td class="text-left"><?php echo $entry_text; ?></td>
					<td width="1"></td>
				</tr>
			</thead>
			<tbody>
				<?php $attribute_row = 0; ?>
				<?php foreach ($product_attributes as $product_attribute) { ?>
				<tr id="attribute-row<?php echo $attribute_row; ?>">
					<td class="text-left" style="width:25%;"><input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
						<input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" /></td>
					<td class="text-left"><?php foreach ($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span>
							<textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
						</div>
						<?php } ?></td>
					<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $attribute_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"></td>
					<td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_attribute_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
			</tfoot>
		</table>
	</div>
<script type="text/javascript"><!--
var attribute_row = <?php echo $attribute_row; ?>;

function addAttribute() {
	html  = '  <tr id="attribute-row' + attribute_row + '">';
	html += '    <td class="text-left" style="width:25%;"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" placeholder="<?php echo $entry_attribute; ?>" class="form-control" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
	html += '    <td class="text-left">';
	<?php foreach ($languages as $language) { ?>
	html += '      <div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span><textarea name="product_attribute[' + attribute_row + '][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"></textarea></div>';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '  </tr>';

	$('#attributes tbody').append(html);

	attributeautocomplete(attribute_row);

	$('#attribute-row' + attribute_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	attribute_row++;
}

function attributeautocomplete(attribute_row) {
	$('input[name=\'product_attribute[' + attribute_row + '][name]\']').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							category: item.attribute_group,
							label: item.name,
							value: item.attribute_id
						}
					}));
				}
			});
		},
		select: function(item) {
			$('input[name=\'product_attribute[' + attribute_row + '][name]\']').val(item['label']);
			$('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
		}
	});
}

$('#attributes tbody tr').each(function(index, element) {
	attributeautocomplete(index);
});
//--></script>
		<?php break;
	case 'discounts': ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="discounts">
			<thead>
				<tr>
					<td class="text-left"><?php echo $entry_customer_group; ?></td>
					<td class="text-right"><?php echo $entry_quantity; ?></td>
					<td class="text-right"><?php echo $entry_priority; ?></td>
					<td class="text-right"><?php echo $entry_price; ?></td>
					<td class="text-left"><?php echo $entry_date_start; ?></td>
					<td class="text-left"><?php echo $entry_date_end; ?></td>
					<td width="1"></td>
				</tr>
			</thead>
			<tbody>
				<?php $discount_row = 0; ?>
				<?php foreach ($product_discounts as $product_discount) { ?>
				<tr id="discount-row<?php echo $discount_row; ?>">
					<td class="text-left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">
							<?php foreach ($customer_groups as $customer_group) { ?>
							<?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
							<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
					<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
					<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
					<td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
					<td class="text-left" style="width: 20%;"><div class="input-group date">
							<input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
							<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
							</span></div></td>
					<td class="text-left" style="width: 20%;"><div class="input-group date">
							<input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
							<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
							</span></div></td>
					<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $discount_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6"></td>
					<td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
			</tfoot>
		</table>
	</div>
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	html  = '  <tr id="discount-row' + discount_row + '">';
	html += '    <td class="text-left"><select name="product_discount[' + discount_row + '][customer_group_id]" class="form-control">';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
	html += '    <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
	html += '    <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
	html += '    <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '    <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '    <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '  </tr>';

	$('#discounts tbody').append(html);

	$('#discount-row' + discount_row + ' .date').datetimepicker({pickTime: false});

	$('#discount-row' + discount_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	discount_row++;
}
$('#discounts tbody .date').datetimepicker({pickTime: false});
//--></script>
		<?php break;
	case 'images': ?>
	<div class="table-responsive">
		<table id="images" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-left"><?php echo $entry_image; ?></td>
					<td class="text-right"><?php echo $entry_sort_order; ?></td>
					<td width="1"></td>
				</tr>
			</thead>
			<tbody>
				<?php $image_row = 0; ?>
				<?php foreach ($product_images as $product_image) { ?>
				<tr id="image-row<?php echo $image_row; ?>">
			<td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
			<td class="text-right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
			<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $image_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"></td>
			<td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
			</tfoot>
		</table>
	</div>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<tr id="image-row' + image_row + '">';
	html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#images tbody').append(html);

	$('#image-row' + image_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	image_row++;
}
//--></script>
		<?php break;
	case 'options': ?>
	<div class="row" id="options-data">
		<div class="col-sm-3">
			<ul class="nav nav-pills nav-stacked" id="option">
				<?php $option_row = 0; ?>
				<?php foreach ($product_options as $product_option) { ?>
				<li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove(); $('#tab-option<?php echo $option_row; ?>').remove(); $('#option a:first').tab('show');"></i> <?php echo $product_option['name']; ?></a></li>
				<?php $option_row++; ?>
				<?php } ?>
				<li>
					<input type="text" name="option" value="" placeholder="<?php echo $entry_option; ?>" id="input-option" class="form-control" />
				</li>
			</ul>
		</div>
		<div class="col-sm-9">
			<div class="tab-content">
				<?php $option_row = 0; ?>
				<?php $option_value_row = 0; ?>
				<?php foreach ($product_options as $product_option) { ?>
				<div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
					<input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
					<input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
					<input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
					<input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-required<?php echo $option_row; ?>"><?php echo $entry_required; ?></label>
						<div class="col-sm-10">
							<select name="product_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
								<?php if ($product_option['required']) { ?>
								<option value="1" selected="selected"><?php echo $text_yes; ?></option>
								<option value="0"><?php echo $text_no; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_yes; ?></option>
								<option value="0" selected="selected"><?php echo $text_no; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php if ($product_option['type'] == 'text') { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-10">
							<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'textarea') { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-10">
							<textarea name="product_option[<?php echo $option_row; ?>][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $product_option['value']; ?></textarea>
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'file') { ?>
					<div class="form-group" style="display: none;">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-10">
							<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'date') { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-3">
							<div class="input-group date">
								<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
								<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
								</span></div>
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'time') { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-10">
							<div class="input-group time">
								<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span></div>
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'datetime') { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
						<div class="col-sm-10">
							<div class="input-group datetime">
								<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span></div>
						</div>
					</div>
					<?php } ?>
					<?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
					<div class="table-responsive">
						<table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left"><?php echo $entry_option_value; ?></td>
									<td class="text-right"><?php echo $entry_quantity; ?></td>
									<td class="text-left"><?php echo $entry_subtract; ?></td>
									<td class="text-right"><?php echo $entry_price; ?></td>
									<td class="text-right"><?php echo $entry_option_points; ?></td>
									<td class="text-right"><?php echo $entry_weight; ?></td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
								<tr id="option-value-row<?php echo $option_value_row; ?>">
									<td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
											<?php if (isset($option_values[$product_option['option_id']])) { ?>
											<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
											<?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
											<option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
											<?php } ?>
											<?php } ?>
											<?php } ?>
										</select>
										<input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
									<td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
									<td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control">
											<?php if ($product_option_value['subtract']) { ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
											<?php } ?>
										</select></td>
									<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
											<?php if ($product_option_value['price_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['price_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
									<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
											<?php if ($product_option_value['points_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['points_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>
									<td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
											<?php if ($product_option_value['weight_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['weight_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>
									<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
								</tr>
								<?php $option_value_row++; ?>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="6"></td>
									<td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<select id="option-values<?php echo $option_row; ?>" style="display: none;">
						<?php if (isset($option_values[$product_option['option_id']])) { ?>
						<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
						<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<?php } ?>
				</div>
				<?php $option_row++; ?>
				<?php } ?>
			</div>
		</div>
	</div>
<script type="text/javascript"><!--
var option_row = <?php echo $option_row; ?>;

$('input[name=\'option\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item['category'],
						label: item['name'],
						value: item['option_id'],
						type: item['type'],
						option_value: item['option_value']
					}
				}));
			}
		});
	},
	'select': function(item) {
		html  = '<div class="tab-pane" id="tab-option' + option_row + '">';
		html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + item['label'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item['value'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + item['type'] + '" />';
		html += '	<div class="form-group">';
		html += '	  <label class="col-sm-2 control-label" for="input-required' + option_row + '"><?php echo $entry_required; ?></label>';
		html += '	  <div class="col-sm-10"><select name="product_option[' + option_row + '][required]" id="input-required' + option_row + '" class="form-control">';
		html += '	      <option value="1"><?php echo $text_yes; ?></option>';
		html += '	      <option value="0"><?php echo $text_no; ?></option>';
		html += '	  </select></div>';
		html += '	</div>';

		if (item['type'] == 'text') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}

		if (item['type'] == 'textarea') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><textarea name="product_option[' + option_row + '][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control"></textarea></div>';
			html += '	</div>';
		}

		if (item['type'] == 'file') {
			html += '	<div class="form-group" style="display: none;">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}

		if (item['type'] == 'date') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-3"><div class="input-group date"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'time') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><div class="input-group time"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'datetime') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
			html += '	  <div class="col-sm-10"><div class="input-group datetime"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {
			html += '<div class="table-responsive">';
			html += '  <table id="option-value' + option_row + '" class="table table-striped table-bordered table-hover">';
			html += '  	 <thead>';
			html += '      <tr>';
			html += '        <td class="text-left"><?php echo $entry_option_value; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_quantity; ?></td>';
			html += '        <td class="text-left"><?php echo $entry_subtract; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_price; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_option_points; ?></td>';
			html += '        <td class="text-right"><?php echo $entry_weight; ?></td>';
			html += '        <td></td>';
			html += '      </tr>';
			html += '  	 </thead>';
			html += '  	 <tbody>';
			html += '    </tbody>';
			html += '    <tfoot>';
			html += '      <tr>';
			html += '        <td colspan="6"></td>';
			html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + option_row + ');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
			html += '      </tr>';
			html += '    </tfoot>';
			html += '  </table>';
			html += '</div>';
			html += '  <select id="option-values' + option_row + '" style="display: none;">';

			for (i = 0; i < item['option_value'].length; i++) {
				html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
			}

			html += '  </select>';
			html += '</div>';
		}

		$('#options-data .tab-content').append(html);

		$('#option > li:last-child').before('<li><a href="#tab-option' + option_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-option' + option_row + '\\\']\').parent().remove(); $(\'#tab-option' + option_row + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</li>');

		$('#option a[href=\'#tab-option' + option_row + '\']').tab('show');

		$('.date').datetimepicker({
			pickTime: false
		});

		$('.time').datetimepicker({
			pickDate: false
		});

		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});

		$('#tab-option' + option_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

		option_row++;
	}
});

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_row) {
	html  = '<tr id="option-value-row' + option_value_row + '">';
	html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" class="form-control">';
	html += $('#option-values' + option_row).html();
	html += '  </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]" class="form-control">';
	html += '    <option value="1"><?php echo $text_yes; ?></option>';
	html += '    <option value="0"><?php echo $text_no; ?></option>';
	html += '  </select></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#option-value' + option_row + ' tbody').append(html);

	$('#option-value-row' + option_value_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	option_value_row++;
}
$('#option a:first').trigger('click');
$('#options-data .date').datetimepicker({
	pickTime: false
});

$('#options-data .time').datetimepicker({
	pickDate: false
});

$('#options-data .datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script>
		<?php break;
	case 'recurrings': ?>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="recurrings">
				<thead>
					<tr>
						<td class="text-left"><?php echo $entry_recurring ?></td>
						<td class="text-left"><?php echo $entry_customer_group ?></td>
						<td width="1"></td>
					</tr>
				</thead>
				<tbody>
					<?php $recurring_row = 0; ?>
					<?php foreach ($product_recurrings as $product_recurring) { ?>
					<tr id="recurring-row<?php echo $recurring_row; ?>">
							<td class="text-left"><select name="product_recurrings[<?php echo $recurring_row; ?>][recurring_id]" class="form-control">
											<?php foreach ($recurrings as $recurring) { ?>
											<?php if ($recurring['recurring_id'] == $product_recurring['recurring_id']) { ?>
											<option value="<?php echo $recurring['recurring_id']; ?>" selected="selected"><?php echo $recurring['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
											<?php } ?>
											<?php } ?>
									</select></td>
							<td class="text-left"><select name="product_recurrings[<?php echo $recurring_row; ?>][customer_group_id]" class="form-control">
											<?php foreach ($customer_groups as $customer_group) { ?>
											<?php if ($customer_group['customer_group_id'] == $product_recurring['customer_group_id']) { ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
											<?php } ?>
											<?php } ?>
									</select></td>
							<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#recurring-row<?php echo $recurring_row; ?>').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
					</tr>
					<?php $recurring_row++; ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td class="text-left"><button type="button" onclick="addRecurring()" data-toggle="tooltip" title="<?php echo $button_recurring_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
					</tr>
				</tfoot>
			</table>
		</div>
<script type="text/javascript"><!--
var recurring_row = <?php echo $recurring_row; ?>;

function addRecurring() {
	html  = '<tr id="recurring-row' + recurring_row + '">';
	html += '  <td class="text-left">';
	html += '    <select name="product_recurrings[' + recurring_row + '][recurring_id]" class="form-control">>';
	<?php foreach ($recurrings as $recurring) { ?>
	html += '      <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>';
	<?php } ?>
	html += '    </select>';
	html += '  </td>';
	html += '  <td class="text-left">';
	html += '    <select name="product_recurrings[' + recurring_row + '][customer_group_id]" class="form-control">>';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
	<?php } ?>
	html += '    <select>';
	html += '  </td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#recurring-row' + recurring_row + '\').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#recurrings tbody').append(html);

	$('#recurring-row' + recurring_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	recurring_row++;
}
//--></script>
		<?php break;
	case 'specials': ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="specials">
			<thead>
				<tr>
					<td class="text-left"><?php echo $entry_customer_group; ?></td>
					<td class="text-right"><?php echo $entry_priority; ?></td>
					<td class="text-right"><?php echo $entry_price; ?></td>
					<td class="text-left"><?php echo $entry_date_start; ?></td>
					<td class="text-left"><?php echo $entry_date_end; ?></td>
					<td width="1"></td>
				</tr>
			</thead>
			<tbody>
				<?php $special_row = 0; ?>
				<?php foreach ($product_specials as $product_special) { ?>
				<tr id="special-row<?php echo $special_row; ?>">
					<td class="text-left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">
							<?php foreach ($customer_groups as $customer_group) { ?>
							<?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
							<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
					<td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
					<td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
					<td class="text-left" style="width: 20%;"><div class="input-group date">
						<input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
						<span class="input-group-btn">
						<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
						</span></div></td>
					<td class="text-left" style="width: 20%;"><div class="input-group date">
						<input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
						<span class="input-group-btn">
						<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
						</span></div></td>
					<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $special_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5"></td>
					<td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
			</tfoot>
		</table>
	</div>
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tr id="special-row' + special_row + '">';
	html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
	<?php } ?>
	html += '  </select></td>';
	html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#specials tbody').append(html);

	$('#special-row' + special_row + ' .date').datetimepicker({pickTime: false	});

	$('#special-row' + special_row + ' [data-toggle=\'tooltip\']').tooltip({container: 'body'});

	special_row++;
}

$('#specials tbody .date').datetimepicker({pickTime: false});
//--></script>
		<?php break;
	case 'download': ?>
	<div class="row">
		<div class="col-sm-12">
			<input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="input-download" class="form-control" />
			<div id="product-download" class="well well-sm" style="height: 150px; overflow: auto;">
				<?php foreach ($product_downloads as $product_download) { ?>
				<div id="product-download<?php echo $product_download['download_id']; ?>"><i class="fa fa-minus-circle" onclick="$(this).parent().remove();"></i> <?php echo $product_download['name']; ?>
						<input type="hidden" name="product_download[]" value="<?php echo $product_download['download_id']; ?>" />
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<script type="text/javascript"><!--
$('input[name=\'download\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['download_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'download\']').val('');

		$('#product-download' + item['value']).remove();

		$('#product-download').append('<div id="product-download' + item['value'] + '"><i class="fa fa-minus-circle" onclick="$(this).parent().remove();"></i> ' + item['label'] + '<input type="hidden" name="product_download[]" value="' + item['value'] + '" /></div>');
	}
});
//--></script>
		<?php break;
	case 'related': ?>
	<div class="row">
		<div class="col-sm-12">
			<input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
			<div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">
				<?php foreach ($product_relateds as $product_related) { ?>
				<div id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-minus-circle" onclick="$(this).parent().remove();"></i> <?php echo $product_related['name']; ?>
						<input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<script type="text/javascript"><!--
$('input[name=\'related\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'related\']').val('');

		$('#product-related' + item['value']).remove();

		$('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle" onclick="$(this).parent().remove();"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');
	}
});
//--></script>
		<?php break;
	case 'descriptions': ?>
		<ul class="nav nav-tabs" id="language">
			<?php foreach ($languages as $language) { ?>
			<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
			<?php } ?>
		</ul>
		<div class="tab-content">
			<?php foreach ($languages as $language) { ?>
			<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
				<div class="form-group">
					<label class="control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
					<textarea name="product_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
				</div>
				<div class="form-group required">
					<label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
					<input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
					<?php if (isset($error_meta_title[$language['language_id']])) { ?>
					<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
					<?php } ?>
				</div>
				<div class="form-group">
					<label class="control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
					<textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
					<textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
				</div>
			</div>
			<?php } ?>
		</div>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
	height: 300,
	onChange: function(contents, $editable) {
		$('#input-description<?php echo $language['language_id']; ?>').val(contents);
 }
});
<?php } ?>
$("#language a:first").trigger('click');
//--></script>
		<?php break;
	default:
		break;
}
?>
