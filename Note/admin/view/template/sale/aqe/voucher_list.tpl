<?php echo $header; ?>
<!-- confirm deletion -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="confirmDeleteLabel"><?php echo $text_confirm_delete; ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo $text_are_you_sure; ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $button_cancel; ?></button>
				<button type="button" class="btn btn-danger delete"><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- action menu modal -->
<div class="modal fade" id="aqe-modal" tabindex="-1" role="dialog" aria-labelledby="aqeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="aqeModalLabel"></h4>
			</div>
			<div class="modal-body bull5i-container">
				<div class="notice">
				</div>
				<form enctype="multipart/form-data" id="aqeQuickEditForm" class="form-horizontal">
					<fieldset class="aqe-modal-contents">
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
				<button type="button" class="btn btn-primary submit" data-form="#aqeQuickEditForm" data-context="#aqe-modal" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <?php echo $text_saving; ?>"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<ul class="breadcrumb bull5i-breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li<?php echo ($breadcrumb['active']) ? ' class="active"' : ''; ?>><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
			<div class="navbar-placeholder">
				<nav class="navbar navbar-bull5i" role="navigation" id="bull5i-navbar">
					<div class="nav-container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bull5i-navbar-collapse">
								<span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<h1 class="bull5i-navbar-brand"><i class="fa fa-list fa-fw ext-icon"></i> <?php echo $heading_title; ?></h1>
						</div>
						<div class="collapse navbar-collapse" id="bull5i-navbar-collapse">
							<div class="navbar-right">
								<div class="nav navbar-nav navbar-checkbox hidden" id="batch-edit-container">
									<div class="checkbox">
										<label>
											<input type="checkbox" id="batch-edit"<?php echo ($batch_edit) ? ' checked': ''; ?>> <?php echo $text_batch_edit; ?>
										</label>
									</div>
								</div>
								<div class="nav navbar-nav btn-group">
									<button type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_send; ?>" data-url="<?php echo $send; ?>" id="btn-send" data-form="#pqe-list-form" data-context="#content" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_sending; ?></span>" disabled><i class="fa fa-envelope"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_send; ?></span></button>
									<button type="button" class="btn btn-primary" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_add; ?>" data-url="<?php echo $add; ?>" id="btn-insert" data-form="#pqe-list-form" data-context="#content"><i class="fa fa-plus"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_add; ?></span></button>
									<button type="button" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_delete; ?>" data-url="<?php echo $delete; ?>" id="btn-delete" data-form="#pqe-list-form" data-context="#content" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_deleting; ?></span>" disabled><i class="fa fa-trash-o"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_delete; ?></span></button>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>

	<div class="alerts">
		<div class="container-fluid" id="alerts">
			<?php foreach ($alerts as $type => $_alerts) { ?>
				<?php foreach ((array)$_alerts as $alert) { ?>
					<?php if ($alert) { ?>
			<div class="alert alert-<?php echo ($type == "error") ? "danger" : $type; ?> fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="fa <?php echo $alert_icon($type); ?>"></i><?php echo $alert; ?>
			</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>

	<div class="container-fluid bull5i-content bull5i-container">
		<form method="post" enctype="multipart/form-data" id="pqe-list-form" class="form-horizontal" role="form">
			<fieldset>
				<div class="table-responsive">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?>" id="dT">
						<thead>
							<tr>
								<?php foreach ($columns as $col) {
								 switch($col) {
									case 'selector': ?>
								<th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>" width="1"><input type="checkbox" id="global-selector" /></th>
									<?php break;
									default: ?>
									<?php if (!empty($column_info[$col]['sort'])) { ?>
								<th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>"><a href="<?php echo $sorts[$col]; ?>"<?php echo ($sort == $column_info[$col]['sort']) ? ' class="' . strtolower($order) . '"' : ''; ?>><?php echo $column_info[$col]['name']; ?></a></th>
									<?php } else { ?>
								<th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>"><?php echo $column_info[$col]['name']; ?></th>
									<?php } ?>
									<?php break;
								 } ?>
								<?php } ?>
							</tr>
							<tr class="filters">
								<?php foreach ($columns as $col) {
								 switch($col) {
									case 'selector': ?>
								<th></th>
									<?php break;
									case 'status': ?>
								<th class="<?php echo $column_info[$col]['align']; ?>">
									<select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
										<option value=""></option>
										<option value="1"<?php echo ($filters[$col]) ? ' selected' : ''; ?>><?php echo $text_enabled; ?></option>
										<option value="0"<?php echo (!is_null($filters[$col]) && !$filters[$col]) ? ' selected' : ''; ?>><?php echo $text_disabled; ?></option>
									</select>
								</th>
									<?php break;
									case 'action': ?>
								<th class="<?php echo $column_info[$col]['align']; ?>">
									<div class="btn-group btn-group-flex">
										<button type="button" class="btn btn-sm btn-default" id="filter" data-toggle="tooltip" data-container="body" title="<?php echo $text_filter; ?>"><i class="fa fa-filter fa-fw"></i></button>
										<button type="button" class="btn btn-sm btn-default" id="clear-filter" data-toggle="tooltip" data-container="body" title="<?php echo $text_clear_filter; ?>"><i class="fa fa-times fa-fw"></i></button>
									</div>
								</th>
									<?php break;
									case 'theme': ?>
								<th class="<?php echo $column_info[$col]['align']; ?>">
									<select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
										<option value=""></option>
										<?php foreach ($voucher_themes as $voucher_theme) { ?>
										<option value="<?php echo $voucher_theme['voucher_theme_id']; ?>"<?php echo (!is_null($filters[$col]) && $voucher_theme['voucher_theme_id'] == $filters[$col]) ? ' selected="selected"' : ''; ?>><?php echo $voucher_theme['name']; ?></option>
										<?php } ?>
									</select>
								</th>
									<?php break;
									default: ?>
								<th class="<?php echo $column_info[$col]['align']; ?>"><input type="text" name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>" value="<?php echo !is_null($filters[$col]) ? $filters[$col] : ''; ?>"></th>
									<?php break;
								 } ?>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php if ($vouchers) { ?>
							<?php foreach ($vouchers as $voucher) { ?>
							<tr>
								<?php foreach($columns as $col) {
									switch ($col) {
										case 'selector': ?>
								<td style="width:1px" class="text-center">
									<input type="checkbox" name="selected[]" value="<?php echo $voucher['voucher_id']; ?>"<?php if ($voucher['selected']) { ?> checked <?php } ?>/>
								</td>
										<?php break;
										case 'action': ?>
								<td class="<?php echo $column_info[$col]['align']; ?> action">
									<div class="btn-group btn-group-flex">
									<?php foreach ($voucher['action'] as $action) { ?>
									<?php if ($action['type'] == 'send') { ?>
										<button type="button" data-url="<?php echo $action['url']; ?>" class="btn btn-default btn-sm action btn-send <?php echo $action['type']; ?> <?php echo $action['class']; ?>" id="<?php echo $action['action'] . "-" . $voucher['voucher_id']; ?>" data-toggle="tooltip" data-container="body" title="<?php echo $action['title']; ?>" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><?php if ($action['icon']) { ?><i class="fa fa-<?php echo $action['icon']; ?>"></i><?php } ?></i><?php echo $action['name']; ?></button>
									<?php } else { ?>
									<?php if ($action['url']) { ?>
										<a href="<?php echo $action['url']; ?>" class="btn btn-default btn-sm <?php echo $action['type']; ?> <?php echo $action['class']; ?>" id="<?php echo $action['action'] . "-" . $voucher['voucher_id']; ?>" data-toggle="tooltip" data-container="body" title="<?php echo $action['title']; ?>"><i class="fa fa-<?php echo $action['icon']; ?>"></i><?php echo $action['name']; ?></a>
									<?php } else { ?>
										<button type="button" class="btn btn-default btn-sm action <?php echo $action['type']; ?> <?php echo $action['class']; ?>" id="<?php echo $action['action'] . "-" . $voucher['voucher_id']; ?>" data-toggle="tooltip" data-container="body" title="<?php echo $action['title']; ?>" data-column="<?php echo $action['action']; ?>"<?php echo ($action['rel']) ? ' data-rel="' . $action['rel'] . '"' : ''; ?>><?php if ($action['icon']) { ?><i class="fa fa-<?php echo $action['icon']; ?>"></i><?php } ?><?php echo $action['name']; ?></button>
									<?php } ?>
									<?php } ?>
									<?php } ?>
									</div>
								</td>
										<?php break;
										default: ?>
								<td class="<?php echo $column_info[$col]['align']; ?><?php echo ($column_info[$col]['qe_status']) ? ' ' . $column_info[$col]['type'] : ''; ?>" id="<?php echo $col . "-" . $voucher['voucher_id']; ?>"><?php echo $voucher[$col]; ?></td>
										<?php break;
									}
								} ?>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td class="text-center" colspan="<?php echo count($columns) + 1; ?>"><?php echo $text_no_results; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</fieldset>
		</form>
		<div class="row">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
			<div class="col-sm-6 text-right"><?php echo $results; ?></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
(function(bull5i,$,undefined){
var related=<?php echo json_encode($related); ?>;bull5i.batch_edit=parseInt("<?php echo (int)$batch_edit; ?>"),bull5i.texts=$.extend({},bull5i.texts,{error_ajax_request:"<?php echo addslashes($error_ajax_request); ?>"}),bull5i.update_related=function(){return!1};
bull5i.filter=function(){url='index.php?route=sale/voucher&token=<?php echo $token; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>';
<?php foreach($column_info as $column => $val) { if ($val['filter']['show']) { if ($val['filter']['type'] == 0) { ?>
var filter_<?php echo $column; ?>=$('input[name=\'filter_<?php echo $column; ?>\']').not(':disabled').val();
if(filter_<?php echo $column; ?>){url+='&filter_<?php echo $column; ?>='+encodeURIComponent(filter_<?php echo $column; ?>);}
<?php } else if ($val['filter']['type'] == 1) { ?>
var filter_<?php echo $column; ?>=$('select[name=\'filter_<?php echo $column; ?>\']').val();
if (filter_<?php echo $column; ?>&&filter_<?php echo $column; ?>!='*'){url+='&filter_<?php echo $column; ?>='+encodeURIComponent(filter_<?php echo $column; ?>);}
<?php } } } ?>location = url;}
$(function(){$("input.fltr.date_added").datetimepicker({pickTime:!1,format:"YYYY-MM-DD",keepInvalid:1}),$(".qe").editable(function(t,e){return bull5i.quick_update(this,t,e,"<?php echo $update_url; ?>").done($.proxy(bull5i.update_finished,{column:$(this).attr("id").split("-")[0]})).fail($.proxy(bull5i.update_failed,this)),e.indicator},{type:"bs_text",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel",placeholder:"",select:!0}),$(".amount_qe").editable(function(t,e){return bull5i.quick_update(this,t,e,"<?php echo $update_url; ?>").done($.proxy(bull5i.update_finished,{column:$(this).attr("id").split("-")[0]})).fail($.proxy(bull5i.update_failed,this)),e.indicator},{data:function(t){return $.trim(t.replace(/[^\d\.]/g,""))},type:"bs_text",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel",placeholder:"",select:!0}),$(".status_qe").editable(function(t,e){return bull5i.quick_update(this,t,e,"<?php echo $update_url; ?>").done($.proxy(bull5i.update_finished,{column:$(this).attr("id").split("-")[0]})).fail($.proxy(bull5i.update_failed,this)),e.indicator},{data:"<?php echo trim($status_select); ?>",type:"bs_select",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel"}),$(".theme_qe").editable(function(t,e){return bull5i.quick_update(this,t,e,"<?php echo $update_url; ?>").done($.proxy(bull5i.update_finished,{column:$(this).attr("id").split("-")[0]})).fail($.proxy(bull5i.update_failed,this)),e.indicator},{data:"<?php echo trim($voucher_themes_select); ?>",type:"bs_select",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel"}),$(".text_qe").editable(function(t,e){return bull5i.quick_update(this,t,e,"<?php echo $update_url; ?>").done($.proxy(bull5i.update_finished,{column:$(this).attr("id").split("-")[0]})).fail($.proxy(bull5i.update_failed,this)),e.indicator},{type:"bs_textarea",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",submit:'<button type="submit" class="btn btn-xs btn-primary"><?php echo addslashes($button_ok); ?></button>',onblur:"cancel",placeholder:"",select:!0,rows:2})});
}(window.bull5i=window.bull5i||{},jQuery));
//--></script>
<?php echo $footer; ?>
