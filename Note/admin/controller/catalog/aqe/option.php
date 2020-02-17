<?php
class ControllerCatalogAqeOption extends Controller {
	protected $error = array();
	protected $alert = array(
		'error'     => array(),
		'warning'   => array(),
		'success'   => array(),
		'info'      => array()
	);

	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->helper('aqe');

		$this->load->model('catalog/option');
		$this->load->model('catalog/aqe/option');

		$this->load->language('catalog/option');
		$this->load->language('catalog/aqe/general');
		$this->load->language('catalog/aqe/option');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('catalog/option', 'token=' . $this->session->data['token'], true));
		}
	}

	public function index() {
		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function delete() {
		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $item_id) {
				$this->model_catalog_option->deleteOption($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_catalog_options') as $column => $attr) {
				if (isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_saving'] = $this->language->get('text_saving');
		$data['text_copying'] = $this->language->get('text_copying');
		$data['text_deleting'] = $this->language->get('text_deleting');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_batch_edit'] = $this->language->get('text_batch_edit');
		$data['text_autocomplete'] = $this->language->get('text_autocomplete');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_clear_filter'] = $this->language->get('text_clear_filter');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
		$data['text_are_you_sure'] = $this->language->get('text_are_you_sure');
		$data['text_toggle_navigation'] = $this->language->get('text_toggle_navigation');
		$data['text_toggle_dropdown'] = $this->language->get('text_toggle_dropdown');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_image'] = $this->language->get('text_image');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_id'] = $this->language->get('column_id');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_option_value'] = $this->language->get('column_option_value');

		$data['error_ajax_request'] = $this->language->get('error_ajax_request');
		$data['error_update'] = $this->language->get('error_update');
		$data['error_load_popup'] = $this->language->get('error_load_popup');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_close'] = $this->language->get('button_close');
		$data['button_save'] = $this->language->get('button_save');

		$data['aqe_tooltip'] = ($this->config->get('aqe_quick_edit_on') == 'dblclick') ? $this->language->get('text_double_click_edit') : $this->language->get('text_click_edit');
		$data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
		$data['aqe_multilingual_seo'] = $this->config->get('aqe_multilingual_seo');
		$data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
		$data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');

		$this->document->addScript('view/javascript/aqe/catalog.min.js');

		$this->document->addStyle('view/stylesheet/aqe/css/catalog.min.css');

		$filters = array();

		foreach($this->config->get('aqe_catalog_options') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		foreach($this->config->get('aqe_catalog_options') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['alert_icon'] = function($type) {
			$icon = "";
			switch ($type) {
				case 'error':
					$icon = "fa-times-circle";
					break;
				case 'warning':
					$icon = "fa-exclamation-triangle";
					break;
				case 'success':
					$icon = "fa-check-circle";
					break;
				case 'info':
					$icon = "fa-info-circle";
					break;
				default:
					break;
			}
			return $icon;
		};

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			'active'    => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('catalog/option/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/option/delete', 'token=' . $this->session->data['token'] . $url, true);

		$actions = array(
			'option_values'     => array('display' => 1, 'index' =>  1, 'short' => 'opt_val',    'type' =>'opt_vals_qe', 'class' =>            '', 'rel' => array('option_value')),
			'edit'              => array('display' => 1, 'index' =>  4, 'short' =>      'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['filter_actions'] = $actions;

		$columns = $this->config->get('aqe_catalog_options');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);
		}
		uasort($columns, 'column_sort');
		$data['filter_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['options'] = array();

		$filter_data = array(
			'sort'      => $sort,
			'order'     => $order,
			'start'     => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'     => $this->config->get('config_limit_admin'),
			'columns'   => $displayed_columns,
			'actions'   => $displayed_actions
		);

		foreach ($filters as $filter => $value) {
			$filter_data['filter_' . $filter] = $value;
		}

		$results = $this->model_catalog_aqe_option->getOptions($filter_data);

		$option_total = $this->model_catalog_aqe_option->getTotalOptions();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('catalog/option/edit', '&option_id=' . $result['option_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
							'icon'  => 'pencil',
							'name'  => null,
							'rel'   => json_encode(array()),
							'class' => $attr['class'],
						);
						break;
					default:
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => null,
							'icon'  => null,
							'name'  => $this->language->get('action_' . $attr['short']),
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
				}
			}

			$row = array(
				'option_id'  => $result['option_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['name'] = $result['name'];
				$row['sort_order'] = $result['sort_order'];
			} else {
				foreach ($columns as $column => $attr) {
					// if ($column == 'option') {
					// 	$fs = $this->model_catalog_aqe_option->getOptionsByOptionGroupId($result['option_id']);
					// 	$options = array();
					// 	foreach($fs as $option) {
					//  	$option_filters[] = html_entity_decode($filter['name'], ENT_QUOTES, 'UTF-8');
					// 	}
					// 	$row[$column] = implode("<br />", $filters);
					if ($column == 'id') {
						$row[$column] = $result['option_id'];
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'option_value') {
						$row[$column] = $result['option_value_names'];
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else if ($column == 'type') {
						switch ($result[$column]) {
							case 'select':
								$row[$column] = $this->language->get('text_select');
								break;
							case 'radio':
								$row[$column] = $this->language->get('text_radio');
								break;
							case 'checkbox':
								$row[$column] = $this->language->get('text_checkbox');
								break;
							case 'image':
								$row[$column] = $this->language->get('text_image');
								break;
							case 'text':
								$row[$column] = $this->language->get('text_text');
								break;
							case 'textarea':
								$row[$column] = $this->language->get('text_textarea');
								break;
							case 'file':
								$row[$column] = $this->language->get('text_file');
								break;
							case 'date':
								$row[$column] = $this->language->get('text_date');
								break;
							case 'time':
								$row[$column] = $this->language->get('text_time');
								break;
							case 'datetime':
								$row[$column] = $this->language->get('text_datetime');
								break;
							default:
								$row[$column] = '';
								break;
						}
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['options'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'name', 'sort_order', 'action');
			$columns = array();
		} else {
			foreach ($columns as $column => $attr) {
				if (empty($attr['sort'])) {
					$non_sortable[] = 'col_' . $column;
				}

				if (!empty($attr['type']) && !in_array($attr['type'], $type_classes)) {
					$type_classes[] = $attr['type'];
				}

				if (!empty($attr['align'])) {
					if (!empty($attr['type']) && $attr['editable']) {
						$column_classes[] = $attr['align'] . ' ' . $attr['type'];
					} else {
						$column_classes[] = $attr['align'];
					}
				} else {
					if (!empty($attr['type'])) {
						$column_classes[] = $attr['type'];
					} else {
						$column_classes[] = null;
					}
				}
			}
		}

		$data['columns'] = $displayed_columns;
		$data['actions'] = $displayed_actions;
		$data['related'] = $related_columns;
		$data['column_info'] = $columns;
		$data['non_sortable_columns'] = json_enc($non_sortable);
		$data['column_classes'] = $column_classes;
		$data['types'] = $type_classes;

		$data['update_url'] = html_entity_decode($this->url->link('catalog/option/quick_update', 'token=' . $this->session->data['token'], true));
		$data['refresh_url'] = html_entity_decode($this->url->link('catalog/option/refresh_data', 'token=' . $this->session->data['token'], true));
		$data['type_select'] = addslashes(json_encode(array(
			array("type" => "group", "label" => $this->language->get('text_choose'), "values" => array(
				array("id" => "select", "value" => $this->language->get('text_select')),
				array("id" => "radio", "value" => $this->language->get('text_radio')),
				array("id" => "checkbox", "value" => $this->language->get('text_checkbox')),
				array("id" => "image", "value" => $this->language->get('text_image')),
			)),
			array("type" => "group", "label" => $this->language->get('text_input'), "values" => array(
				array("id" => "text", "value" => $this->language->get('text_text')),
				array("id" => "textarea", "value" => $this->language->get('text_textarea')),
			)),
			array("type" => "group", "label" => $this->language->get('text_file'), "values" => array(
				array("id" => "file", "value" => $this->language->get('text_file')),
			)),
			array("type" => "group", "label" => $this->language->get('text_date'), "values" => array(
				array("id" => "date", "value" => $this->language->get('text_date')),
				array("id" => "time", "value" => $this->language->get('text_time')),
				array("id" => "datetime", "value" => $this->language->get('text_datetime')),
			)),
		)));

		$data['load_popup_url'] = html_entity_decode($this->url->link('catalog/option/load_popup', 'token=' . $this->session->data['token'], true));

		$this->load->model('localisation/language');
		$lang_count = $this->model_localisation_language->getTotalLanguages();
		$data['single_lang_editing'] = $this->config->get('aqe_single_language_editing') || ((int)$lang_count == 1);
		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_catalog_options') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sorts'] = array();
		foreach ($this->config->get('aqe_catalog_options') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_catalog_options') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $option_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($option_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($option_total - $this->config->get('config_limit_admin'))) ? $option_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $option_total, ceil($option_total / $this->config->get('config_limit_admin')));

		if (isset($this->session->data['error'])) {
			$this->error = $this->session->data['error'];

			unset($this->session->data['error']);
		}

		if (isset($this->error['warning'])) {
			$this->alert['warning']['warning'] = $this->error['warning'];
		}

		if (isset($this->error['error'])) {
			$this->alert['error']['error'] = $this->error['error'];
		}

		if (isset($this->session->data['success'])) {
			$this->alert['success']['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}

		$data['filters'] = $filters;
		$data['alerts'] = $this->alert;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'catalog/aqe/option_list';
		} else {
			$template = 'catalog/aqe/option_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function autocomplete2() {
		$response = array();

		if (isset($this->request->get['filter_name'])) {

			$filter_types = array('name');
			$filters = array();

			foreach ($filter_types as $filter) {
				$filters[$filter] = (isset($this->request->get['filter_' . $filter])) ? $this->request->get['filter_' . $filter] : null;
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'start'               => 0,
				'limit'               => $limit,
				'columns'             => $filter_types
			);

			foreach($filters as $filter => $value) {
				$filter_data['filter_' . $filter] = $value;
			}

			$results = $this->model_catalog_aqe_option->getOptions($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'option_id'  => $result['option_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		} else if (isset($this->request->get['filter_option_value'])) {
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'start'               => 0,
				'limit'               => $limit,
				'filter_name'         => $this->request->get['filter_option_value']
			);

			$results = $this->model_catalog_aqe_option->getOptionValues($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'option_value_id'   => $result['option_value_id'],
					'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function load_popup() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateLoadPopup($this->request->post)) {
			$data['error_warning'] = '';
			list($data['parameter'], $data['i_id']) = explode("-", $this->request->post['id']);

			$data['token'] = $this->session->data['token'];

			$response["success"] = 1;

			switch ($data['parameter']) {
				case "name":
					$this->load->model('localisation/language');
					$data['languages'] = $this->model_localisation_language->getLanguages();
					$data['value'] = array();
					$descriptions = $this->model_catalog_option->getOptionDescriptions($data['i_id']);
					foreach ($descriptions as $language_id => $value) {
						$data['value'][$language_id] = $value["name"];
					}
					break;
				case "option_value":
				case "option_values":
					$data['entry_option_value'] = $this->language->get('entry_option_value');
					$data['entry_image'] = $this->language->get('entry_image');
					$data['entry_sort_order'] = $this->language->get('entry_sort_order');
					$data['button_remove'] = $this->language->get('button_remove');
					$data['button_option_value_add'] = $this->language->get('button_option_value_add');

					$data['parameter'] = 'option_value';

					$this->load->model('tool/image');

					$this->load->model('localisation/language');
					$data['languages'] = $this->model_localisation_language->getLanguages();
					$data['option_values'] = array();
					
					$option_values = $this->model_catalog_option->getOptionValueDescriptions($data['i_id']);

					foreach ($option_values as $option_value) {
						if (is_file(DIR_IMAGE . $option_value['image'])) {
							$image = $option_value['image'];
							$thumb = $option_value['image'];
						} else {
							$image = '';
							$thumb = 'no_image.png';
						}

						$data['option_values'][] = array(
							'option_value_id'          => $option_value['option_value_id'],
							'option_value_description' => $option_value['option_value_description'],
							'image'                    => $image,
							'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
							'sort_order'               => $option_value['sort_order']
						);
					}

					$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
					break;
				default:
					$response["success"] = 0;
					$response['error'] = $this->language->get('error_load_popup');
					break;
			}
			$response['title'] = $this->language->get('action_' . $data['parameter']);
		} else {
			$this->alert['error']['load'] = $this->language->get('error_load_popup');
		}

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'catalog/aqe/quick_edit_form';
		} else {
			$template = 'catalog/aqe/quick_edit_form.tpl';
		}

		$response['popup'] = $this->load->view($template, $data);

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function refresh_data() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateRefreshData($this->request->post)) {
			$response['values'] = array();

			foreach ($this->request->post['data'] as $column => $options) {
				foreach ($options as $id) {
					switch ($column) {
						case 'option_value':
							$ovs = $this->model_catalog_option->getOptionValues($id);
							$_options = array();
							foreach($ovs as $option) {
								$_options[] = html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8');
							}
							$response['values'][$id][$column] = implode("<br/>", $_options);
							break;
						default:
							$response['value'] = "";
							break;
					}
				}
			}
			$response['success'] = 1;
		}

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function quick_update() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateUpdateData($this->request->post)) {
			list($column, $id) = explode("-", $this->request->post['id']);
			$id = (array)$id;
			$value = $this->request->post['new'];
			$lang_id = isset($this->request->post['lang_id']) ? $this->request->post['lang_id'] : null;
			$alt = isset($this->request->post['alt']) ? $this->request->post['alt'] : "";

			if (isset($this->request->post['ids'])) {
				$id = array_unique(array_merge($id, (array)$this->request->post['ids']));
			}

			$results = array('done' => array(), 'failed' => array());

			foreach ((array)$id as $_id) {
				if ($this->model_catalog_aqe_option->quickEditOption($_id, $column, $value, $lang_id, $this->request->post)) {
					$results['done'][] = $_id;
				} else {
					$results['failed'][] = $_id;
				}
			}

			$response['results'] = $results;

			if ($results['done']) {
				$this->alert['success']['update'] = $this->language->get('text_success');
				$response['success'] = 1;

				if (in_array($column, array('sort_order'))) {
					$response['value'] = (int)$value;
					$response['values']['*'] = $response['value'];
				} else if(in_array($column, array('type'))) {
					switch ($value) {
						case 'select':
							$response['value'] = $this->language->get('text_select');
							break;
						case 'radio':
							$response['value'] = $this->language->get('text_radio');
							break;
						case 'checkbox':
							$response['value'] = $this->language->get('text_checkbox');
							break;
						case 'image':
							$response['value'] = $this->language->get('text_image');
							break;
						case 'text':
							$response['value'] = $this->language->get('text_text');
							break;
						case 'textarea':
							$response['value'] = $this->language->get('text_textarea');
							break;
						case 'file':
							$response['value'] = $this->language->get('text_file');
							break;
						case 'date':
							$response['value'] = $this->language->get('text_date');
							break;
						case 'time':
							$response['value'] = $this->language->get('text_time');
							break;
						case 'datetime':
							$response['value'] = $this->language->get('text_datetime');
							break;
						default:
							$response['value'] = '';
							break;
					}
					$response['values']['*'] = $response['value'];
				} else if(in_array($column, array('name'))) {
					if (isset($this->request->post['value'])) {
						$response['value'] = isset($this->request->post['value'][$this->config->get('config_language_id')]) ? $this->request->post['value'][$this->config->get('config_language_id')] : '';
					} else
						$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				} else if(in_array($column, array('option_value', 'option_values'))) {
					$_option_values = array();

					if (isset($this->request->post['option_value'])) {
						foreach ((array)$this->request->post['option_value'] as $option_value) {
							$_option_values[] = isset($option_value['option_value_description'][$this->config->get('config_language_id')]['name']) ? $option_value['option_value_description'][$this->config->get('config_language_id')]['name'] : '';
						}
					}
					$response['value'] = implode("<br />", $_option_values);
					$response['values']['*'] = $response['value'];
				} else {
					$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				}
			} else {
				$this->alert['error']['result'] = $this->language->get('error_update');
			}
		}

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	protected function validateDelete() {
		$error = !$this->validatePermissions();

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $option_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByOptionId($option_id);

			if ($product_total) {
				$error = true;
				$o = $this->model_catalog_option->getOptionDescriptions($option_id);
				$name = isset($o[$this->config->get('config_language_id')]['name']) ? $o[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $option_id] = sprintf($this->language->get('error_delete'), $name, $product_total);
			}
		}

		return !$error;
	}

	protected function validateLoadPopup(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['id']) || strpos($data['id'], "-") === false) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		return !$errors;
	}

	protected function validateUpdateData(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['id']) || strpos($data['id'], "-") === false) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
			return false;
		}

		list($column, $id) = explode("-", $data['id']);

		if (!isset($data['old'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		if (!isset($data['new'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		if ($column == "name") {
			if (isset($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					if ((utf8_strlen($value) < 1) || (utf8_strlen($value) > 128)) {
						$errors = true;
						$this->error["value[$language_id]"] = $this->language->get('error_name');
					}
				}
			} else {
				if ((utf8_strlen($data['new']) < 1) || (utf8_strlen($data['new']) > 128)) {
					$errors = true;
					$this->alert['error']['name'] = $this->language->get('error_name');
				}
			}
		}

		if (in_array($column, array("option_value", "option_values")) && isset($data['option_value'])) {
			if (!isset($data['i_id'])) {
				$errors = true;
				$this->alert['error']['request'] = $this->language->get('error_update');
			}
			if (isset($data['ids']) && count((array)$data['ids']) > 1) {
				$errors = true;
				$this->alert['error']['request'] = $this->language->get('error_batch_edit_options');
			} else {
				foreach ($data['option_value'] as $option_value_id => $option_value) {
					foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
						if ((utf8_strlen($option_value_description['name']) < 1) || (utf8_strlen($option_value_description['name']) > 128)) {
							$errors = true;
							$this->error["option_value[$option_value_id][option_value_description][$language_id][name]"] = $this->language->get('error_option_value');
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->alert['warning']['warning'])) {
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		return !$errors;
	}

	protected function validateRefreshData(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['data'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
			return false;
		}

		return !$errors;
	}

	private function validatePermissions() {
		if (!$this->user->hasPermission('modify', 'catalog/option')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
