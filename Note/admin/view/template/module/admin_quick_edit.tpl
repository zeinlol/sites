<?php echo $header; ?>
<div class="modal fade" id="legal_text" tabindex="-1" role="dialog" aria-labelledby="legal_text_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="legal_text_label"><?php echo $text_terms; ?></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
			</div>
		</div>
	</div>
</div>
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
							<h1 class="bull5i-navbar-brand"><i class="fa fa-pencil fa-fw ext-icon"></i> <?php echo $heading_title; ?></h1>
						</div>
						<div class="collapse navbar-collapse" id="bull5i-navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#settings" data-toggle="tab"><!-- ko if: settings_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !settings_errors()}"></i> <!-- /ko --><?php echo $tab_settings; ?></a></li>
								<li><a href="#ext-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
								<li><a href="#about-ext" data-toggle="tab"><?php echo $tab_about; ?></a></li>
							</ul>
							<div class="nav navbar-nav btn-group navbar-right">
								<?php if ($update_pending) { ?><button type="button" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_upgrade; ?>" class="btn btn-info" id="btn-upgrade" data-url="<?php echo $upgrade; ?>" data-form="#sForm" data-context="#content" data-overlay="#page-overlay" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_upgrading; ?></span>"><i class="fa fa-arrow-circle-up"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_upgrade; ?></span></button><?php } ?>
								<button type="button" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_apply; ?>" class="btn btn-success" id="btn-apply" data-url="<?php echo $save; ?>" data-form="#sForm" data-context="#content" data-overlay="#page-overlay" data-vm="ExtVM" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_saving; ?></span>"<?php echo $update_pending ? ' disabled': ''; ?>><i class="fa fa-check"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_apply; ?></span></button>
								<button type="submit" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_save; ?>" class="btn btn-primary" id="btn-save" data-url="<?php echo $save; ?>" data-form="#sForm" data-context="#content" data-overlay="#page-overlay" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_saving; ?></span>"<?php echo $update_pending ? ' disabled': ''; ?>><i class="fa fa-save"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_save; ?></span></button>
								<a href="<?php echo $cancel; ?>" class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_cancel; ?>" id="btn-cancel" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_canceling; ?></span>"><i class="fa fa-ban"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_cancel; ?></span></a>
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
		<div id="page-overlay" class="bull5i-overlay fade in">
			<div class="page-overlay-progress"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
		</div>

		<form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="sForm" class="form-horizontal" role="form">
			<div class="tab-content">
				<div class="tab-pane active" id="settings">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#settings-navbar-collapse">
									<span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<h3 class="panel-title"><i class="fa fa-cog fa-fw"></i> <?php echo $tab_settings; ?></h3>
							</div>
							<div class="collapse navbar-collapse" id="settings-navbar-collapse">
								<ul class="nav navbar-nav">
									<li class="active"><a href="#general-settings" data-toggle="tab"><!-- ko if: general_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !general_errors()}"></i> <!-- /ko --><?php echo $tab_general; ?></a></li>
									<li><a href="#catalog-settings" data-toggle="tab"><!-- ko if: catalog_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !catalog_errors()}"></i> <!-- /ko --><?php echo $tab_catalog; ?></a></li>
									<li><a href="#customer-settings" data-toggle="tab"><!-- ko if: customer_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !customer_errors()}"></i> <!-- /ko --><?php echo $tab_customer; ?></a></li>
									<li><a href="#sales-settings" data-toggle="tab"><!-- ko if: sales_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !sales_errors()}"></i> <!-- /ko --><?php echo $tab_sales; ?></a></li>
									<li><a href="#marketing-settings" data-toggle="tab"><!-- ko if: marketing_errors() --><i class="fa fa-exclamation-circle text-danger hidden" data-bind="css:{'hidden': !marketing_errors()}"></i> <!-- /ko --><?php echo $tab_marketing; ?></a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane active" id="general-settings">
									<div class="row">
										<div class="col-sm-12">
											<fieldset>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_status"><?php echo $entry_extension_status; ?></label>
													<div class="col-sm-2 fc-auto-width">
														<select name="aqe_status" id="aqe_status" data-bind="value: status" class="form-control">
															<option value="1"><?php echo $text_enabled; ?></option>
															<option value="0"><?php echo $text_disabled; ?></option>
														</select>
														<input type="hidden" name="aqe_installed" value="1" />
														<input type="hidden" name="aqe_installed_version" value="<?php echo $installed_version; ?>" />
														<input type="hidden" name="aqe_multilingual_seo" value="<?php echo $aqe_multilingual_seo; ?>" />
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_match_anywhere0"><?php echo $entry_match_anywhere; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_match_anywhere" id="aqe_match_anywhere1" value="1" data-bind="checked: match_anywhere"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_match_anywhere" id="aqe_match_anywhere0" value="0" data-bind="checked: match_anywhere"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_match_anywhere; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_alternate_row_colour0"><?php echo $entry_alternate_row_colour; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_alternate_row_colour" id="aqe_alternate_row_colour1" value="1" data-bind="checked: alternate_row_colour"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_alternate_row_colour" id="aqe_alternate_row_colour0" value="0" data-bind="checked: alternate_row_colour"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_alternate_row_colour; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_row_hover_highlighting0"><?php echo $entry_row_hover_highlighting; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_row_hover_highlighting" id="aqe_row_hover_highlighting1" value="1" data-bind="checked: row_hover_highlighting"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_row_hover_highlighting" id="aqe_row_hover_highlighting0" value="0" data-bind="checked: row_hover_highlighting"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_row_hover_highlighting; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_highlight_status0"><?php echo $entry_highlight_status; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_highlight_status" id="aqe_highlight_status1" value="1" data-bind="checked: highlight_status"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_highlight_status" id="aqe_highlight_status0" value="0" data-bind="checked: highlight_status"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_highlight_status; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_interval_filter0"><?php echo $entry_interval_filter; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_interval_filter" id="aqe_interval_filter1" value="1" data-bind="checked: interval_filter"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_interval_filter" id="aqe_interval_filter0" value="0" data-bind="checked: interval_filter"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_interval_filter; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_batch_edit0"><?php echo $entry_batch_edit; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_batch_edit" id="aqe_batch_edit1" value="1" data-bind="checked: batch_edit"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_batch_edit" id="aqe_batch_edit0" value="0" data-bind="checked: batch_edit"> <?php echo $text_no; ?>
														</label>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
														<span class="help-block help-text"><?php echo $help_batch_edit; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_quick_edit_on"><?php echo $entry_quick_edit_on; ?></label>
													<div class="col-sm-3 fc-auto-width">
														<select name="aqe_quick_edit_on" id="aqe_quick_edit_on" data-bind="value: quick_edit_on" class="form-control">
															<option value="click"><?php echo $text_single_click; ?></option>
															<option value="dblclick"><?php echo $text_double_click; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_single_language_editing0"><?php echo $entry_single_language_editing; ?></label>
													<div class="col-sm-9 col-md-10">
														<label class="radio-inline">
															<input type="radio" name="aqe_single_language_editing" id="aqe_single_language_editing1" value="1" data-bind="checked: single_language_editing"> <?php echo $text_yes; ?>
														</label>
														<label class="radio-inline">
															<input type="radio" name="aqe_single_language_editing" id="aqe_single_language_editing0" value="0" data-bind="checked: single_language_editing"> <?php echo $text_no; ?>
														</label>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-md-2 control-label" for="aqe_list_view_image_width" data-bind="css: {'has-error': list_view_image_width.hasError || list_view_image_height.hasError}"><?php echo $entry_list_view_image_size; ?></label>
													<div class="col-sm-3 col-md-3 col-lg-2">
														<div class="input-group">
														<input type="text" class="form-control text-right" name="aqe_list_view_image_width" id="aqe_list_view_image_width" data-bind="value: list_view_image_width, css: {'has-error': list_view_image_width.hasError}">
														<span class="input-group-addon"><i class="fa fa-times"></i></span>
														<input type="text" class="form-control" name="aqe_list_view_image_height" id="aqe_list_view_image_height" data-bind="value: list_view_image_height, css: {'has-error': list_view_image_height.hasError}">
														</div>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 error-container has-error" data-bind="visible: list_view_image_width.hasError && list_view_image_width.errorMsg">
														<span class="help-block error-text" data-bind="text: list_view_image_width.errorMsg"></span>
													</div>
													<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 error-container has-error" data-bind="visible: list_view_image_height.hasError && list_view_image_height.errorMsg">
														<span class="help-block error-text" data-bind="text: list_view_image_height.errorMsg"></span>
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="catalog-settings">
									<div class="row">
										<div class="col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="active"><a href="#tab-catalog-categories" role="tab" data-toggle="tab"><?php echo $tab_categories; ?></a></li>
												<li><a href="#tab-catalog-products" role="tab" data-toggle="tab"><?php echo $tab_products; ?></a></li>
												<li><a href="#tab-catalog-recurrings" role="tab" data-toggle="tab"><?php echo $tab_recurrings; ?></a></li>
												<li><a href="#tab-catalog-filters" role="tab" data-toggle="tab"><?php echo $tab_filters; ?></a></li>
												<li><a href="#tab-catalog-attributes" role="tab" data-toggle="tab"><?php echo $tab_attributes; ?></a></li>
												<li><a href="#tab-catalog-attribute-groups" role="tab" data-toggle="tab"><?php echo $tab_attribute_groups; ?></a></li>
												<li><a href="#tab-catalog-options" role="tab" data-toggle="tab"><?php echo $tab_options; ?></a></li>
												<li><a href="#tab-catalog-manufacturers" role="tab" data-toggle="tab"><?php echo $tab_manufacturers; ?></a></li>
												<li><a href="#tab-catalog-downloads" role="tab" data-toggle="tab"><?php echo $tab_downloads; ?></a></li>
												<li><a href="#tab-catalog-reviews" role="tab" data-toggle="tab"><?php echo $tab_reviews; ?></a></li>
												<li><a href="#tab-catalog-information" role="tab" data-toggle="tab"><?php echo $tab_information; ?></a></li>
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab-catalog-categories" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_categories_status"><?php echo $entry_catalog_categories_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_categories_status" id="aqe_catalog_categories_status" data-bind="value: catalog_categories_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_categories -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_categories][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_categories][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_categories][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-products" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_products_status"><?php echo $entry_catalog_products_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_products_status" id="aqe_catalog_products_status" data-bind="value: catalog_products_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_products -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_products][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_products][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_products][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_actions; ?>" data-container="body"><?php echo $entry_actions; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_products_actions -->
																			<tr data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_products_actions][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_products_actions][' + column +']'}" type="checkbox" class="column-display" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_products_filter_sub_category0"><?php echo $entry_catalog_products_filter_sub_category; ?></label>
																<div class="col-sm-9 col-md-10">
																	<label class="radio-inline">
																		<input type="radio" name="aqe_catalog_products_filter_sub_category" id="aqe_catalog_products_filter_sub_category1" value="1" data-bind="checked: catalog_products_filter_sub_category"> <?php echo $text_yes; ?>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="aqe_catalog_products_filter_sub_category" id="aqe_catalog_products_filter_sub_category0" value="0" data-bind="checked: catalog_products_filter_sub_category"> <?php echo $text_no; ?>
																	</label>
																</div>
																<div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10 help-container">
																	<span class="help-block help-text"><?php echo $help_filter_sub_category; ?></span>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-recurrings" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_recurrings_status"><?php echo $entry_catalog_recurrings_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_recurrings_status" id="aqe_catalog_recurrings_status" data-bind="value: catalog_recurrings_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_recurrings -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_recurrings][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_recurrings][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_recurrings][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-filters" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_filters_status"><?php echo $entry_catalog_filters_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_filters_status" id="aqe_catalog_filters_status" data-bind="value: catalog_filters_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_filters -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_filters][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_filters][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_filters][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-attributes" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_attributes_status"><?php echo $entry_catalog_attributes_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_attributes_status" id="aqe_catalog_attributes_status" data-bind="value: catalog_attributes_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_attributes -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_attributes][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_attributes][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_attributes][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-attribute-groups" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_attribute_groups_status"><?php echo $entry_catalog_attribute_groups_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_attribute_groups_status" id="aqe_catalog_attribute_groups_status" data-bind="value: catalog_attribute_groups_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_attribute_groups -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_attribute_groups][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_attribute_groups][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_attribute_groups][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-options" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_options_status"><?php echo $entry_catalog_options_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_options_status" id="aqe_catalog_options_status" data-bind="value: catalog_options_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_options -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_options][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_options][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_options][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-manufacturers" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_manufacturers_status"><?php echo $entry_catalog_manufacturers_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_manufacturers_status" id="aqe_catalog_manufacturers_status" data-bind="value: catalog_manufacturers_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_manufacturers -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_manufacturers][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_manufacturers][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_manufacturers][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-downloads" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_downloads_status"><?php echo $entry_catalog_downloads_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_downloads_status" id="aqe_catalog_downloads_status" data-bind="value: catalog_downloads_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_downloads -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_downloads][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_downloads][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_downloads][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-reviews" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_reviews_status"><?php echo $entry_catalog_reviews_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_reviews_status" id="aqe_catalog_reviews_status" data-bind="value: catalog_reviews_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_reviews -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_reviews][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_reviews][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_reviews][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-catalog-information" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_catalog_information_status"><?php echo $entry_catalog_information_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_catalog_information_status" id="aqe_catalog_information_status" data-bind="value: catalog_information_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: catalog_information -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_catalog_information][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_catalog_information][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_catalog_information][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
												</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="customer-settings">
									<div class="row">
										<div class="col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="active"><a href="#tab-customer-customers" role="tab" data-toggle="tab"><?php echo $tab_customers; ?></a></li>
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab-customer-customers" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_customer_customers_status"><?php echo $entry_customer_customers_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_customer_customers_status" id="aqe_customer_customers_status" data-bind="value: customer_customers_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: customer_customers -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_customer_customers][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_customer_customers][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_customer_customers][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
												</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="sales-settings">
									<div class="row">
										<div class="col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="active"><a href="#tab-sales-orders" role="tab" data-toggle="tab"><?php echo $tab_orders; ?></a></li>
												<li><a href="#tab-sales-returns" role="tab" data-toggle="tab"><?php echo $tab_returns; ?></a></li>
												<li><a href="#tab-sales-vouchers" role="tab" data-toggle="tab"><?php echo $tab_vouchers; ?></a></li>
												<li><a href="#tab-sales-voucher-themes" role="tab" data-toggle="tab"><?php echo $tab_voucher_themes; ?></a></li>
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab-sales-orders" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_orders_status"><?php echo $entry_sales_orders_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_sales_orders_status" id="aqe_sales_orders_status" data-bind="value: sales_orders_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: sales_orders -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_sales_orders][' + column +']'}" type="hidden" class="column-index" /><input data-bind="value: 1, attr: {name:'display[aqe_sales_orders][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_sales_orders][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_orders_notify_customer0"><?php echo $entry_notify_customer; ?></label>
																<div class="col-sm-9 col-md-10">
																	<label class="radio-inline">
																		<input type="radio" name="aqe_sales_orders_notify_customer" id="aqe_sales_orders_notify_customer1" value="1" data-bind="checked: sales_orders_notify_customer"> <?php echo $text_yes; ?>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="aqe_sales_orders_notify_customer" id="aqe_sales_orders_notify_customer0" value="0" data-bind="checked: sales_orders_notify_customer"> <?php echo $text_no; ?>
																	</label>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-sales-returns" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_returns_status"><?php echo $entry_sales_returns_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_sales_returns_status" id="aqe_sales_returns_status" data-bind="value: sales_returns_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: sales_returns -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_sales_returns][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_sales_returns][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_sales_returns][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_returns_notify_customer0"><?php echo $entry_notify_customer; ?></label>
																<div class="col-sm-9 col-md-10">
																	<label class="radio-inline">
																		<input type="radio" name="aqe_sales_returns_notify_customer" id="aqe_sales_returns_notify_customer1" value="1" data-bind="checked: sales_returns_notify_customer"> <?php echo $text_yes; ?>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="aqe_sales_returns_notify_customer" id="aqe_sales_returns_notify_customer0" value="0" data-bind="checked: sales_returns_notify_customer"> <?php echo $text_no; ?>
																	</label>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-sales-vouchers" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_vouchers_status"><?php echo $entry_sales_vouchers_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_sales_vouchers_status" id="aqe_sales_vouchers_status" data-bind="value: sales_vouchers_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: sales_vouchers -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_sales_vouchers][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_sales_vouchers][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_sales_vouchers][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-sales-voucher-themes" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_sales_voucher_themes_status"><?php echo $entry_sales_voucher_themes_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_sales_voucher_themes_status" id="aqe_sales_voucher_themes_status" data-bind="value: sales_voucher_themes_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: sales_voucher_themes -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_sales_voucher_themes][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_sales_voucher_themes][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_sales_voucher_themes][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
												</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="marketing-settings">
									<div class="row">
										<div class="col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="active"><a href="#tab-marketing-campaigns" role="tab" data-toggle="tab"><?php echo $tab_campaigns; ?></a></li>
												<li><a href="#tab-marketing-affiliates" role="tab" data-toggle="tab"><?php echo $tab_affiliates; ?></a></li>
												<li><a href="#tab-marketing-coupons" role="tab" data-toggle="tab"><?php echo $tab_coupons; ?></a></li>
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab-marketing-campaigns" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_marketing_campaigns_status"><?php echo $entry_marketing_campaigns_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_marketing_campaigns_status" id="aqe_marketing_campaigns_status" data-bind="value: marketing_campaigns_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: marketing_campaigns -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_marketing_campaigns][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_marketing_campaigns][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_marketing_campaigns][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-marketing-affiliates" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_marketing_affiliates_status"><?php echo $entry_marketing_affiliates_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_marketing_affiliates_status" id="aqe_marketing_affiliates_status" data-bind="value: marketing_affiliates_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: marketing_affiliates -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_marketing_affiliates][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_marketing_affiliates][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_marketing_affiliates][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="tab-pane fade" id="tab-marketing-coupons" role="tab">
														<fieldset>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label" for="aqe_marketing_coupons_status"><?php echo $entry_marketing_coupons_status; ?></label>
																<div class="col-sm-2 fc-auto-width">
																	<select name="aqe_marketing_coupons_status" id="aqe_marketing_coupons_status" data-bind="value: marketing_coupons_status" class="form-control">
																		<option value="1"><?php echo $text_enabled; ?></option>
																		<option value="0"><?php echo $text_disabled; ?></option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 col-md-2 control-label"><span data-toggle="tooltip" data-title="<?php echo $help_columns; ?>" data-container="body"><?php echo $entry_fields; ?></span></label>
																<div class="col-sm-6 col-md-5 col-lg-4">
																	<table class="table table-hover table-condensed page-columns sortable">
																		<thead>
																			<tr>
																				<th>#</th>
																				<th><?php echo $text_column_name; ?></th>
																				<th class="text-center"><?php echo $text_display; ?></th>
																				<th class="text-center"><?php echo $text_editable; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<!-- ko foreach: marketing_coupons -->
																			<tr  data-bind="attr: {'data-id': column}, css: {'danger': !visible()}">
																				<td><i class="fa fa-arrows-v cur-crosshair"></i></td>
																				<td><!-- ko text: name --><!-- /ko --><input data-bind="value: index, attr: {name:'index[aqe_marketing_coupons][' + column +']'}" type="hidden" class="column-index" /></td>
																				<td class="text-center"><input data-bind="checked: visible, attr: {name:'display[aqe_marketing_coupons][' + column +']'}" type="checkbox" class="column-display" /></td>
																				<td class="text-center"><input data-bind="checked: editable, attr: {name:'qe_status[aqe_marketing_coupons][' + column +']'}, disable: !quick_editable" type="checkbox" /></td>
																			</tr>
																			<!-- /ko -->
																		</tbody>
																	</table>
																</div>
															</div>
														</fieldset>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="ext-support">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#support-navbar-collapse">
									<span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<h3 class="panel-title"><i class="fa fa-support fa-fw"></i> <?php echo $tab_support; ?></h3>
							</div>
							<div class="collapse navbar-collapse" id="support-navbar-collapse">
								<ul class="nav navbar-nav">
									<li class="active"><a href="#general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
									<li><a href="#faq" data-toggle="tab" title="<?php echo $text_faq; ?>"><?php echo $tab_faq; ?></a></li>
									<li><a href="#services" data-toggle="tab"><?php echo $tab_services; ?></a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane active" id="general">
									<div class="row">
										<div class="col-sm-12">
											<h3>Getting support</h3>
											<p>I consider support a priority of mine, so if you need any help with your purchase you can contact me in one of the following ways:</p>
											<ul>
												<li>Send an email to <a href="mailto:<?php echo $ext_support_email; ?>?subject='<?php echo $text_support_subject; ?>'"><?php echo $ext_support_email; ?></a></li>
												<li>Post in the <a href="<?php echo $ext_support_forum; ?>" target="_blank">extension forum thread</a> or send me a <a href="http://forum.opencart.com/ucp.php?i=pm&mode=compose&u=17771">private message</a></li>
												<!--li><a href="<?php echo $ext_store_url; ?>" target="_blank">Leave a comment</a> in the extension store comments section</li-->
											</ul>
											<p>I usually reply within a few hours, but can take up to 36 hours.</p>
											<p>Please note that all support is free if it is an issue with the product. Only issues due conflicts with other third party extensions/modules or custom front end theme are the exception to free support. Resolving such conflicts, customizing the extension or doing additional bespoke work will be provided with the hourly rate of <span id="hourly_rate">USD 50 / EUR 40</span>.</p>

											<h4>Things to note when asking for help</h4>
											<p>Please describe your problem in as much detail as possible. When contacting, please provide the following information:</p>
											<ul>
												<li>The OpenCart version you are using. <small>This can be found at the bottom of any admin page.</small></li>
												<li>The extension name and version. <small>You can find this information under the About tab.</small></li>
												<li>If you got any error messages, please include them in the message.</li>
												<li>In case the error message is generated by a vQmod cached file, please also attach that file.</li>
											</ul>
											<p>Any additional information that you can provide about the issue is greatly appreciated and will make problem solving much faster.</p>

											<h3 class="page-header">Happy with <?php echo $ext_name; ?>?</h3>
											<p>I would appreciate it very much if you could <a href="<?php echo $ext_store_url; ?>" target="_blank">rate the extension</a> once you've had a chance to try it out. Why not tell everybody how great this extension is by <a href="<?php echo $ext_store_url; ?>" target="_blank">leaving a comment</a> as well.</p>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="alert alert-info">
												<p><?php echo $text_other_extensions; ?></p>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="faq">
									<h3><?php echo $text_faq; ?></h3>
									<ul class="media-list" id="faqs">
										<li class="media">
											<div class="pull-left">
												<i class="fa fa-question-circle fa-4x media-object"></i>
											</div>
											<div class="media-body">
												<h4 class="media-heading">How to translate the extension to another language?</h4>

												<p class="short-answer">Copy the extension language files (see full answer) to your language folder and translate the strings inside the copied files.</p>

												<button type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#translation" data-parent="#faqs">Show the full answer</button>
												<div class="collapse full-answer" id="translation">
													<ol>
														<li>
															<p><strong>Copy</strong> the following language files <strong>to YOUR_LANGUAGE folder</strong> under the appropriate location as shown below:</p>
															<div class="btm-mgn">
																<em class="text-muted"><small>FROM:</small></em>
																<ul class="list-unstyled">
																	<li>admin/language/english/catalog/attribute_ext.php</li>
																	<li>admin/language/english/catalog/attribute_group_ext.php</li>
																	<li>admin/language/english/catalog/category_ext.php</li>
																	<li>admin/language/english/catalog/download_ext.php</li>
																	<li>admin/language/english/catalog/filter_ext.php</li>
																	<li>admin/language/english/catalog/information_ext.php</li>
																	<li>admin/language/english/catalog/manufacturer_ext.php</li>
																	<li>admin/language/english/catalog/option_ext.php</li>
																	<li>admin/language/english/catalog/product_ext.php</li>
																	<li>admin/language/english/catalog/qe_general.php</li>
																	<li>admin/language/english/catalog/recurring_ext.php</li>
																	<li>admin/language/english/catalog/review_ext.php</li>
																	<li>admin/language/english/marketing/affiliate_ext.php</li>
																	<li>admin/language/english/marketing/coupon_ext.php</li>
																	<li>admin/language/english/marketing/marketing_ext.php</li>
																	<li>admin/language/english/marketing/qe_general.php</li>
																	<li>admin/language/english/module/admin_quick_edit.php</li>
																	<li>admin/language/english/customer/customer_ext.php</li>
																	<li>admin/language/english/sale/qe_general.php</li>
																	<li>admin/language/english/sale/return_ext.php</li>
																	<li>admin/language/english/sale/voucher_ext.php</li>
																	<li>admin/language/english/sale/voucher_theme_ext.php</li>
																</ul>
																<em class="text-muted"><small>TO:</small></em>
																<ul class="list-unstyled">
																	<li>admin/language/YOUR_LANGUAGE/catalog/attribute_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/attribute_group_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/category_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/download_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/filter_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/information_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/manufacturer_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/option_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/product_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/qe_general.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/recurring_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/catalog/review_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/marketing/affiliate_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/marketing/coupon_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/marketing/marketing_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/marketing/qe_general.php</li>
																	<li>admin/language/YOUR_LANGUAGE/module/admin_quick_edit.php</li>
																	<li>admin/language/YOUR_LANGUAGE/customer/customer_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/sale/qe_general.php</li>
																	<li>admin/language/YOUR_LANGUAGE/sale/return_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/sale/voucher_ext.php</li>
																	<li>admin/language/YOUR_LANGUAGE/sale/voucher_theme_ext.php</li>
																</ul>
															</div>
														</li>

														<li>
															<p><strong>Open</strong> each of the copied <strong>language files</strong> with a text editor such as <a href="http://www.sublimetext.com/">Sublime Text</a> or <a href="http://notepad-plus-plus.org/">Notepad++</a> and <strong>make the required translations</strong>. You can also leave the files in English.</p>
															<p><span class="label label-info">Note</span> You only need to translate the parts that are to the right of the equal sign.</p>
														</li>

													</ol>

												</div>
											</div>
										</li>
										<li class="media">
											<div class="pull-left">
												<i class="fa fa-question-circle fa-4x media-object"></i>
											</div>
											<div class="media-body">
												<h4 class="media-heading">How to upgrade the extension?</h4>
												<p class="short-answer">Back up your system, disable the extension, overwrite the current extension files with new ones and click Upgrade on the extension settings page. After upgrade is complete enable the extension again.</p>

												<button type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#upgrade" data-parent="#faqs">Show the full answer</button>
												<div class="collapse full-answer" id="upgrade">
													<ol>
														<li>
															<p><strong>Back up your system</strong> before making any upgrades or changes.</p>
															<p><span class="label label-info">Note</span> Although <?php echo $ext_name; ?> does not overwrite any OpenCart core files, it is always a good practice to create a system backup before making any changes to the system.</p>
															<p><span class="label label-danger">Important</span> If the previous <?php echo $ext_name; ?> extension is a VQMod version then delete the vqmod/xml/admin_quick_edit.xml file and clear VQMod cache.</p>
														</li>
														<li><strong>Disable</strong> <?php echo $ext_name; ?> <strong>extension</strong> on the module settings page (<em>Extensions > Modules > <?php echo $ext_name; ?></em>) by changing <em>Extension status</em> setting to "Disabled".</li>

														<li>
															<p><strong>Upload</strong> the <strong>extension archive</strong> <em>AdminQuickEditPRO-x.x.x.ocmod.zip</em> using the <a href="<?php echo $extension_installer; ?>" target="_blank">Extension Installer</a>.</p>
															<p><span class="label label-info">Note</span> Do not worry, no OpenCart core files will be replaced! Only the previously installed <?php echo $ext_name; ?> files will be overwritten.</p>
															<p><span class="label label-danger">Important</span> If you have done custom modifications to the extension then back up the modified files and re-apply the modifications after upgrade. To see which files have changed, please take a look at the <a href="#" class="external-tab-link" data-target="#changelog,#about-ext">Changelog</a>.</p>
														</li>

														<li>
															<p><strong>Navigagte to</strong> the <strong>Modifications page</strong> <small>(<em>Extensions > Modifications</em>)</small> and <strong>rebuild the modification cache</strong> by clicking on the 'Refresh' button.</p>
														</li>

														<li>
															<p><strong>Open</strong> the <?php echo $ext_name; ?> <strong>module settings page</strong> <small>(<em>Extensions > Modules > <?php echo $ext_name; ?></em>)</small> and <strong>refresh the page</strong> by pressing <em>Ctrl + F5</em> twice to force the browser to update the css changes.</p>
														</li>

														<li><p>You should see a notice stating that new version of extension files have been found. <strong>Upgrade the extension</strong> by clicking on the 'Upgrade' button.</p></li>

														<li>After the extension has been successfully upgraded <strong>enable the extension</strong> by changing <em>Extension status</em> setting to "Enabled".</li>
													</ol>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="tab-pane" id="services">
									<h3>Premium Services<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?php echo $button_refresh; ?>" id="btn-refresh-services" data-loading-text="<i class='fa fa-refresh fa-spin'></i> <span class='visible-lg-inline visible-xs-inline'><?php echo $text_loading; ?></span>"><i class="fa fa-refresh"></i> <span class="visible-lg-inline visible-xs-inline"><?php echo $button_refresh; ?></span></button></h3>
									<div id="service-container">
										<p data-bind="visible: service_list_loading()">Loading service list ... <i class="fa fa-refresh fa-spin"></i></p>
										<p data-bind="visible: service_list_loaded() && services().length == 0">There are currently no available services for this extension.</p>
										<table class="table table-hover">
											<tbody data-bind="foreach: services">
												<tr class="srvc">
													<td>
														<h4 class="service" data-bind="html: name"></h4>
														<span class="help-block">
															<p class="description" data-bind="visible: description != '', html: description"></p>
															<p data-bind="visible: turnaround != ''"><strong>Turnaround time</strong>: <span class="turnaround" data-bind="html: turnaround"></span></p>
															<span class="hidden code" data-bind="html: code"></span>
														</span>
													</td>
													<td class="nowrap text-right top-pad"><span class="currency" data-bind="html: currency"></span> <span class="price" data-bind="html: price"></span></td>
													<td class="text-right"><button type="button" class="btn btn-sm btn-primary purchase"><i class="fa fa-shopping-cart"></i> Buy Now</button></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="about-ext">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#about-navbar-collapse">
									<span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<h3 class="panel-title"><i class="fa fa-info fa-fw"></i> <?php echo $tab_about; ?></h3>
							</div>
							<div class="collapse navbar-collapse" id="about-navbar-collapse">
								<ul class="nav navbar-nav">
									<li class="active"><a href="#ext-info" data-toggle="tab"><?php echo $tab_extension; ?></a></li>
									<li><a href="#changelog" data-toggle="tab"><?php echo $tab_changelog; ?></a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane active" id="ext-info">
									<div class="row">
										<div class="col-sm-12">
											<h3><?php echo $text_extension_information; ?></h3>

											<div class="form-group">
												<label class="col-sm-3 col-md-2 control-label"><?php echo $entry_extension_name; ?></label>
												<div class="col-sm-9 col-md-10">
													<p class="form-control-static"><?php echo $ext_name; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 col-md-2 control-label"><?php echo $entry_installed_version; ?></label>
												<div class="col-sm-9 col-md-10">
													<p class="form-control-static"><strong><?php echo $installed_version; ?></strong></p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 col-md-2 control-label"><?php echo $entry_extension_compatibility; ?></label>
												<div class="col-sm-9 col-md-10">
													<p class="form-control-static"><?php echo $ext_compatibility; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 col-md-2 control-label"><?php echo $entry_extension_store_url; ?></label>
												<div class="col-sm-9 col-md-10">
													<p class="form-control-static"><a href="<?php echo $ext_store_url; ?>" target="_blank"><?php echo htmlspecialchars($ext_store_url); ?></a></p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 col-md-2 control-label"><?php echo $entry_copyright_notice; ?></label>
												<div class="col-sm-9 col-md-10">
													<p class="form-control-static">&copy; 2011 - <?php echo date("Y"); ?> Romi Agar</p>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
													<p class="form-control-static"><a href="#legal_text" id="legal_notice" data-toggle="modal"><?php echo $text_terms; ?></a></p>
												</div>
											</div>

											<h3 class="page-header"><?php echo $text_license; ?></h3>
											<p><?php echo $text_license_text; ?></p>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="changelog">
									<div class="row">
										<div class="col-sm-12">
											<div class="release">
												<h3>Version 5.4.0 <small class="release-date text-muted">18 Mar 2016</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Meta Keyword &amp; Meta Description quick editing for Products, Categories and Informations</li>
														<li><em class="text-success">Fixed:</em> Default soring on Catalog -> Categories page</li>
														<li><em class="text-success">Fixed:</em> Order history quick editing</li>
														<li><em class="text-success">Fixed:</em> Category name quick editing in single language mode</li>
														<li><em class="text-success">Fixed:</em> Product filters quick editing UI glitch</li>
														<li><em class="text-success">Fixed:</em> Conflict with Product Downloads PRO extension files</li>
														<li><em class="text-success">Fixed:</em> Option values quick editing errors</li>
														<li><em class="text-success">Fixed:</em> Customer e-mail address validation</li>
														<li><em class="text-success">Fixed:</em> Support for OpenCart 2.2.0.0</li>
														<li><em class="text-info">Changed:</em> Product Downloads quick edit uses autocomplete</li>
														<li><em class="text-info">Changed:</em> Refactored extension structure</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/aqe/catalog.min.js</li>
														<li>admin/view/stylesheet/aqe/css/catalog.min.css</li>
														<li>admin/view/template/catalog/aqe/product_quick_form.tpl</li>
														<li>admin/view/template/catalog/aqe/quick_edit_form.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>admin/view/template/sale/aqe/quick_edit_form.tpl</li>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/controller/catalog/aqe/*</li>
														<li>admin/controller/customer/aqe/*</li>
														<li>admin/controller/marketing/aqe/*</li>
														<li>admin/controller/sale/aqe/*</li>
														<li>admin/language/en-gb/catalog/aqe/*</li>
														<li>admin/language/en-gb/customer/aqe/*</li>
														<li>admin/language/en-gb/marketing/aqe/*</li>
														<li>admin/language/en-gb/sale/aqe/*</li>
														<li>admin/language/english/catalog/aqe/*</li>
														<li>admin/language/english/customer/aqe/*</li>
														<li>admin/language/english/marketing/aqe/*</li>
														<li>admin/language/english/sale/aqe/*</li>
														<li>admin/model/catalog/aqe/*</li>
														<li>admin/model/customer/aqe/*</li>
														<li>admin/model/marketing/aqe/*</li>
														<li>admin/model/sale/aqe/*</li>
														<li>admin/view/template/catalog/aqe/*</li>
														<li>admin/view/template/customer/aqe/*</li>
														<li>admin/view/template/marketing/aqe/*</li>
														<li>admin/view/template/sale/aqe/*</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>admin/controller/catalog/*_ext.php</li>
														<li>admin/controller/customer/*_ext.php</li>
														<li>admin/controller/marketing/*_ext.php</li>
														<li>admin/controller/sale/*_ext.php</li>
														<li>admin/language/english/catalog/*_ext.php</li>
														<li>admin/language/english/catalog/qe_general.php</li>
														<li>admin/language/english/customer/*_ext.php</li>
														<li>admin/language/english/customer/qe_general.php</li>
														<li>admin/language/english/marketing/*_ext.php</li>
														<li>admin/language/english/marketing/qe_general.php</li>
														<li>admin/language/english/sale/*_ext.php</li>
														<li>admin/language/english/sale/qe_general.php</li>
														<li>admin/model/catalog/*_ext.php</li>
														<li>admin/model/customer/*_ext.php</li>
														<li>admin/model/marketing/*_ext.php</li>
														<li>admin/model/sale/*_ext.php</li>
														<li>admin/view/template/catalog/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/customer/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/marketing/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/sale/aqe/*_ext_list.tpl</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.3.0 <small class="release-date text-muted">09 Nov 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Meta Tag Title quick editing for Products, Categories and Informations</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/category_ext.php</li>
														<li>admin/controller/catalog/information_ext.php</li>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/category_ext.php</li>
														<li>admin/model/catalog/information_ext.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/template/catalog/aqe/product_quick_form.tpl</li>
														<li>admin/view/template/catalog/aqe/quick_edit_form.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.2.0 <small class="release-date text-muted">30 Aug 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Multilingual SEO keyword single language editing</li>
														<li><em class="text-success">Fixed:</em> Missing language strings on Catalog -> Products page</li>
														<li><em class="text-success">Fixed:</em> Default soring on Catalog -> Categories page</li>
														<li><em class="text-info">Changed:</em> Some minor refactoring</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/category_ext.php</li>
														<li>admin/view/template/catalog/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/catalog/aqe/category_ext.tpl</li>
														<li>admin/view/template/catalog/aqe/information_ext.tpl</li>
														<li>admin/view/template/catalog/aqe/manufacturer_ext.tpl</li>
														<li>admin/view/template/catalog/aqe/product_ext.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.1.2 <small class="release-date text-muted">15 June 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Multilingual popup quick edit works only once per edit</li>
														<li><em class="text-primary">New:</em> Popup modal focuses on first input</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/aqe/catalog.min.js</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.1.1 <small class="release-date text-muted">27 May 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> VQMod not installed error is displayed without a reason</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.1.0 <small class="release-date text-muted">25 May 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> SEO links to front end product pages</li>
														<li><em class="text-primary">New:</em> Fully OCMOD compatible</li>
														<li><em class="text-success">Fixed:</em> Multi-store 'view in store' links</li>
														<li><em class="text-info">Changed:</em> Minor UI fixes</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/*_ext.php</li>
														<li>admin/controller/marketing/*_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/controller/sale/*_ext.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/aqe/*.js</li>
														<li>admin/view/stylesheet/aqe/css/*.css</li>
														<li>admin/view/template/catalog/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/marketing/aqe/*_ext_list.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>admin/view/template/sale/aqe/*_ext_list.tpl</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>system/admin_quick_edit.ocmod.xml</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.0.3 <small class="release-date text-muted">30 Mar 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Compatibility with OpenCart 2.0.2.0</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/marketing/affiliate_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/controller/customer/customer_ext.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.0.2 <small class="release-date text-muted">19 Mar 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Compatibility with PHP &lt; 5.4</li>
														<li><em class="text-success">Fixed:</em> VQMod error on category page</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/filter_ext.php</li>
														<li>admin/model/catalog/option_ext.php</li>
														<li>admin/view/template/catalog/aqe/category_ext_list.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.0.1 <small class="release-date text-muted">17 Mar 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Filter lost when navigating to standard edit page</li>
														<li><em class="text-success">Fixed:</em> Catalog -> Categories filtering by filters</li>
														<li><em class="text-success">Fixed:</em> Catalog -> Recurring Profiles filtering by trial status</li>
														<li><em class="text-success">Fixed:</em> Default sorting order on some pages</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/*_ext.php</li>
														<li>admin/controller/marketing/*_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/controller/sale/*_ext.php</li>
														<li>admin/model/catalog/category_ext.php</li>
														<li>admin/model/catalog/recurring_ext.php</li>
														<li>admin/model/catalog/review_ext.php</li>
														<li>admin/model/marketing/coupon_ext.php</li>
														<li>admin/view/template/catalog/aqe/category_ext_list.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

												</blockquote>
											</div>

											<div class="release">
												<h3>Version 5.0.0 <small class="release-date text-muted">15 Mar 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Marketing -> Marketing page quick editing</li>
														<li><em class="text-primary">New:</em> Catalog -> Categories page description quick editing</li>
														<li><em class="text-primary">New:</em> Catalog -> Information page description quick editing</li>
														<li><em class="text-info">Changed:</em> Refactored codebase</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/template/catalog/aqe/*.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>admin/view/template/sale/aqe/*.tpl</li>
														<li>system/helper/aqe.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/controller/catalog/*_ext.php</li>
														<li>admin/controller/marketing/*_ext.php</li>
														<li>admin/controller/sale/*_ext.php</li>
														<li>admin/language/english/catalog/*_ext.php</li>
														<li>admin/language/english/catalog/qe_general.php</li>
														<li>admin/language/english/marketing/*_ext.php</li>
														<li>admin/language/english/marketing/qe_general.php</li>
														<li>admin/language/english/sale/*_ext.php</li>
														<li>admin/language/english/sale/qe_general.php</li>
														<li>admin/model/catalog/*_ext.php</li>
														<li>admin/model/marketing/*_ext.php</li>
														<li>admin/model/sale/*_ext.php</li>
														<li>admin/view/javascript/aqe/catalog.min.js</li>
														<li>admin/view/javascript/aqe/module.min.js</li>
														<li>admin/view/stylesheet/aqe/css/catalog.min.css</li>
														<li>admin/view/stylesheet/aqe/css/module.min.css</li>
														<li>admin/view/template/marketing/aqe/*.tpl</li>
														<li>admin/view/template/sale/aqe/quick_edit_form.tpl</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>admin/view/javascript/aqe/catalog.custom.min.js</li>
														<li>admin/view/javascript/aqe/jquery.jeditable.min.js</li>
														<li>admin/view/javascript/aqe/module.custom.min.js</li>
														<li>admin/view/stylesheet/aqe/css/catalog.custom.min.css</li>
														<li>admin/view/stylesheet/aqe/css/module.custom.min.css</li>
														<li>admin/view/stylesheet/aqe/fonts/*</li>
														<li>admin/view/template/catalog/aqe/profile_ext_list.tpl</li>
														<li>admin/view/template/sale/aqe/affiliate_ext_list.tpl</li>
														<li>admin/view/template/sale/aqe/coupon_ext_list.tpl</li>
														<li>admin/view/template/sale/aqe/order_ext_list.tpl</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 4.0.2 <small class="release-date text-muted">28 Feb 2015</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Catalog -> Category page multilingual SEO keyword quick editing</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 4.0.1 <small class="release-date text-muted">23 Sep 2014</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Product option batch editing</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 4.0.0 <small class="release-date text-muted">07 Sep 2014</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Batch editing on all pages</li>
														<li><em class="text-primary">New:</em> Basic support for multilingual SEO keywords</li>
														<li><em class="text-primary">New:</em> Revamped module admin interface</li>
														<li><em class="text-success">Fixed:</em> SEO results are only included when SEO Keyword column is displayed</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/view/javascript/aqe/*</li>
														<li>admin/view/stylesheet/aqe/*</li>
														<li>system/helper/aqe.php</li>
														<li>admin/view/template/catalog/aqe/*</li>
														<li>admin/view/template/sale/aqe/*</li>
														<li>system/helper/aqe.php</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>admin/view/image/aqe-pro/*</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/javascript/jquery.jeditable.js</li>
														<li>admin/view/javascript/ui/themes/smoothness/images/*</li>
														<li>admin/view/static/bull5i_aqe_pro_extension_help.htm</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/catalog/product_list_ext.tpl</li>
														<li>admin/view/template/catalog/product_quick_form.tpl</li>
														<li>admin/view/template/catalog/profile_list_ext.tpl</li>
														<li>admin/view/template/catalog/quick_edit_form.tpl</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.5.4 <small class="release-date text-muted">10 Feb 2014</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> OpenBay update on quantity change</li>
														<li><em class="text-info">Changed:</em> Improved Apply button on module settings page</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.5.3 <small class="release-date text-muted">07 Feb 2014</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Array to string conversion notice on Sales -> Orders page</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.5.2 <small class="release-date text-muted">18 Dec 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Catalog -> Category page displaying incorrect values</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.5.1 <small class="release-date text-muted">11 Dec 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Active special price calculation error</li>
														<li><em class="text-success">Fixed:</em> Link to manufacturer page in store front</li>
														<li><em class="text-success">Fixed:</em> Filter sort order on orders page</li>
														<li><em class="text-success">Fixed:</em> A minor JS bug</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/template/catalog/product_list_ext.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.5.0 <small class="release-date text-muted">16 Oct 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Product filtering based on special price status (active, expired or future special price)</li>
														<li><em class="text-primary">New:</em> 'Date Modified' column to Catalog -> Product page</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/catalog/product_list_ext.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.6 <small class="release-date text-muted">22 Sep 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Filtering by Customer Group on Customer page</li>
														<li><em class="text-success">Fixed:</em> Date value parsing in various places</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.5 <small class="release-date text-muted">24 Jul 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Undefined 'filter_return_action' index PHP notice in admin/model/sale/return.phps</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.4 <small class="release-date text-muted">08 Jul 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Undefined 'name' index PHP notice when product name was not displayed</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.3 <small class="release-date text-muted">16 Apr 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> EAN, JAN, MPN, ISBN quick editing</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.2 <small class="release-date text-muted">08 Apr 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Some missing SQL table prefixes</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.1 <small class="release-date text-muted">27 Mar 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Product attribute quick edit was not displaying attribute name</li>
														<li><em class="text-success">Fixed:</em> A spelling typo</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.4.0 <small class="release-date text-muted">31 Jan 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Filters quick edit</li>
														<li><em class="text-info">Changed:</em> Improved quick edit feedback</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/javascript/jquery.jeditable.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/catalog/product_list_ext.tpl</li>
														<li>admin/view/template/catalog/product_quick_form.tpl</li>
														<li>admin/view/template/catalog/quick_edit_form.tpl</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/view/static/bull5i_aqe_pro_extension_help.htm</li>
														<li>admin/view/static/bull5i_aqe_pro_extension_terms.htm</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>admin/view/static/rmg_extension_help.htm</li>
														<li>admin/view/static/rmg_extension_terms.htm</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.3.2 <small class="release-date text-muted">14 Jan 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Product copy &amp; delete errors</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.3.1 <small class="release-date text-muted">07 Jan 2013</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Product cache not cleared</li>
														<li><em class="text-info">Changed:</em> Improved CSS &amp; JS interoperability</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.3.0 <small class="release-date text-muted">15 Oct 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> HTML documentation</li>
														<li><em class="text-primary">New:</em> Made product descriptions, tags, categories, stores, downloads, attributes, discounts, additional images, options, specials and related products quick editable on Catalog -> Product page</li>
														<li><em class="text-primary">New:</em> AceShop support</li>
														<li><em class="text-success">Fixed:</em> Conflict with Shoppica 2 admin panel</li>
														<li><em class="text-info">Changed:</em> Few more data integrity validations</li>
														<li><em class="text-info">Changed:</em> Improved interval filtering</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/controller/catalog/product_ext.php</li>
														<li>admin/model/catalog/product_ext.php</li>
														<li>admin/view/image/aqe-pro/aqe_image_loading.gif</li>
														<li>admin/view/image/aqe-pro/aqe_loading.gif</li>
														<li>admin/view/image/aqe-pro/glyphicons-halflings.png</li>
														<li>admin/view/javascript/jquery.jeditable.js</li>
														<li>admin/view/javascript/ui/themes/smoothness/images/calendar.gif</li>
														<li>admin/view/javascript/ui/themes/smoothness/images/ui-bg_glass_75_e6e6e6_1x400.png</li>
														<li>admin/view/javascript/ui/themes/smoothness/images/ui-icons_888888_256x240.png</li>
														<li>admin/view/template/catalog/product_list_ext.tpl</li>
														<li>admin/view/template/catalog/product_quick_form.tpl</li>
														<li>admin/view/template/catalog/quick_edit_form.tpl</li>
													</ul>

													<h4><i class="fa fa-minus text-danger"></i> Files removed:</h4>

													<ul>
														<li>admin/view/image/aqe_image_loading.gif</li>
														<li>admin/view/image/aqe_loading.gif</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>admin/view/javascript/jquery/ui/themes/smoothness/images/calendar.gif</li>
														<li>admin/view/javascript/jquery/ui/themes/smoothness/images/ui-bg_glass_75_e6e6e6_1x400.png</li>
														<li>admin/view/javascript/jquery/ui/themes/smoothness/images/ui-icons_888888_256x240.png</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.2.2 <small class="release-date text-muted">11 Jul 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Sales -> Returns page undefined variable notices</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.2.1 <small class="release-date text-muted">27 Jun 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Product image update validation error</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.2.0 <small class="release-date text-muted">06 Jun 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Image quick editing</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/view/image/aqe_image_loading.gif</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.1.0 <small class="release-date text-muted">05 Jun 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Bottom quick editable field to Catalog -> Information list page (for OC 1.5.3.x)</li>
														<li><em class="text-primary">New:</em> Filename column to Download list page and made Mask quick editable (for OC 1.5.3.x)</li>
														<li><em class="text-primary">New:</em> Option to choose between single and double click quick editing</li>
														<li><em class="text-success">Fixed:</em> Sales -> Affiliates page quick edit</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.0.1 <small class="release-date text-muted">14 May 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Undefined variable notices in the product/affiliate/customer/return edit pages</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 3.0.0 <small class="release-date text-muted">07 May 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Option to match filter string anywhere in the phrase (just like OC 1.4.9 used to)</li>
														<li><em class="text-primary">New:</em> Option to alter row colours and hover highlighting (pure CSS3)</li>
														<li><em class="text-primary">New:</em> Duplicate SEO keyword check</li>
														<li><em class="text-primary">New:</em> Quick editing for Returns, Affiliates, Vouchers and Voucher Themes</li>
														<li><em class="text-primary">New:</em> Links to the store front for products, categories, manufacturers and information (multistore support)</li>
														<li><em class="text-primary">New:</em> Interval filtering for numeric filters</li>
														<li><em class="text-success">Fixed:</em> Some additional filtering issues</li>
														<li><em class="text-success">Fixed:</em> Customer name quick editing</li>
														<li><em class="text-info">Changed:</em> Refactored the code &amp; fixed some minor OC bugs</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/view/image/aqe_loading.gif</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.3.2 <small class="release-date text-muted">26 Apr 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Sales -> Customers filtering issue</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.3.1 <small class="release-date text-muted">05 Apr 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-info">Changed:</em> Improved page load speed a bit by optimizing total count sql query</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.3.0 <small class="release-date text-muted">09 Mar 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Tax Class, Minimum Quantity, Subtract Stock, Out of Stock Status, Requires Shipping, Date Available, Length, Width, Height, Length Class, Weight Class and Points quick editing fields to Catalog -> Product page</li>
														<li><em class="text-info">Changed:</em> Updated extension help section</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/admin.quick.edit.pro.js</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>admin/view/static/rmg_extension_help.htm</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.2.0 <small class="release-date text-muted">16 Feb 2012</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Extension and support info on module settings page</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>

													<h4><i class="fa fa-plus text-success"></i> Files added:</h4>

													<ul>
														<li>admin/view/image/aqe-pro/extension_logo.png</li>
														<li>admin/view/static/rmg_extension_help.htm</li>
														<li>admin/view/static/rmg_extension_terms.htm</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.1.1 <small class="release-date text-muted">05 Dec 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-info">Changed:</em> Refactored the code a bit (functionality unchanged)</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.1.0 <small class="release-date text-muted">04 Dec 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Option to switch to single (admin default) language editing for names</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.0.3 <small class="release-date text-muted">29 Nov 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Single quote escaping problem</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.0.2 <small class="release-date text-muted">23 Nov 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Filtering of products without a category</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.0.1 <small class="release-date text-muted">22 Nov 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-success">Fixed:</em> Filtering for Catalog->Products if Status column was not displayed</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 2.0.0 <small class="release-date text-muted">10 Nov 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li><em class="text-primary">New:</em> Quick edit capabilities on Sales->Orders, Sales->Customers and Sales->Coupons pages</li>
														<li><em class="text-info">Changed:</em> Improved quick editing user experience</li>
													</ul>

													<h4><i class="fa fa-pencil text-primary"></i> Files changed:</h4>

													<ul>
														<li>admin/controller/module/admin_quick_edit.php</li>
														<li>admin/language/english/module/admin_quick_edit.php</li>
														<li>admin/view/javascript/jquery/jquery.jeditable.js</li>
														<li>admin/view/stylesheet/aqe_style.css</li>
														<li>admin/view/template/module/admin_quick_edit.tpl</li>
														<li>vqmod/xml/admin_quick_edit.xml</li>
													</ul>
												</blockquote>
											</div>

											<div class="release">
												<h3>Version 1.0.0 <small class="release-date text-muted">03 Nov 2011</small></h3>

												<blockquote>
													<ul class="list-unstyled">
														<li>Initial release</li>
													</ul>
												</blockquote>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
!function(e,a,t){var s,r=<?php echo json_encode($errors); ?>,o=<?php echo json_encode($aqe_catalog_categories); ?>,n=<?php echo json_encode($aqe_catalog_products); ?>,i=<?php echo json_encode($aqe_catalog_products_actions); ?>,h=<?php echo json_encode($aqe_catalog_recurrings); ?>,_=<?php echo json_encode($aqe_catalog_filters); ?>,l=<?php echo json_encode($aqe_catalog_attributes); ?>,p=<?php echo json_encode($aqe_catalog_attribute_groups); ?>,c=<?php echo json_encode($aqe_catalog_options); ?>,d=<?php echo json_encode($aqe_catalog_manufacturers); ?>,u=<?php echo json_encode($aqe_catalog_downloads); ?>,b=<?php echo json_encode($aqe_catalog_reviews); ?>,w=<?php echo json_encode($aqe_catalog_information); ?>,y=<?php echo json_encode($aqe_sales_orders); ?>,g=<?php echo json_encode($aqe_sales_returns); ?>,m=<?php echo json_encode($aqe_customer_customers); ?>,v=<?php echo json_encode($aqe_sales_vouchers); ?>,k=<?php echo json_encode($aqe_sales_voucher_themes); ?>,O=<?php echo json_encode($aqe_marketing_campaigns); ?>,P=<?php echo json_encode($aqe_marketing_affiliates); ?>,q=<?php echo json_encode($aqe_marketing_coupons); ?>;e.texts=a.extend({},e.texts,{error_ajax_request:"<?php echo addslashes($error_ajax_request); ?>",error_image_width:"<?php echo addslashes($error_image_width); ?>",error_image_height:"<?php echo addslashes($error_image_height); ?>"}),a(".sortable").sortable({containerSelector:"table",itemPath:"> tbody",itemSelector:"tr",placeholder:'<tr class="placeholder"/>',distance:5,onDragStart:function(e){e.children().each(function(){a(this).width(a(this).width())}),e.addClass("dragged"),a("body").addClass("dragging")},onDrag:function(e,a){a.left=0,e.css(a)},onDrop:function(e,t){e.children().each(function(){a(this).removeAttr("style")}),e.removeClass("dragged").removeAttr("style"),a("body").removeClass("dragging"),a("tbody tr",a(t.el[0])).each(function(e){var a=ko.dataFor(this);a.index(e)})}}),e.load_service_list=function(e){var e=e!==t?1*e:0,r=a.Deferred();return s.service_list_loaded()&&!e||s.service_list_loading()?r.reject():(s.service_list_loading(!0),a.when(a.ajax({url:"<?php echo $services; ?>",data:{force:e},dataType:"json"})).then(function(e){s.service_list_loaded(!0),s.service_list_loading(!1),s.clearServices(),e.services&&a.each(e.services,function(e,a){var t=a.code,r=a.name,o=a.description||"",n=a.currency,i=a.price,h=a.turnaround;s.addService(t,r,o,n,i,h)}),e.rate&&a("#hourly_rate").html(e.rate),r.resolve()},function(e,a,t){s.service_list_loaded(!0),s.service_list_loading(!1),r.reject(),window.console&&window.console.log&&window.console.log("Failed to load services list: "+t)})),r.promise()};var f=function(e){isNaN(parseInt(e))||parseInt(e)<0?(this.target.hasError(!0),this.target.errorMsg(this.message)):(this.target.hasError(!1),this.target.errorMsg(""))},x=function(e,a,t,s,r,o){this.code=e,this.name=a,this.description=t,this.currency=s,this.price=r,this.turnaround=o},$=function(e,a,t,s,r,o){this.column=e,this.index=ko.observable(a),this.name=t,this.editable=ko.observable(s),this.visible=ko.observable(r),this.quick_editable=o},j=function(){var t=this;this.status=ko.observable("<?php echo $aqe_status; ?>"),this.match_anywhere=ko.observable("<?php echo $aqe_match_anywhere; ?>"),this.alternate_row_colour=ko.observable("<?php echo $aqe_alternate_row_colour; ?>"),this.row_hover_highlighting=ko.observable("<?php echo $aqe_row_hover_highlighting; ?>"),this.highlight_status=ko.observable("<?php echo $aqe_highlight_status; ?>"),this.interval_filter=ko.observable("<?php echo $aqe_interval_filter; ?>"),this.batch_edit=ko.observable("<?php echo $aqe_batch_edit; ?>"),this.quick_edit_on=ko.observable("<?php echo $aqe_quick_edit_on; ?>"),this.list_view_image_width=ko.observable("<?php echo (int)$aqe_list_view_image_width; ?>").extend({numeric:{precision:0,context:t},validate:{message:e.texts.error_image_width,context:t,method:f}}),this.list_view_image_height=ko.observable("<?php echo (int)$aqe_list_view_image_height; ?>").extend({numeric:{precision:0,context:t},validate:{message:e.texts.error_image_height,context:t,method:f}}),this.single_language_editing=ko.observable("<?php echo $aqe_single_language_editing; ?>"),this.general_errors=ko.computed(function(){return t.list_view_image_width.hasError()||t.list_view_image_height.hasError()}),this.catalog_categories_status=ko.observable("<?php echo $aqe_catalog_categories_status; ?>"),this.catalog_categories=ko.observableArray(a.map(o,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_products_status=ko.observable("<?php echo $aqe_catalog_products_status; ?>"),this.catalog_products=ko.observableArray(a.map(n,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_products_actions=ko.observableArray(a.map(i,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_products_filter_sub_category=ko.observable("<?php echo $aqe_catalog_products_filter_sub_category; ?>"),this.catalog_recurrings_status=ko.observable("<?php echo $aqe_catalog_recurrings_status; ?>"),this.catalog_recurrings=ko.observableArray(a.map(h,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_filters_status=ko.observable("<?php echo $aqe_catalog_filters_status; ?>"),this.catalog_filters=ko.observableArray(a.map(_,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_attributes_status=ko.observable("<?php echo $aqe_catalog_attributes_status; ?>"),this.catalog_attributes=ko.observableArray(a.map(l,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_attribute_groups_status=ko.observable("<?php echo $aqe_catalog_attribute_groups_status; ?>"),this.catalog_attribute_groups=ko.observableArray(a.map(p,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_options_status=ko.observable("<?php echo $aqe_catalog_options_status; ?>"),this.catalog_options=ko.observableArray(a.map(c,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_manufacturers_status=ko.observable("<?php echo $aqe_catalog_manufacturers_status; ?>"),this.catalog_manufacturers=ko.observableArray(a.map(d,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_downloads_status=ko.observable("<?php echo $aqe_catalog_downloads_status; ?>"),this.catalog_downloads=ko.observableArray(a.map(u,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_reviews_status=ko.observable("<?php echo $aqe_catalog_reviews_status; ?>"),this.catalog_reviews=ko.observableArray(a.map(b,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_information_status=ko.observable("<?php echo $aqe_catalog_information_status; ?>"),this.catalog_information=ko.observableArray(a.map(w,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.catalog_errors=ko.computed(function(){return!1},t),this.sales_orders_status=ko.observable("<?php echo $aqe_sales_orders_status; ?>"),this.sales_orders=ko.observableArray(a.map(y,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.sales_orders_notify_customer=ko.observable("<?php echo $aqe_sales_orders_notify_customer; ?>"),this.sales_returns_status=ko.observable("<?php echo $aqe_sales_returns_status; ?>"),this.sales_returns=ko.observableArray(a.map(g,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.sales_returns_notify_customer=ko.observable("<?php echo $aqe_sales_returns_notify_customer; ?>"),this.customer_customers_status=ko.observable("<?php echo $aqe_customer_customers_status; ?>"),this.customer_customers=ko.observableArray(a.map(m,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.sales_voucher_themes_status=ko.observable("<?php echo $aqe_sales_voucher_themes_status; ?>"),this.sales_vouchers=ko.observableArray(a.map(v,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.sales_vouchers_status=ko.observable("<?php echo $aqe_sales_vouchers_status; ?>"),this.sales_voucher_themes=ko.observableArray(a.map(k,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.sales_errors=ko.computed(function(){return!1},t),this.customer_errors=ko.computed(function(){return!1},t),this.marketing_campaigns_status=ko.observable("<?php echo $aqe_marketing_campaigns_status; ?>"),this.marketing_campaigns=ko.observableArray(a.map(O,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.marketing_affiliates_status=ko.observable("<?php echo $aqe_marketing_affiliates_status; ?>"),this.marketing_affiliates=ko.observableArray(a.map(P,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.marketing_coupons_status=ko.observable("<?php echo $aqe_marketing_coupons_status; ?>"),this.marketing_coupons=ko.observableArray(a.map(q,function(e,a){return new $(a,e.hasOwnProperty("index")?e.index:0,e.hasOwnProperty("name")?e.name:"<unknown>",e.hasOwnProperty("qe_status")?e.qe_status:1,e.hasOwnProperty("display")?e.display:1,e.hasOwnProperty("editable")?e.editable:1)})),this.marketing_errors=ko.computed(function(){return!1},t),this.settings_errors=ko.computed(function(){var e=!1;for(var a in this)ko.isObservable(t[a])&&"function"==typeof t[a].hasError&&(e|=t[a].hasError());return e},t),t.service_list_loaded=ko.observable(!1),t.service_list_loading=ko.observable(!1),t.services=ko.observableArray([]),t.addService=function(e,a,s,r,o,n){t.services.push(new x(e,a,s,r,o,n))},t.clearServices=function(){t.services.removeAll()}};j.prototype=new e.observable_object_methods,a(function(){var t=window.location.hash,o=t.split("?")[0];s=e.view_model=new j,e.view_models=a.extend({},e.view_models,{ExtVM:e.view_model}),s.applyErrors(r),ko.applyBindings(s,a("#content")[0]),a("#legal_text .modal-body").load("view/static/bull5i_aqe_pro_extension_terms.htm"),a("body").on("shown.bs.tab","a[data-toggle='tab'][href='#ext-support'],a[data-toggle='tab'][href='#services']",function(){e.load_service_list()}),e.onComplete(a("#page-overlay"),a("#content")),e.loading=!0,e.activateTab(o),e.loading=0})}(window.bull5i=window.bull5i||{},jQuery);
//--></script>
<?php echo $footer; ?>
