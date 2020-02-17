<input type="hidden" name="i_id" value="<?php echo $i_id; ?>" />
<?php
switch($parameter) {
	case "seo":
	case "tag":
	case "title":
	case "group_name":
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
	case "store": ?>
		<select name="i_s" multiple="multiple" size="10" class="form-control">
		<?php foreach ($stores as $store) { ?>
		<option value="<?php echo $store['store_id']; ?>"<?php echo (in_array($store['store_id'], $i_s)) ? ' selected="selected"': ''; ?>><?php echo $store['name']; ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "filter": ?>
		<select name="i_f" multiple="multiple" size="10" class="form-control">
		<?php foreach ($filters as $filter) { ?>
		<option value="<?php echo $filter['filter_id']; ?>"<?php echo (in_array($filter['filter_id'], $i_f)) ? ' selected="selected"': ''; ?>><?php echo strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')); ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "filters": ?>
		<select name="filters" multiple="multiple" size="10" class="form-control">
		<?php foreach ($filters as $filter) { ?>
		<option value="<?php echo $filter['filter_id']; ?>"<?php echo (in_array($filter['filter_id'], $i_f)) ? ' selected="selected"': ''; ?>><?php echo strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')); ?></option>
		<?php } ?>
		</select>
		<?php break;
	case "filter_full": ?>
		<table class="table table-striped table-bordered table-hover" id="filters">
			<thead>
				<tr>
					<th class="text-left required"><?php echo $entry_name ?></th>
					<th class="text-right"><?php echo $entry_sort_order; ?></th>
					<th width="1"></th>
				</tr>
			</thead>
			<tbody>
				<?php $filter_row = 0; ?>
				<?php foreach ($filters as $filter) { ?>
				<tr id="filter-row<?php echo $filter_row; ?>">
					<td class="text-left" style="width: 70%;"><input type="hidden" name="filter[<?php echo $filter_row; ?>][filter_id]" value="<?php echo $filter['filter_id']; ?>" />
						<?php foreach ($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span>
							<input type="text" name="filter[<?php echo $filter_row; ?>][filter_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($filter['filter_description'][$language['language_id']]) ? $filter['filter_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name ?>" class="form-control" />
						</div>
						<?php } ?>
					</td>
					<td class="text-right"><input type="text" name="filter[<?php echo $filter_row; ?>][sort_order]" value="<?php echo $filter['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>
					<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#filter-row<?php echo $filter_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $filter_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"></td>
					<td class="text-left"><a onclick="addFilterRow();" data-toggle="tooltip" title="<?php echo $button_filter_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a></td>
				</tr>
			</tfoot>
		</table>
<script type="text/javascript"><!--
var filter_row = <?php echo $filter_row; ?>;

function addFilterRow() {
	html  = '<tr id="filter-row' + filter_row + '">';
	html += '  <td class="text-left" style="width: 70%;"><input type="hidden" name="filter[' + filter_row + '][filter_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '  <div class="input-group">';
	html += '    <span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="filter[' + filter_row + '][filter_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_name ?>" class="form-control" />';
	html += '  </div>';
	<?php } ?>
	html += '  </td>';
	html += '  <td class="text-right"><input type="text" name="filter[' + filter_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#filter-row' + filter_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#filters tbody').append(html);

	filter_row++;
}
//--></script>
		<?php break;
	case "option_value": ?>
		<table class="table table-striped table-bordered table-hover" id="option-values">
			<thead>
				<tr>
					<th class="text-left required"><?php echo $entry_option_value ?></th>
					<th class="text-left"><?php echo $entry_image ?></th>
					<th class="text-right"><?php echo $entry_sort_order; ?></th>
					<th width="1"></th>
				</tr>
			</thead>
			<tbody>
				<?php $option_value_row = 0; ?>
				<?php foreach ($option_values as $option_value) { ?>
				<tr id="option_value-row<?php echo $option_value_row; ?>">
					<td class="text-left"><input type="hidden" name="option_value[<?php echo $option_value_row; ?>][option_value_id]" value="<?php echo $option_value['option_value_id']; ?>" />
						<?php foreach ($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span>
							<input type="text" name="option_value[<?php echo $option_value_row; ?>][option_value_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />
						</div>
						<?php } ?>
					</td>
					<td class="text-left"><a href="" id="thumb-image<?php echo $option_value_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $option_value['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
						<input type="hidden" name="option_value[<?php echo $option_value_row; ?>][image]" value="<?php echo $option_value['image']; ?>" id="input-image<?php echo $option_value_row; ?>" />
					</td>
					<td class="text-right"><input type="text" name="option_value[<?php echo $option_value_row; ?>][sort_order]" value="<?php echo $option_value['sort_order']; ?>" class="form-control" /></td>
					<td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#option_value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
				<?php $option_value_row++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"></td>
					<td class="text-left"><a onclick="addOptionValue();" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a></td>
				</tr>
			</tfoot>
		</table>
<script type="text/javascript"><!--
$('select[name=\'type\']').on('change', function() {
	if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
		$('#option-value').show();
	} else {
		$('#option-value').hide();
	}
});

$('select[name=\'type\']').trigger('change');

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue() {
	html  = '<tr id="option-value-row' + option_value_row + '">';
	html += '  <td class="text-left"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '    <div class="input-group">';
	html += '      <span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="option_value[' + option_value_row + '][option_value_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_option_value; ?>" class="form-control" />';
	html += '    </div>';
	<?php } ?>
	html += '  </td>';
	html += '  <td class="text-left"><a href="" id="thumb-image' + option_value_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="option_value[' + option_value_row + '][image]" value="" id="input-image' + option_value_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#option_value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#option-values tbody').append(html);

	option_value_row++;
}
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
					<textarea name="description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($i_d[$language['language_id']]) ? $i_d[$language['language_id']]['description'] : ''; ?></textarea>
				</div>
				<div class="form-group required">
					<label class="control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
					<input type="text" name="description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($i_d[$language['language_id']]) ? $i_d[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
				</div>
				<div class="form-group">
					<label class="control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
					<textarea name="description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($i_d[$language['language_id']]) ? $i_d[$language['language_id']]['meta_description'] : ''; ?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
					<textarea name="description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($i_d[$language['language_id']]) ? $i_d[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
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
	</form>
</div>
