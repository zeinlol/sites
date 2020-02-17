<input type="hidden" name="i_id" value="<?php echo $i_id; ?>" />
<?php
switch($parameter) {
	case "name":
	case "customer": ?>
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
	case "multilingual_name": ?>
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
	default:
		break;
}
?>
	</form>
</div>
