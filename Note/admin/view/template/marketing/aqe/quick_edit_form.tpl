<input type="hidden" name="i_id" value="<?php echo $i_id; ?>" />
<?php
switch($parameter) {
	case "name": ?>
		<div class="row-fluid">
			<div class="col-sm-12">
				<div class="form-group">
					<label for="first_name" class="col-sm-3 col-md-2 control-label"><?php echo $text_first_name; ?></label>
					<div class="col-sm-9 col-md-10">
						<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="last_name" class="col-sm-3 col-md-2 control-label"><?php echo $text_last_name; ?></label>
					<div class="col-sm-9 col-md-10">
						<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name; ?>" />
					</div>
				</div>
			</div>
		</div>
		<?php break;
	case "category":
	case "categories":
	case "product":
	case "products": ?>
		<div class="row-fluid">
			<div class="form-group">
				<div class="col-sm-12">
					<input type="text" name="data" id="data" class="form-control" value="" autocomplete="off" placeholder="<?php echo $text_autocomplete; ?>" />
					<div id="data-values" class="well well-sm" style="height: 150px; overflow: auto;">
					<?php foreach ($items as $item) { ?>
						<div id="data-values<?php echo $item['id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $item['name']; ?>
							<input type="hidden" name="item[]" value="<?php echo $item['id']; ?>" />
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript"><!--
$('input[name=\'data\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: '<?php echo $autocomplete; ?>' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['<?php echo $item_label; ?>'],
						value: item['<?php echo $item_value; ?>']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'data\']').val('');
		$('#data-values' + item['value']).remove();
		$('#data-values').append('<div id="data-values' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="item[]" value="' + item['value'] + '" /></div>');
	}
});

$('#data-values').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
		<?php break;
	default:
		break;
}
?>
	</form>
</div>
