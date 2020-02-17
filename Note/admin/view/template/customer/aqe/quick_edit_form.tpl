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
	default:
		break;
}
?>
	</form>
</div>
